<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// our factories live inside admin/system/main, so we need to namespace to them
//Factory::guessFactoryNamesUsing(function (string $modelName) {
//    $modelName = str_replace('\\Models\\', '\\Database\\Factories\\', $modelName);
//    $modelName = str_replace('_model', '', $modelName);
//
//    return Str::singular($modelName).'Factory';
//});

uses(Tests\TestCase::class)->in(__DIR__);

uses(Tests\RefreshDatabase::class)->in('Feature');

uses()->group('feature')->in('Feature');

uses()->group('unit')->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

// expect()->extend('toBeOne', function () {
//     return $this->toBe(1);
// });

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
//function createSuperuser()
//{
//    $staff = Staffs_model::factory()->create();
//    $user = Users_model::factory()->make();
//    $user->staff_id = $staff->staff_id;
//    $user->password = 'password12';
//    $user->save();
//
//    return $user;
//}
//
//function createSuperuserAndLogin(Browser $browser)
//{
//    $user = createSuperuser();
//
//    return $browser->visit('/admin')
//        ->type('username', $user->username)
//        ->type('password', 'password12')
//        ->press('Login')
//        ->waitForReload();
//}