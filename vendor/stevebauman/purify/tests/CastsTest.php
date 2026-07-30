<?php

namespace Stevebauman\Purify\Tests;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;
use Stevebauman\Purify\Casts\PurifyHtmlOnSet;

class CastsTest extends TestCase
{
    public $testInput = '<script>alert("Harmful Script");</script><p style="a {color: #0000ff;}" class="a-different-class">Test<span>bar</span></p>';

    public function test_purifies_on_get_with_default_config()
    {
        $this->app['config']->set('purify.configs.default', [
            'HTML.Allowed' => 'p',
        ]);

        $model = new PurifyingDefaultOnGetModel();
        $model->body = $this->testInput;

        $this->assertEquals($this->testInput, $model->getAttributes()['body']);
        $this->assertEquals('<p>Testbar</p>', $model->body);
    }

    public function test_purifies_on_get_with_custom_config()
    {
        $this->app['config']->set('purify.configs.foo', [
            'HTML.Allowed' => 'p,span',
        ]);

        $model = new PurifyingFooOnGetModel();
        $model->body = $this->testInput;

        $this->assertEquals($this->testInput, $model->getAttributes()['body']);
        $this->assertEquals('<p>Test<span>bar</span></p>', $model->body);
    }

    public function test_returns_null_on_get_when_value_is_null()
    {
        $model = new PurifyingDefaultOnGetModel();
        $model->body = null;

        $this->assertNull($model->body);
    }

    public function test_purifies_on_set_with_default_config()
    {
        $this->app['config']->set('purify.configs.default', [
            'HTML.Allowed' => 'p',
        ]);

        $model = new PurifyingDefaultOnSetModel();
        $model->body = $this->testInput;

        $this->assertEquals('<p>Testbar</p>', $model->getAttributes()['body']);
    }

    public function test_purifies_on_set_with_custom_config()
    {
        $this->app['config']->set('purify.configs.foo', [
            'HTML.Allowed' => 'p,span',
        ]);

        $model = new PurifyingFooOnSetModel();
        $model->body = $this->testInput;

        $this->assertEquals('<p>Test<span>bar</span></p>', $model->getAttributes()['body']);
    }

    public function test_sets_null_on_set_when_value_is_null()
    {
        $model = new PurifyingDefaultOnSetModel();
        $model->body = null;

        $this->assertNull($model->getAttributes()['body']);
    }
}

class PurifyingDefaultOnGetModel extends Model
{
    protected $casts = [
        'body' => PurifyHtmlOnGet::class,
    ];
}

class PurifyingFooOnGetModel extends Model
{
    protected $casts = [
        'body' => PurifyHtmlOnGet::class.':foo',
    ];
}

class PurifyingDefaultOnSetModel extends Model
{
    protected $casts = [
        'body' => PurifyHtmlOnSet::class,
    ];
}

class PurifyingFooOnSetModel extends Model
{
    protected $casts = [
        'body' => PurifyHtmlOnSet::class.':foo',
    ];
}
