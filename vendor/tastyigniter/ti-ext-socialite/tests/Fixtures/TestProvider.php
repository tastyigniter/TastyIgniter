<?php

declare(strict_types=1);

namespace Igniter\Socialite\Tests\Fixtures;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Classes\BaseProvider;
use Override;

class TestProvider extends BaseProvider
{
    #[Override]
    public function extendSettingsForm(Form $form) {}

    #[Override]
    public function redirectToProvider() {}

    #[Override]
    public function handleProviderCallback() {}
}
