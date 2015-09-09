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
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor {

    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     * @param $email
     * @param $password
     */
    public function login($email, $password) {
        $I = $this;

        $I->amGoingTo('log into customer account');

        $I->amOnPage('/logout');
        $I->amOnPage('/login');

        $I->submitForm('#login-form form', ['email' => $email, 'password' => $password], '#login-form button');
    }

    public function adminLogin($username, $password, $user = 'admin') {
        $I = $this;

        // if snapshot exists - skipping login
        if ($I->loadSessionSnapshot('adminLogin')) return;

        $I->amGoingTo('log into administrator panel as ' . $user);

        $I->amOnPage('/admin/logout');
        $I->amOnPage('/admin/login');

        $I->submitForm('#edit-form', ['user' => $username, 'password' => $password], '#edit-form button[type=submit]');

        // saving snapshot
        $I->saveSessionSnapshot('adminLogin');
    }

//    public function seeAccountSidebarLinks() {
//        $I = $this;
//
//        $I->expectTo('see all links in the account sidebar');
//        $I->seeElement('.side-bar .module-box .panel .list-group');
//        $I->see('My Account', '.side-bar .module-box .panel .list-group');
//        $I->see('Edit My Details', '.side-bar .module-box .panel .list-group');
//        $I->see('Address Book', '.side-bar .module-box .panel .list-group');
//        $I->see('Recent Orders', '.side-bar .module-box .panel .list-group');
//        $I->see('Recent Reservations', '.side-bar .module-box .panel .list-group');
//        $I->see('Recent Reviews', '.side-bar .module-box .panel .list-group');
//        $I->see('My Inbox', '.side-bar .module-box .panel .list-group');
//        $I->see('Logout', '.side-bar .module-box .panel .list-group');
//    }
//
//    public function seeNavTabs($links) {
//        $I = $this;
//
//        for ($i = 0; $i < count($links); $i ++) {
//            $I->see($links[$i], '#nav-tabs');
//        }
//    }

    public function toggleButton($locator, $context = '') {
        $I = $this;

        $I->click('label[for=' . $locator . '] + div label.btn:not(.active)');
    }

    public function chooseMedia($what = 'menu category photo') {
        $I = $this;

        $I->amGoingTo("choose {$what} from the media manager");
        $I->click('#select-image');
        $I->switchToIframe('media_manager');
        $I->click('.media-list > div figure');
        $I->click('.btn-choose');
        $I->wait(2);
        $I->switchToIframe();
    }

    public function selectAjaxOption($field, $value = '') {
        $I = $this;

        $I->click($field . ' .select2-choice');
        $I->wait(2);
        $I->pressKey('#select2-drop .select2-input', $value);
        $I->wait(2);
        $I->click('#select2-drop .select2-result-selectable');
    }
}
