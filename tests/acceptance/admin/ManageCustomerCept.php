<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage customer from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'customers\' page, check page title, header and action buttons');
$I->amOnPage('/admin/customers');
$I->seeInTitle('Customers ‹ Administrator Panel');
$I->see('Customers', '.page-header h1');
$I->seeLink('+ New', '/admin/customers/edit');
$I->see('Delete', '.page-header-action');
$I->see('Customer List', 'h3');

//--------------------------------------------------------------------
// Expect list of customers
//--------------------------------------------------------------------
$I->expectTo('see list of all customers');
$I->see('First Name Last Name Email Telephone Date Added Status ID', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no customers available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter customer list by date or status');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_date]');
$I->seeElement('#filter-form select[name=filter_status]');

//$I->makeScreenshot('customers_page');

//--------------------------------------------------------------------
//
// I want to add a new customer
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new customer page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Customer: New ‹ Administrator Panel');
$I->see('Customer   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Customer', 'Address']);

// Error due to empty fields
$I->amGoingTo('submit customer form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The First Name field is required', '.text-danger');
$I->see('The Last Name field is required.', '.text-danger');
$I->see('The Email field is required.', '.text-danger');
$I->see('The Telephone field is required.', '.text-danger');
$I->see('The Password field is required.', '.text-danger');
$I->see('The Confirm Password field is required.', '.text-danger');
$I->see('The Security Question field is required.', '.text-danger');
$I->see('The Security Answer field is required.', '.text-danger');
$I->dontSee('The Customer Group field is required.', '.text-danger');
$I->dontSee('The Newsletter field is required.', '.text-danger');
$I->dontSee('The Status field is required.', '.text-danger');

//$I->makeScreenshot('add_customer_page_errors');

// Success with customer added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->fillField('first_name', 'Test');
$I->fillField('last_name', 'Customer');
$I->fillField('email', 'test_customer@example.com');
$I->fillField('telephone', '203203206');
$I->fillField('password', '123456');
$I->fillField('confirm_password', '123456');
$I->selectOption('select[name=security_question_id]', 'Whats your pets name?');
$I->fillField('security_answer', 'Petie');
$I->selectOption('select[name=customer_group_id]', 'Default');
$I->toggleButton('input-newsletter');
$I->toggleButton('input-status');

$I->expectTo('add a single address');
$I->click('Address', '#nav-tabs');
$I->click('#sub-tabs .add_address a');
$I->fillField('address[1][address_1]', '1 Test Address');
$I->fillField('address[1][address_2]', 'Test address 2');
$I->fillField('address[1][city]', 'City');
$I->fillField('address[1][postcode]', 'M94BL');
$I->selectOption('address[1][country_id]', 'United Kingdom');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new customer added and page redirected to customer list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Customer added successfully.', '.alert-success');

$I->amGoingTo('check that added customer appears in list');
$I->see('Test Customer test_customer@example.com 203203206 Today Enabled', '#list-form tbody tr');

//$I->makeScreenshot('customer_added');

//--------------------------------------------------------------------
//
// I want to update an existing customer
//
//--------------------------------------------------------------------
$I->amGoingTo('update the first customer in the list');
$I->expectTo('navigate to update an existing customer page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:first-child .btn-edit');
$I->seeInTitle('Customer: Test Customer ‹ Administrator Panel');
$I->see('Customer   Test Customer', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Customer', 'Address']);

// Success with customer updated
$I->amGoingTo('update customer detailsl, add new customer address, un-subscribe from newsletter');
$I->fillField('first_name', 'Tester');
$I->fillField('last_name', 'Cust');
$I->fillField('telephone', '200003206');
$I->toggleButton('input-newsletter');

$I->expectTo('add a single address');
$I->click('Address', '#nav-tabs');
$I->click('#sub-tabs .add_address a');
$I->fillField('address[2][address_1]', '100 Test Address');
$I->fillField('address[2][address_2]', 'Test address 2');
$I->fillField('address[2][city]', 'City');
$I->fillField('address[2][postcode]', 'M194BL');
$I->selectOption('address[2][country_id]', 'United Kingdom');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with customer un-subscribed, password changed and new address added');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Customer updated successfully.', '.alert-success');

$I->amGoingTo('check that updated customer appears in list');
$I->see('Tester Cust test_customer@example.com 200003206 Today Enabled', '#list-form tbody tr');

//$I->makeScreenshot('customer_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing customer
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the first customer in the list');
$I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with customer deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Customer deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted customer does not appear in list');
$I->dontSee('Tester Cust test_customer@example.com 200003206 Today Enabled', '#list-form tbody tr');

//$I->makeScreenshot('customer_deleted');

$I->comment('All Done!');