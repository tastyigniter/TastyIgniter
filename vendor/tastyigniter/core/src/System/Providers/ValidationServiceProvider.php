<?php

declare(strict_types=1);

namespace Igniter\System\Providers;

use Igniter\System\Classes\ExtensionManager;
use Illuminate\Support\ServiceProvider;
use Override;

class ValidationServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->registerValidator();
    }

    protected function registerValidator()
    {
        $this->app->resolving('validator', function($validator) {
            $extensions = resolve(ExtensionManager::class)->getRegistrationMethodValues('registerValidationRules');
            foreach ($extensions as $validators) {
                if (!is_array($validators) || empty($validators)) {
                    continue;
                }

                foreach ($validators as $name => $validatorExtension) {
                    $validator->extend($name, $validatorExtension);
                }
            }
        });
    }
}
