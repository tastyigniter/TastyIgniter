<?php

declare(strict_types=1);

namespace Igniter\User\Facades;

use Igniter\User\Auth\UserGuard;
use Igniter\User\Auth\UserProvider;
use Igniter\User\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Cookie\QueueingFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Timebox;
use Override;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method static bool isLogged()
 * @method static bool isSuperUser()
 * @method static User|Authenticatable staff()
 * @method static Collection locations()
 * @method static integer getId()
 * @method static string getUserName()
 * @method static string getUserEmail()
 * @method static string getStaffName()
 * @method static string getStaffEmail()
 * @method static User|null user()
 * @method static int|string|null id()
 * @method static bool once(array $credentials = [])
 * @method static Authenticatable|false onceUsingId(mixed $id)
 * @method static bool validate(array $credentials = [])
 * @method static Response|null basic(string $field = 'email', array $extraConditions = [])
 * @method static Response|null onceBasic(string $field = 'email', array $extraConditions = [])
 * @method static bool attempt(array $credentials = [], bool $remember = false)
 * @method static bool attemptWhen(array $credentials = [], array|callable|null $callbacks = null, bool $remember = false)
 * @method static Authenticatable|false loginUsingId(mixed $id, bool $remember = false)
 * @method static void login(Authenticatable $user, bool $remember = false)
 * @method static void logout()
 * @method static void logoutCurrentDevice()
 * @method static Authenticatable|null logoutOtherDevices(string $password)
 * @method static void attempting(mixed $callback)
 * @method static Authenticatable getLastAttempted()
 * @method static string getName()
 * @method static string getRecallerName()
 * @method static bool viaRemember()
 * @method static UserGuard setRememberDuration(int $minutes)
 * @method static QueueingFactory getCookieJar()
 * @method static void setCookieJar(QueueingFactory $cookie)
 * @method static Dispatcher getDispatcher()
 * @method static void setDispatcher(Dispatcher $events)
 * @method static Session getSession()
 * @method static User|null getUser()
 * @method static UserGuard setUser(Authenticatable $user)
 * @method static Request getRequest()
 * @method static UserGuard setRequest(Request $request)
 * @method static Timebox getTimebox()
 * @method static Authenticatable authenticate()
 * @method static bool hasUser()
 * @method static bool check()
 * @method static bool guest()
 * @method static UserGuard forgetUser()
 * @method static UserProvider getProvider()
 * @method static void setProvider(\Illuminate\Contracts\Auth\UserProvider $provider)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static Authenticatable|\Igniter\User\Auth\Models\User getById(void $identifier)
 * @method static mixed getByToken(void $identifier, void $token)
 * @method static Authenticatable|null getByCredentials(array $credentials)
 * @method static void validateCredentials(\Igniter\User\Auth\Models\User $user, void $credentials)
 * @method static void impersonate(\Igniter\User\Auth\Models\User $user)
 * @method static void stopImpersonate()
 * @method static bool isImpersonator()
 * @method static void getImpersonator()
 *
 * @see UserGuard
 */
class AdminAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @see UserGuard
     */
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return 'admin.auth';
    }
}
