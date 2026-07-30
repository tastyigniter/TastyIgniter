<?php

namespace Stevebauman\Purify\Tests;

use HTMLPurifier_CSSDefinition;
use HTMLPurifier_HTMLDefinition;
use Illuminate\Support\Facades\File;
use Stevebauman\Purify\Cache\CacheDefinitionCache;
use Stevebauman\Purify\Definitions\CssDefinition;
use Stevebauman\Purify\Definitions\Definition;
use Stevebauman\Purify\Facades\Purify;
use Stevebauman\Purify\PurifyServiceProvider;

class PurifyTest extends TestCase
{
    public $testInput = '<script>alert("Harmful Script");</script><p style="a {color: #0000ff;}" class="a-different-class">Test</p>';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('purify.serializer', [
            'driver' => 'file',
            'cache' => CacheDefinitionCache::class,
        ]);
    }

    public function test_configuration_file_is_published()
    {
        $this->artisan('vendor:publish', ['--provider' => PurifyServiceProvider::class]);

        $this->assertFileExists(config_path('purify.php'));

        File::delete(config_path('purify.php'));
        File::deleteDirectory(storage_path('app/purify'));
    }

    public function test_input_is_sanitized()
    {
        $cleaned = Purify::clean($this->testInput);

        $expected = '<p>Test</p>';

        $this->assertEquals($expected, $cleaned);
    }

    public function test_input_arrays_are_sanitized()
    {
        $cleaned = Purify::clean([$this->testInput, $this->testInput]);

        $expected = ['<p>Test</p>', '<p>Test</p>'];

        $this->assertEquals($expected, $cleaned);
    }

    public function test_config_alias_is_available()
    {
        $instance = Purify::config();

        $this->assertInstanceOf(\Stevebauman\Purify\Purify::class, $instance);
    }

    public function test_config_set_can_be_chosen()
    {
        $input = '<a href="http://www.google.ca">Google</a>';

        $this->app['config']->set('purify.configs.foo', [
            'HTML.TargetBlank' => true,
        ]);

        $cleaned = Purify::driver('foo')->clean($input);

        $expected = '<a href="http://www.google.ca" target="_blank" rel="noreferrer noopener">Google</a>';

        $this->assertEquals($expected, $cleaned);
    }

    public function test_config_can_be_provided_inline()
    {
        $input = '<a href="http://www.google.ca">Google</a>';

        $cleaned = Purify::config([
            'HTML.TargetBlank' => true,
        ])->clean($input);

        $expected = '<a href="http://www.google.ca" target="_blank" rel="noreferrer noopener">Google</a>';

        $this->assertEquals($expected, $cleaned);
    }

    public function test_configs_are_independent()
    {
        $input = '<a href="http://www.google.ca">Google</a>';

        $this->app['config']->set('purify.configs.foo', [
            'HTML.TargetBlank' => true,
        ]);

        $this->app['config']->set('purify.configs.bar', [
            'HTML.TargetBlank' => true,
            'HTML.TargetNoopener' => false,
        ]);

        $cleaned1 = Purify::clean($input);
        $cleaned2 = Purify::driver('foo')->clean($input);
        $cleaned3 = Purify::driver('bar')->clean($input);

        $expected1 = '<a href="http://www.google.ca">Google</a>';
        $expected2 = '<a href="http://www.google.ca" target="_blank" rel="noreferrer noopener">Google</a>';
        $expected3 = '<a href="http://www.google.ca" target="_blank" rel="noreferrer">Google</a>';

        $this->assertEquals($expected1, $cleaned1);
        $this->assertEquals($expected2, $cleaned2);
        $this->assertEquals($expected3, $cleaned3);
    }

    public function test_custom_definitions_are_applied()
    {
        $this->app['config']->set('purify.definitions', FooDefinition::class);

        $this->assertEquals(
            '<span>Test</span>',
            Purify::clean('<span class="foo">Test</span>')
        );

        $this->assertEquals(
            '<span class="foo">Test</span>',
            Purify::config(['HTML.Allowed' => 'span[class]'])->clean('<span class="foo">Test</span>')
        );

        $this->assertEquals(
            '<span>Test</span>',
            Purify::config(['HTML.Allowed' => 'span[class]'])->clean('<span class="bar">Test</span>')
        );
    }

    public function test_custom_css_definitions_are_applied()
    {
        $this->app['config']->set('purify.css-definitions', FooCssDefinition::class);

        $this->assertEquals(
            '<p>Test</p>',
            Purify::clean('<p style="text-align:left">Test</p>')
        );

        $this->assertEquals(
            '<p>Test</p>',
            Purify::clean('<p style="text-align:right">Test</p>')
        );

        $this->assertEquals(
            '<p style="text-align:center;">Test</p>',
            Purify::clean('<p style="text-align:center;">Test</p>')
        );

        $this->assertEquals(
            '<p style="text-align:start;">Test</p>',
            Purify::clean('<p style="text-align:start;">Test</p>')
        );

        $this->assertEquals(
            '<p style="text-align:end;">Test</p>',
            Purify::clean('<p style="text-align:end;">Test</p>')
        );
    }
}

class FooDefinition implements Definition
{
    public static function apply(HTMLPurifier_HTMLDefinition $definition)
    {
        $definition->addAttribute('span', 'class', 'Enum#foo');
    }
}

class FooCssDefinition implements CssDefinition
{
    public static function apply(HTMLPurifier_CSSDefinition $definition)
    {
        $definition->info['text-align'] = new \HTMLPurifier_AttrDef_Enum(
            ['center', 'start', 'end'],
            false,
        );
    }
}
