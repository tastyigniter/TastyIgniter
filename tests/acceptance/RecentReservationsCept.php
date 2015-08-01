<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('view a customer recent reservation list');

// Log in Test User
$I->login('demo@demo.com', 'monday');

$I->amOnPage('/account/reservations');
$I->see('Recent Reservations', 'h2');
$I->seeElement('.breadcrumb');

//--------------------------------------------------------------------
// Expect recent reservations list to be empty
//--------------------------------------------------------------------
$I->expect('the reservations list to be empty');
$I->see('Reservation ID', '.reservations-lists thead th');
$I->see('Status', '.reservations-lists thead th');
$I->see('Location', '.reservations-lists thead th');
$I->see('Time - Date', '.reservations-lists thead th');
$I->see('Table Name', '.reservations-lists thead th');
$I->see('Guest Number', '.reservations-lists thead th');
$I->see('There are no reservation(s).', '.reservations-lists td');
$I->see('Displaying');  // ensure pagination is present.

//--------------------------------------------------------------------
// Expect back and make reservation links work.
//--------------------------------------------------------------------
$I->expect('the back and make reservation buttons to be linked');
$I->click('Back');
$I->see('My Account', 'h2');

$I->amOnPage('/account/reservations');
$I->click('Make Reservation');
$I->see('Reserve A Table', 'h2');

//
//// Navigate to Order #20015 View Page
//$I->amOnPage('/account/orders/view/20015');
//$I->seeInCurrentUrl('orders/view/20015');
//$I->see('My Order View', 'h2');
//$I->seeElement('.breadcrumb');
//
////--------------------------------------------------------------------
//// Expect all order info to be displayed -- for delivery order**
////--------------------------------------------------------------------
//$I->see('ID:', 'table td b');
//$I->see('20015', 'table td');
//$I->see('Ready Time - Date:', 'table td b');
//$I->see('16:39 - 15 Jul 15', 'table td');
//$I->see('Order Type:', 'table td b');
//$I->see('Delivery', 'table td');
//$I->see('Delivery:', 'table td b');
//$I->see('5 Paragon Rd', 'table td');
//$I->see('Location:', 'table td b');
//$I->see('Lewisham', 'table td');
//
//--------------------------------------------------------------------
// Expect order menu and options to be displayed
//--------------------------------------------------------------------
//$I->see('Name/Options', 'table th');
//$I->see('Price', 'table th');
//$I->see('Total', 'table th');
//$I->see('100x', 'table td');
//$I->see('Whole catfish with rice and vegetables', 'table td');
//$I->see('+ Chicken, Jalapenos, Peperoni, Sweetcorn', 'table td');
//$I->see('£25.96', 'table td');
//$I->see('£2,596.00', 'table td');
//$I->see('Delivery', 'table td b');
//$I->see('£10.00', 'table td b');
//$I->see('Order Total', 'table td b');
//$I->see('£2,770.67', 'table td b');