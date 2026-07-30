<?php

declare(strict_types=1);

namespace Igniter\Flame\Translation;

use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Session;

class Localization
{
    protected $sessionKey = 'igniter.translation.locale';

    public function __construct(protected Request $request, protected Repository $config) {}

    public function loadLocale(): void
    {
        $locale = $this->getLocale();

        if ($this->config['app.locale'] != $locale) {
            $this->setLocale($locale);
        }
    }

    public function loadLocaleFromBrowser(): bool
    {
        if (!$this->detectBrowserLocale()) {
            return false;
        }

        $locale = $this->getBrowserLocale();
        if (!$locale || !$this->isValid($locale)) {
            return false;
        }

        $this->setLocale($locale);

        return true;
    }

    public function loadLocaleFromRequest(): bool
    {
        $locale = $this->getRequestLocale();
        if (!$locale || !$this->isValid($locale)) {
            return false;
        }

        $this->setLocale($locale);

        return true;
    }

    public function loadLocaleFromSession(): bool
    {
        $locale = $this->getSessionLocale();
        if (!$locale || !$this->isValid($locale)) {
            return false;
        }

        $this->setLocale($locale);

        return true;
    }

    public function setLocale($locale): ?bool
    {
        if (!$this->isValid($locale)) {
            return false;
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return null;
    }

    public function getLocale()
    {
        $sessionLocale = $this->getSessionLocale();
        if ($sessionLocale && $this->isValid($sessionLocale)) {
            return $sessionLocale;
        }

        return $this->getConfig('locale');
    }

    public function getDefaultLocale()
    {
        return $this->getConfig('locale');
    }

    public function supportedLocales()
    {
        return $this->getConfig('supportedLocales') ?: [];
    }

    public function detectBrowserLocale(): bool
    {
        return (bool)$this->getConfig('detectBrowserLocale');
    }

    public function isValid($locale): bool
    {
        return in_array($locale, $this->supportedLocales());
    }

    public function setSessionLocale($locale): void
    {
        Session::put($this->sessionKey, $locale);
    }

    public function getSessionLocale()
    {
        return Session::get($this->sessionKey);
    }

    public function getRequestLocale()
    {
        return RequestFacade::segment(1);
    }

    public function getBrowserLocale(): string
    {
        return substr((string)$this->request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
    }

    protected function getConfig(string $string)
    {
        return $this->config['localization.'.$string];
    }
}
