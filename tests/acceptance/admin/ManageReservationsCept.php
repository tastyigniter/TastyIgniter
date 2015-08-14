<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage reservations from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'reservations\' page, check page title, header and action buttons');
$I->amOnPage('/admin/reservations');
$I->seeInTitle('Reservations ‹ Administrator Panel');
$I->see('Reservations', '.page-header h1');
$I->see('Delete', '.page-header-action');
$I->see('Reservation List', 'h3');

//--------------------------------------------------------------------
// Expect list of reservations
//--------------------------------------------------------------------
$I->expectTo('see list of all reservations');
$I->seeTableHeads('#list-form', ['ID', 'Location', 'Customer Name', 'Guest(s)',
    'Table', 'Status', 'Assigned Staff', 'Time - Date']);
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

//--------------------------------------------------------------------
//
// I want to change reservation status and assign
//
//--------------------------------------------------------------------
$I->amGoingTo('view the first reservation from the list of reservations');
$I->seeElement('#list-form tbody tr:last-child .btn-edit');
$I->click('#list-form tbody tr:last-child .btn-edit');
//$I->seeInTitle('Reservation: 2447 ‹ Administrator Panel');
$I->see('Reservation', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');

$I->expectTo('see nav tabs');
$I->seeNavTabs(['Reservation', 'Status & Assign', 'Table', 'Restaurant', 'Customer']);

$I->amGoingTo('change the reservation status from pending to confirmed, then assign');
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

$I->expectTo('see updated status in status history');
$I->click('Status', '#nav-tabs');
$I->see('Admin', '#edit-form #history tbody tr:first-child');
$I->see('Kitchen Staff', '#edit-form #history tbody tr:first-child');
$I->see('Confirmed', '#edit-form #history tbody tr:first-child');
$I->see('Your table reservation has been confirmed.', '#edit-form #history tbody tr:first-child');

$I->comment('All Done!');