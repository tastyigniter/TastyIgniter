<?php

declare(strict_types=1);

namespace Igniter\User\Facades;

use Igniter\User\Auth\CustomerGuard;
use Igniter\User\Auth\UserProvider;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Illuminate\Contracts\Cookie\QueueingFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Timebox;
use Override;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method static Customer|null customer()
 * @method static bool isLogged()
 * @method static null|int getId()
 * @method static null|string getFullName()
 * @method static null|string getFirstName()
 * @method static null|string getLastName()
 * @method static null|string getEmail()
 * @method static null|string getTelephone()
 * @method static null|string getAddressId()
 * @method static null|string getGroupId()
 * @method static Customer|null user()
 * @method static int|string|null id()
 * @method static bool once(array $credentials = [])
 * @method static Customer|false onceUsingId(mixed $id)
 * @method static bool validate(array $credentials = [])
 * @method static Response|null basic(string $field = 'email', array $extraConditions = [])
 * @method static Response|null onceBasic(string $field = 'email', array $extraConditions = [])
 * @method static bool attempt(array $credentials = [], bool $remember = false)
 * @method static bool attemptWhen(array $credentials = [], array|callable|null $callbacks = null, bool $remember = false)
 * @method static Customer|false loginUsingId(mixed $id, bool $remember = false)
 * @method static void login(Customer $user, bool $remember = false)
 * @method static void logout()
 * @method static void logoutCurrentDevice()
 * @method static Customer|null logoutOtherDevices(string $password)
 * @method static void attempting(mixed $callback)
 * @method static Customer getLastAttempted()
 * @method static string getName()
 * @method static string getRecallerName()
 * @method static bool viaRemember()
 * @method static CustomerGuard setRememberDuration(int $minutes)
 * @method static QueueingFactory getCookieJar()
 * @method static void setCookieJar(QueueingFactory $cookie)
 * @method static Dispatcher getDispatcher()
 * @method static void setDispatcher(Dispatcher $events)
 * @method static Session getSession()
 * @method static Customer|null getUser()
 * @method static CustomerGuard setUser(Customer $user)
 * @method static Request getRequest()
 * @method static CustomerGuard setRequest(Request $request)
 * @method static Timebox getTimebox()
 * @method static Customer authenticate()
 * @method static bool hasUser()
 * @method static bool check()
 * @method static bool guest()
 * @method static CustomerGuard forgetUser()
 * @method static UserProvider getProvider()
 * @method static void setProvider(\Illuminate\Contracts\Auth\UserProvider $provider)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static Customer getById(void $identifier)
 * @method static mixed getByToken(void $identifier, void $token)
 * @method static Customer|null getByCredentials(array $credentials)
 * @method static void validateCredentials(Customer $user, void $credentials)
 * @method static void impersonate(\Igniter\User\Auth\Models\User $user)
 * @method static void stopImpersonate()
 * @method static bool isImpersonator()
 * @method static null|User getImpersonator()
 *
 * @see CustomerGuard
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'main.auth';
    }
}
