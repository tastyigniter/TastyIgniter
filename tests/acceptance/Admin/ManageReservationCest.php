<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageReservationCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->wantTo('view reservations from the administrator panel');

        $I->amOnPage('/admin/reservations');
        $I->seeInTitle('Reservations ‹ Administrator Panel');

        $I->expectTo('see list of all reservations');
        $I->see('ID Location Customer Name Guest(s) Table Status Assigned Staff Time - Date', '#list-form thead tr');
        $I->seeElement('#list-form tbody td');
        $I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
        $I->dontSee('There are no reservations available.', '#list-form');
        $I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

        $I->expectTo('see controls to filter reservation list by location, status or date');
        $I->click('.btn-filter');
        $I->waitForElementVisible('.panel-filter', 2);
        $I->seeElement('#filter-form input[name=filter_search]');
        $I->seeElement('#filter-form select[name=filter_location]');
        $I->seeElement('#filter-form select[name=filter_status]');
        $I->seeElement('#filter-form select[name=filter_date]');
    }

    public function testChangeStatusAndAssignStaff(AcceptanceTester $I) {
        $I->wantTo('change a reservation status');

        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $this->doMakeReservation($I);
            });

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amGoingTo('change the reservation status from pending to confirmed');

        $I->amOnPage('/admin/reservations/edit?id=2451');
        $I->seeInTitle('Reservation: 2451 ‹ Administrator Panel');

        $I->click('Status', '#nav-tabs');
        $I->seeInFormFields('#edit-form', [
            'assignee_id'       => '',
            'status'            => '18',
            'status_comment'    => 'Your table reservation is pending.',
            'notify'            => '0',
        ]);

        $I->selectOption('#edit-form select[name=assignee_id]', 'Kitchen Staff');
        $I->selectOption('#edit-form select[name=status]', 'Confirmed');
        $I->wait(2);
        $I->click('Save', '.page-header-action');

        $I->expectTo('see updated status and assignee staff in status history');
        $I->click('Status', '#nav-tabs');
        $I->see('Confirmed Admin Kitchen Staff Your table reservation has been confirmed.', '#edit-form #history tbody tr');
    }

    protected function doMakeReservation(AcceptanceTester $I) {
        $I->amGoingTo('submit an order for delivery');

        $I->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $I->doFindTable($I);

        $I->amGoingTo('submit the reservation form');
        $I->fillField('confirm_email', 'john.doe@example.com');
        $I->fillField('comment', 'I would like a table by the window');
        $I->fillField('captcha', $I->grabValueFrom('input[name="captcha_word"]'));
        $I->click('#reservation-form button[type=submit]');

        $I->expect('success with the table reserved successfully');
        $I->see('Thanks for reserving with us online', '#page-content p');
    }
}