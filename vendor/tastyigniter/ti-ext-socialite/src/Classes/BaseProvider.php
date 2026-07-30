<?php

declare(strict_types=1);

namespace Igniter\Socialite\Classes;

use Igniter\Admin\Widgets\Form;
use Igniter\Socialite\Models\Settings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Throwable;

abstract class BaseProvider
{
    protected $provider;

    protected $settings;

    protected static $configCallbacks = [];

    public function __construct(protected $driver = null)
    {
        $this->initialize();
    }

    /**
     * Initialize method called when the social provider is first loaded.
     */
    protected function initialize()
    {
        $this->settings = Settings::instance();

        Socialite::extend($this->driver, function($app) {
            $config = $this->getSetting();
            $config['redirect'] = $this->makeEntryPointUrl('callback');

            return $this->buildProvider($config, $app);
        });
    }

    /**
     * Creates an instance of the social provider using the config values
     * @return mixed
     */
    protected function buildProvider($config, $app)
    {
        foreach (self::$configCallbacks as $callback) {
            $config = $callback($config, $this);
        }

        return Socialite::buildProvider($this->provider, $config);
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getSetting($key = null, $default = null)
    {
        $config = array_get($this->settings->get('providers', []), $this->driver, []);

        if (is_null($key)) {
            return $config;
        }

        return array_get($config, $key, $default);
    }

    /**
     * Utility function, creates a link to a registered entry point.
     *
     * @param string $action Ex. auth or callback
     *
     * @return string
     */
    public function makeEntryPointUrl($action)
    {
        return URL::route('igniter_socialite_provider', [$this->driver, $action], true);
    }

    /**
     * Return true if the settings form has the status 'enabled'.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return !empty($this->getSetting('status', 0));
    }

    public function shouldConfirmEmail($providerUser)
    {
        return false;
    }

    public function handleProviderException(Throwable $ex): void
    {
        if ($ex instanceof InvalidStateException) {
            flash()->error('Invalid State');
        } else {
            Log::error($ex->getMessage());
            flash()->error('Could not read user information from social provider: '.$ex->getMessage());
        }
    }

    /**
     * Add any provider-specific settings to the settings form. Add a partial
     * with a set of steps to follow to retrieve the credentials, an enabled
     * checkbox and the settings fields like so:
     *
     * $form->addFields([
     *        'setup' => [
     *            'type' => 'partial',
     *            'path' => '$/igniter/socialite/socialiteproviders/google/_info.php',
     *            'tab' => 'Google',
     *        ],
     *      'providers[google][status]' => [
     *          'label' => 'Status',
     *          'type' => 'switch',
     *          'default' => true,
     *          'tab' => 'Google',
     *      ],
     *      'providers[google][client_id]' => [
     *          'label' => 'Client ID',
     *          'type' => 'text',
     *          'tab' => 'Google',
     *      ],
     *      ...
     *    ], 'primary');
     *
     * @return void
     */
    abstract public function extendSettingsForm(Form $form);

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return RedirectResponse
     */
    abstract public function redirectToProvider();

    /**
     * Obtain the user information from provider.
     *
     * @return SocialiteUser
     */
    abstract public function handleProviderCallback();

    public static function extendConfig(callable $callback): void
    {
        self::$configCallbacks[] = $callback;
    }
}
