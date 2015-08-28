<?php
$scenario->group('admin');

$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage staff from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'staffs\' page, check page title, header and action buttons');
$I->amOnPage('/admin/staffs');
$I->seeInTitle('Staff ‹ Administrator Panel');
$I->see('Staff', '.page-header h1');
$I->seeLink('+ New', '/admin/staffs/edit');
$I->see('Delete', '.page-header-action');
$I->see('Staff List', 'h3');

//--------------------------------------------------------------------
// Expect list of staffs
//--------------------------------------------------------------------
$I->expectTo('see list of all staffs');
$I->see('Name Email Staff Group Location Date Added Status ID', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no staffs available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter staff list by group, location date or status');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_group]');
$I->seeElement('#filter-form select[name=filter_location]');
$I->seeElement('#filter-form select[name=filter_date]');
$I->seeElement('#filter-form select[name=filter_status]');

//$I->makeScreenshot('staffs_page');

//--------------------------------------------------------------------
//
// I want to add a new staff
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new staff page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Staff: New ‹ Administrator Panel');
$I->see('Staff   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Staff Details', 'Basic Settings']);

// Error due to empty fields
$I->amGoingTo('submit form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The Name field is required', '.text-danger');
$I->see('The Email field is required.', '.text-danger');
$I->see('The Username field is required.', '.text-danger');
$I->see('The Password field is required.', '.text-danger');
$I->see('The Password Confirm field is required.', '.text-danger');
$I->dontSee('The Status field is required.', '.text-danger');

$I->click('Basic Settings', '#nav-tabs');
$I->see('The Department field is required.', '.text-danger');
$I->dontSee('The Location field is required.', '.text-danger');
$I->dontSee('The Timezone field is required.', '.text-danger');
$I->dontSee('The Language field is required.', '.text-danger');

//$I->makeScreenshot('add_staff_page_errors');

// Success with staff added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->click('Staff Details', '#nav-tabs');
$I->fillField('staff_name', 'Test Staff');
$I->fillField('staff_email', 'test_staff@example.com');
$I->fillField('username', 'test_staff');
$I->fillField('password', '123456');
$I->fillField('password_confirm', '123456');
$I->toggleButton('input-status');

$I->click('Basic Settings', '#nav-tabs');
$I->selectOption('select[name=staff_group_id]', 'Delivery');
$I->selectOption('select[name=staff_location_id]', 'Use Default');
$I->selectOption('select[name=timezone]', 'Use Default');
$I->selectOption('select[name=language_id]', 'Use Default');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new staff added to Delivery department and page redirected to staff list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Staff added successfully.', '.alert-success');

$I->amGoingTo('check that added staff appears in list');
$I->see('Test Staff test_staff@example.com Delivery Today Enabled', '#list-form tbody tr');

//$I->makeScreenshot('staff_added');

//--------------------------------------------------------------------
//
// I want to update an existing staff
//
//--------------------------------------------------------------------
$I->amGoingTo('update the first staff in the list');
$I->expectTo('navigate to update an existing staff page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:first-child .btn-edit');
$I->seeInTitle('Staff: Test Staff ‹ Administrator Panel');
$I->see('Staff   Test Staff', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Staff Details', 'Basic Settings']);

// Success with staff updated
$I->amGoingTo('update staff name, location and staff group');
$I->fillField('staff_name', 'Tester Staff');

$I->click('Basic Settings', '#nav-tabs');
$I->selectOption('select[name=staff_group_id]', 'Manager');
$I->selectOption('select[name=staff_location_id]', 'Lewisham');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with staff name, location and group updated');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Staff updated successfully.', '.alert-success');

$I->amGoingTo('check that updated staff appears in list');
$I->see('Tester Staff test_staff@example.com Manager Lewisham Today Enabled', '#list-form tbody tr');

//$I->makeScreenshot('staff_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing staff
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the first staff in the list');
$I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with staff deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Staff deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted staff does not appear in list');
$I->dontSee('Tester Staff test_staff@example.com Delivery Lewisham Today Enabled', '#list-form tbody tr');

//$I->makeScreenshot('staff_deleted');

$I->comment('All Done!');