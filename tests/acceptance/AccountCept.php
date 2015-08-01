<?php
$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('check account dashboard');

// Login Test user
$I->login('demo@demo.com', 'monday');

$I->amGoingTo('navigate to \'account\' page and check page title, header and breadcrumb');
$I->amOnPage('/account');
$I->seeInTitle('My Account');
$I->see('My Account', 'h2');
$I->see('My Account', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Ensure the nav tabs respective data are rendered
//--------------------------------------------------------------------
$I->expect('the nav-tabs is visible');
$I->seeElement('#nav-tabs');

//--------------------------------------------------------------------
// Check all account details
//--------------------------------------------------------------------
$I->amGoingTo('check customer information on account dashboard');
$I->see('My Details', '#nav-tabs');
$I->click('My Details', '#nav-tabs');

$I->expectTo('see all customer information');
$I->see('First Name: Nulla', '#details');
$I->see('Last Name: Ipsum', '#details');
$I->see('Email Address: demo@demo.com', '#details');
$I->see('Password: Change Password', '#details');
$I->see('Telephone: 43434343', '#details');
$I->see('Security Question: Whats your pets name?', '#details');
$I->see('Security Answer: ******', '#details');

//--------------------------------------------------------------------
// Check that only the default address is visible
//--------------------------------------------------------------------
$I->expectTo('already have a customer non default address record in database');
$I->haveInDatabase('ti_addresses', [
    'address_id'        => '100',
    'customer_id'       => '5',
    'address_1'         => '5 Nulla Street',
    'address_2'         => '',
    'city'              => 'London',
    'state'             => '',
    'postcode'          => 'M5 5DA',
    'country_id'        => '222',
]);

$I->amGoingTo('check default address on account dashboard');
$I->see('My Default Address', '#nav-tabs');
$I->click('My Default Address', '#nav-tabs');

$I->expectTo('see only the default address');
$I->dontSee('You don\'t have a default address', '#address');
$I->see('5 Paragon Rd', '#address address');
$I->see('London E9 7AE', '#address address');
$I->see('United Kingdom', '#address address');
$I->dontSee('5 Nulla Street', '#address address');
$I->dontSee('London M5 5DA', '#address address');

//--------------------------------------------------------------------
// Check that shopping cart does not displays items when empty and vice-versa.
//--------------------------------------------------------------------
$I->amGoingTo('check shopping cart on account dashboard');
$I->see('My Shopping Cart', '#nav-tabs');
$I->click('My Shopping Cart', '#nav-tabs');

$I->expectTo('see an empty shopping cart');
$I->see('There are no menus added in your cart.', '#cart');
$I->dontSee('Total Items Total Amount', '#cart');
$I->dontSee('CHECKOUT NOW', '#cart');

$I->amGoingTo('add menu to shopping cart');
$I->lookForwardTo('can view cart items on account dashboard');
$I->expect('items in shopping cart to be listed');

//--------------------------------------------------------------------
// Check that recent orders are visible
//--------------------------------------------------------------------
$I->amGoingTo('check recent orders on account dashboard');
$I->see('Recent Orders', '#nav-tabs');
$I->click('Recent Orders', '#nav-tabs');

$I->expectTo('see no more than 5 recent orders');
$I->dontSee('There are no orders available to show.', '#orders');
$I->see('ID Status Date/Time', '#orders');
$I->seeNumberOfElements('#orders tbody tr', [1,5]); //between 1 and 5 elements

//--------------------------------------------------------------------
// Check that recent reservations are visible
//--------------------------------------------------------------------
$I->amGoingTo('check recent reservations on account dashboard');
$I->see('Recent Reservations', '#nav-tabs');
$I->click('Recent Reservations', '#nav-tabs');

$I->expectTo('see no recent reservations');
$I->dontSee('ID Status Date/Time', '#reservations');
$I->see('There are no reservations available to show.', '#reservations');
//$I->seeNumberOfElements('#reservations tbody tr', [0,5]); //between 0 and 5 elements

//--------------------------------------------------------------------
// Check that inbox messages are visible
//--------------------------------------------------------------------
$I->amGoingTo('check inbox messages on account dashboard');
$I->see('My Inbox', '#nav-tabs');
$I->click('My Inbox', '#nav-tabs');

$I->expectTo('see at least one inbox message');
$I->dontSee('There are no messages available to show', '#inbox');
$I->see('Date/Time Subject', '#inbox');
$I->seeNumberOfElements('#orders tbody tr', [0,5]); //between 0 and 5 elements

$I->comment('All Done!');