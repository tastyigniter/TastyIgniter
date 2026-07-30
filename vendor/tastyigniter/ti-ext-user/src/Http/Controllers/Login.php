<?php

declare(strict_types=1);

namespace Igniter\User\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\Template;
use Igniter\Admin\Helpers\AdminHelper;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Country;
use Igniter\System\Models\Language;
use Igniter\System\Models\Settings;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Igniter\User\Models\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class Login extends AdminController
{
    public ?string $bodyClass = 'page-login';

    public static bool $skipRouteRegister = true;

    public function __construct()
    {
        $this->middleware('throttle:'.config('igniter-auth.rateLimiter', '6,1'));
        parent::__construct();
    }

    public function index(): RedirectResponse|string
    {
        // Redirect /admin to /admin/login
        if (!request()->routeIs('igniter.admin.login')) {
            return AdminHelper::redirect('login');
        }

        if (AdminAuth::isLogged()) {
            return AdminHelper::redirect('dashboard');
        }

        $createSuperAdmin = User::query()->doesntExist();
        Template::setTitle($createSuperAdmin
            ? lang('igniter.user::default.login.text_initial_setup_title')
            : lang('igniter.user::default.login.text_title'),
        );

        return $this->makeView($createSuperAdmin ? 'auth.start' : 'auth.login');
    }

    public function reset(): RedirectResponse|string
    {
        if (AdminAuth::isLogged()) {
            return AdminHelper::redirect('dashboard');
        }

        $code = input('code', '');
        if (strlen((string)$code) && !User::query()->whereResetCode($code)->first()) {
            flash()->error(lang('igniter.user::default.login.alert_failed_reset'));

            return AdminHelper::redirect('login');
        }

        Template::setTitle(lang('igniter.user::default.login.text_password_reset_title'));

        $this->vars['resetCode'] = input('code');

        return $this->makeView('auth.reset');
    }

    public function onCompleteSetup(): RedirectResponse
    {
        $data = $this->validatePasses(post(), [
            'name' => ['required', 'string', 'between:2,255'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)->numbers()->symbols()->letters()->mixedCase(), 'same:password_confirm'],
            'restaurant_name' => ['required', 'string', 'between:2,255'],
            'restaurant_email' => ['required', 'email'],
            'telephone' => ['nullable', 'string'],
            'address_1' => ['required', 'string', 'between:2,255'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'postcode' => ['required', 'string'],
            'country_id' => ['required', 'integer'],
        ], [], [
            'name' => lang('igniter::admin.label_name'),
            'email' => lang('igniter.user::default.login.label_email'),
            'password' => lang('igniter.user::default.login.label_password'),
        ]);

        if (!$data) {
            return redirect()->back()->withInput(post());
        }

        User::query()->doesntExistOr(function(): void {
            throw FlashException::error(lang('igniter.user::default.login.alert_super_admin_already_exists'));
        });

        AdminAuth::getProvider()->register([
            'email' => $data['email'],
            'name' => $data['name'],
            'language_id' => Language::first()->language_id,
            'user_role_id' => UserRole::first()->user_role_id,
            'username' => 'admin',
            'password' => $data['password'],
            'super_user' => true,
            'groups' => [UserGroup::first()->user_group_id],
            'locations' => [Location::first()->location_id],
        ], true);

        Location::first()->updateQuietly([
            'location_name' => $data['restaurant_name'],
            'location_email' => $data['restaurant_email'],
            'location_telephone' => $data['telephone'],
            'location_address_1' => $data['address_1'],
            'location_city' => $data['city'],
            'location_state' => $data['state'],
            'location_postcode' => $data['postcode'],
            'location_country_id' => $data['country_id'],
        ]);

        Country::updateDefault($data['country_id']);

        Settings::set([
            'site_name' => $data['restaurant_name'],
            'site_email' => $data['restaurant_email'],
            'sender_name' => $data['restaurant_name'],
            'sender_email' => $data['restaurant_email'],
        ]);

        flash()->overlay(lang('igniter.user::default.login.alert_super_admin_created'));

        return AdminHelper::redirect('login');
    }

    public function onLogin(): RedirectResponse
    {
        $data = $this->validate(post(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [], [
            'email' => lang('igniter.user::default.login.label_email'),
            'password' => lang('igniter.user::default.login.label_password'),
        ]);

        Event::dispatch('igniter.admin.beforeAuthenticate', [$data]);

        if (!AdminAuth::check() && !AdminAuth::attempt(array_only($data, ['email', 'password']), true)) {
            throw ValidationException::withMessages(['email' => lang('igniter.user::default.login.alert_login_failed')]);
        }

        session()->regenerate();

        return ($redirectUrl = input('redirect'))
            ? AdminHelper::redirect($redirectUrl)
            : AdminHelper::redirectIntended('dashboard');
    }

    public function onRequestResetPassword(): RedirectResponse
    {
        $data = $this->validate(post(), [
            'email' => ['required', 'email:filter', 'max:96'],
        ], [], [
            'email' => lang('igniter::admin.label_email'),
        ]);

        if ($user = User::query()->whereEmail($data['email'])->first()) {
            /** @var User $user */
            $user->resetPassword();
            $user->mailSendResetPasswordRequest([
                'reset_link' => admin_url('login/reset?code='.$user->reset_code),
            ]);
        }

        flash()->success(lang('igniter.user::default.login.alert_email_sent'));

        return AdminHelper::redirect('login');
    }

    public function onResetPassword(): RedirectResponse
    {
        $data = $this->validate(post(), [
            'code' => ['required'],
            'password' => ['required', Password::min(8)->numbers()->symbols()->letters()->mixedCase(), 'same:password_confirm'],
            'password_confirm' => ['required'],
        ], [], [
            'code' => lang('igniter.user::default.login.label_reset_code'),
            'password' => lang('igniter.user::default.login.label_password'),
            'password_confirm' => lang('igniter.user::default.login.label_password_confirm'),
        ]);

        $code = array_get($data, 'code');
        /** @var null|User $user */
        $user = User::query()->whereResetCode($code)->first();

        if (!$user || !$user->completeResetPassword($data['code'], $data['password'])) {
            throw ValidationException::withMessages(['password' => lang('igniter.user::default.login.alert_failed_reset')]);
        }

        $user->mailSendResetPassword(['login_link' => admin_url('login')]);

        flash()->success(lang('igniter.user::default.login.alert_success_reset'));

        return AdminHelper::redirect('login');
    }
}
