<?php
// @group main

$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('add a new and edit existing customer address');

// Login Test user
$I->login('demo@demo.com', 'monday');

//--------------------------------------------------------------------
// Go To Address Book Page
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'address book\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/address');
$I->seeInTitle('Address Book');
$I->see('Address Book', 'h2');
$I->see('My Account Address Book', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Check list of addresses available in the address book
//--------------------------------------------------------------------
$I->expectTo('see list of one or more customer addresses');
$I->seeNumberOfElements('.button-group label.btn', [0,10]); //between 1 and 10 elements
$I->see('5 Paragon Rd', 'address');
$I->see('London E9 7AE', 'address');
$I->see('United Kingdom', 'address');
$I->see('Displaying 1 to', '.pagination-bar');
$I->dontSee('Displaying 0', '.pagination-bar');

//--------------------------------------------------------------------
// Check back navigation link and add new address link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link and add new address link');
$I->seeLink('Back', '/account');
$I->seeLink('Add New Address', '/account/address/edit');

//--------------------------------------------------------------------
//
// I want to add a new customer address
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'add new address\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/address/edit');
$I->seeInTitle('Address Book Edit');
$I->see('Address Book Edit', 'h2');
$I->see('My Account Address Book Address Book Edit', '.breadcrumb');
$I->seeElement('#new-address');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Check back navigation link
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link');
$I->seeLink('Back', '/account/address');

//--------------------------------------------------------------------
// Expect Error with required form field blank
//--------------------------------------------------------------------
$I->amGoingTo('submit form with empty fields');
$I->seeElement('form button[type=submit]');
$I->submitForm('form', [], 'button[type=submit]');

$I->expect('form errors due to empty required form field');
$I->dontSee('Address added/updated successfully.', '.alert-success');
$I->see('The Address 1 field is required.', '.text-danger');
$I->dontSee('The Address 2 field is required.', '.text-danger');
$I->see('The City field is required.', '.text-danger');
$I->dontSee('The State field is required.', '.text-danger');
$I->see('The Postcode field is required.', '.text-danger');
$I->see('United Kingdom', '.form-group');
$I->dontSee('The Country field is required.', '.text-danger');

//--------------------------------------------------------------------
// Error with non permitted characters and incorrect criteria
//--------------------------------------------------------------------
$I->amGoingTo('submit form with incorrect criteria or unacceptable characters');
$bad_fields = [
    // I suppose address_1 is shorter than minimum length of 3
    'address[address_1]'        => 'Te',
    // I suppose address_2 is longer than maximum length of 128
    'address[address_2]'        => 'User User User User User User User User Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest Test TestTest ',
    // I suppose city is shorter than minimum length of 2
    'address[city]'             => 'D',
    // I suppose postcode is longer than maximum length of 11
    'address[postcode]'         => '123456789101112',
    // I suppose 'United Kingdom' is selected
    'address[country]'          => '222',
];

$I->seeElement('button[type=submit]');
$I->submitForm('form', $bad_fields, 'button[type=submit]');

$I->expect('form errors due to incorrect criteria and unacceptable characters');
$I->dontSee('Address added/updated successfully.', '.alert-success');
$I->see('The Address 1 field must be at least 3 characters in length.', '.text-danger');
$I->see('The Address 2 field cannot exceed 128 characters in length.', '.text-danger');
$I->see('The City field must be at least 2 characters in length.', '.text-danger');
$I->see('The Postcode field cannot exceed 11 characters in length.', '.text-danger');
$I->see('United Kingdom', '.form-group');
$I->dontSee('The Country field is required.', '.text-danger');

//--------------------------------------------------------------------
// Successfully add a new address with all required field filled
//--------------------------------------------------------------------
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$fields = [
    'address[address_1]'    => '400 Lewisham Road',
    'address[address_2]'    => 'Apt 545',
    'address[city]'         => 'Lewisham',
    'address[state]'        => 'London',
    'address[postcode]'     => 'SE12 7DH',
    'address[country]'      => '222',
];
$I->submitForm('form', $fields, 'button[type=submit]');

$I->expect('form is submitted without errors and a new customer address is added');
$I->see('Address added/updated successfully.', '.alert-success');
$I->dontSeeElement('.text-danger');
$I->see('400 Lewisham Road', 'address');

//--------------------------------------------------------------------
//
// I want to update an existing customer address
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to existing \'address book edit\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/address');
$I->click('EDIT', '.btn-group label:first-child');
$I->seeInTitle('Address Book Edit');
$I->see('Address Book Edit', 'h2');
$I->see('My Account Address Book Address Book Edit', '.breadcrumb');
$I->dontSeeElement('#new-address');

//--------------------------------------------------------------------
// Successfully update customers address
//--------------------------------------------------------------------
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$fields = [
    'address[address_1]'    => '400 Rachele Road',
    'address[address_2]'    => ' ',
    'address[city]'         => 'Rachele',
    'address[state]'        => 'London',
    'address[postcode]'     => 'QE12 7DH',
    'address[country]'      => '222',
];

$I->seeElement('form button[type=submit]');
$I->submitForm('form', $fields, 'form button[type=submit]');

$I->expect('the form is submitted and customer address is updated');
$I->see('Address added/updated successfully.', '.alert-success');
$I->dontSeeElement('.text-danger');
$I->see('400 Rachele Road', 'address');

$I->comment('All Done!');