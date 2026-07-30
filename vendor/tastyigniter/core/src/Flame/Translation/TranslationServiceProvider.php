<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation;

use Igniter\Flame\Translation\Drivers\Database;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Translation\TranslationServiceProvider as BaseServiceProvider;
use Override;
use ReflectionClass;

class TranslationServiceProvider extends BaseServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->register(BaseServiceProvider::class);

        $this->registerLoader();

        $this->app->singleton('translator', function(Application $app): Translator {
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $loader->addDriver(Database::class);

            $trans = new Translator($loader, $locale);

            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });

        $this->app->singleton('translator.localization', fn(Application $app): Localization => new Localization($app['request'], $app['config']));

        $this->app->alias('translator', Translator::class);
        $this->app->alias('translator.localization', Localization::class);
    }

    #[Override]
    protected function registerLoader(): void
    {
        $this->app->singleton('translation.loader', function(Application $app): FileLoader {
            $reflection = new ReflectionClass(BaseServiceProvider::class);
            $dir = dirname($reflection->getFileName());

            return new FileLoader($app['files'], [$dir.'/lang', $app['path.lang']]);
        });
    }
}
