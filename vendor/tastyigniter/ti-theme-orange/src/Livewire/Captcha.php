<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire;

use Igniter\Frontend\Models\CaptchaSettings;
use Igniter\Main\Traits\ConfigurableComponent;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Captcha extends Component
{
    use ConfigurableComponent;

    public string $apiKey = '';

    public string $lang = '';

    public static function componentMeta(): array
    {
        return [
            'code' => 'igniter-orange::captcha',
            'name' => 'igniter.orange::default.component_captcha_title',
            'description' => 'igniter.orange::default.component_captcha_desc',
        ];
    }

    public function mount(): void
    {
        $this->apiKey = CaptchaSettings::getApiSecretKey();
        $this->lang = CaptchaSettings::getLang();
    }

    public function render(): View
    {
        return view('igniter-orange::livewire.captcha');
    }
}
