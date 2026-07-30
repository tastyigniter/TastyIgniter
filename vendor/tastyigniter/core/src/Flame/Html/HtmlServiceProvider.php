<?php

declare(strict_types=1);

namespace Igniter\Flame\Html;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Override;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    #[Override]
    public function register(): void
    {
        $this->registerHtmlBuilder();

        $this->registerFormBuilder();

        $this->app->alias('html', HtmlBuilder::class);
        $this->app->alias('form', FormBuilder::class);
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', fn(Application $app): HtmlBuilder => new HtmlBuilder);
    }

    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton('form', function(Application $app): FormBuilder {
            $form = new FormBuilder($app['html'], $app['url'], $app['view'], $app['session.store']->token(), $app['request']);

            return $form->setSessionStore($app['session.store']);
        });
    }
}
