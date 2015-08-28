<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     * @param $email
     * @param $password
     */
    public function login($email, $password)
    {
        $I = $this;
        $I->amGoingTo('log into customer account');

        // if snapshot exists - skipping login
//        if ($I->loadSessionSnapshot('login')) return;

        // Create new record in database for test customer
//        $I->haveInDatabase('ti_customers', [
//            'customer_id'    => 100,
//            'first_name'    => 'Nulla',
//            'last_name'    => 'Ipsum',
//            'email' => $email,
//            'password' => sha1('ee9c4c289' . sha1('ee9c4c289' . sha1($password))),  // 'monday'
//            'salt' => 'ee9c4c289',
//            'telephone' => '43434343',
//            'address_id' => '1',
//            'security_question_id' => '11',
//            'security_answer' => 'Spike',
//            'newsletter' => '1',
//            'customer_group_id' => '11',
//            'ip_address' => '::1',
//            'date_added' => date('Y-m-d H:i:s', strtotime('-1 month')),
//            'status' => 1,
//        ]);

        $I->amOnPage('/logout');

        $I->amOnPage('/login');

        $I->submitForm('#login-form form', ['email' => $email, 'password' => $password], '#login-form button');

        // saving snapshot
//        $I->saveSessionSnapshot('login');
    }

    public function adminLogin($username, $password, $user = 'admin') {
        $I = $this;
        $I->amGoingTo('log into administrator panel as '. $user);

        $I->amOnPage('/admin');

        $I->submitForm('#edit-form', ['user' => $username, 'password' => $password], '#edit-form button[type=submit]');
    }

    public function seeAccountSidebarLinks() {
        $I = $this;

        $I->expectTo('see all links in the account sidebar');
        $I->seeElement('.side-bar .module-box .panel .list-group');
        $I->see('My Account', '.side-bar .module-box .panel .list-group');
        $I->see('Edit My Details', '.side-bar .module-box .panel .list-group');
        $I->see('Address Book', '.side-bar .module-box .panel .list-group');
        $I->see('Recent Orders', '.side-bar .module-box .panel .list-group');
        $I->see('Recent Reservations', '.side-bar .module-box .panel .list-group');
        $I->see('Recent Reviews', '.side-bar .module-box .panel .list-group');
        $I->see('My Inbox', '.side-bar .module-box .panel .list-group');
        $I->see('Logout', '.side-bar .module-box .panel .list-group');
    }

    public function seeNavTabs($links) {
        $I = $this;

        for ($i = 0; $i < count($links); $i++) {
            $I->see($links[$i], '#nav-tabs');
        }
    }

    public function toggleButton($locator, $context = '') {
        $I = $this;

        $I->click('label[for='.$locator.'] + div label.btn:not(.active)');
    }
}
