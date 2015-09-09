<?php
namespace Main\Acceptance;

use \AcceptanceTester;
use Helper\MainAcceptance;

/**
 * @group main
 */
class ReservationCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Customer');
    }

    public function testDateField(AcceptanceTester $I) {
        $I->wantTo('make a table reservation');
        $I->lookForwardTo('reserve table for a past date');

        $I->amOnPage('/reservation');

        $I->selectOption('location', 'Lewisham');
        $I->selectOption('guest_num', '4');
        $I->fillField('reserve_date', date('d-m-Y', strtotime('- 1 day', time())));
        $I->fillField('reserve_time', '2:45 PM');
        $I->click('Find Table', '#find-table-form');

        $I->expect('form errors due to the past date entered');
        $I->see('Date must be after today, you can only make future reservations!', '.text-danger');
    }

    public function testTimeField(AcceptanceTester $I) {
        $I->wantTo('make a table reservation');
        $I->lookForwardTo('reserve table for a past time');

        $I->amOnPage('/reservation');

        $I->selectOption('location', 'Lewisham');
        $I->selectOption('guest_num', '4');
        $I->fillField('reserve_date', date('d-m-Y', time()));
        $I->fillField('reserve_time', date('g:i A', strtotime('- 1 minute', time())));
        $I->click('Find Table', '#find-table-form');

        $I->expect('form errors due to the past time entered');
        $I->see('Date must be after today, you can only make future reservations!', '.text-danger');
    }

    public function testMakeReservation(AcceptanceTester $I) {
        $I->wantTo('make a reservation');

        $I->doFindTable($I);

        $I->amGoingTo('submit the reservation form');

        $fields = [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'john.doe@example.com',
            'confirm_email'         => 'john.doe@example.com',
            'telephone'             => '0123456789',
            'comment'               => 'I would like a table by the window',
            'captcha'               => $I->grabValueFrom('input[name="captcha_word"]'),
        ];
        $I->submitForm('#reservation-form', $fields, '#reservation-form button[type=submit]');

        $I->expect('success with the table reserved successfully');
        $I->see('Your reservation at Lewisham has been booked for 4 person(s)', '#page-content p');
        $I->see('Thanks for reserving with us online', '#page-content p');
    }

    public function testRecentReservation(AcceptanceTester $I) {
        $I->wantTo('make a reservation');
        $I->lookForwardTo('view the reservation under the account recent reservations');

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

        $I->amGoingTo('view the recent reservations');
        $I->amOnPage('/account/reservations');

        $I->dontSee('There are no reservation(s).', '.reservations-lists');
        $I->seeNumberOfElements('.reservations-lists tbody tr', [1,10]); //between 1 and 10 elements
        $I->seeElement('.reservations-lists tbody td');
        $I->seeElement('.pagination-bar  .info > span');
        $I->see('Pending Lewisham 15:00 - '. date('d M y', strtotime('+ 1 month', time())) .' EW77 4', '.reservations-lists tbody tr');
    }
}
