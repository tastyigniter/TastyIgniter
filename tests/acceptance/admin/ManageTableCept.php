<?php
$scenario->group('admin');

$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage table from the administrator panel');

// Login Test table user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'tables\' page, check page title, header and action buttons');
$I->amOnPage('/admin/tables');
$I->seeInTitle('Tables ‹ Administrator Panel');
$I->see('Tables', '.page-header h1');
$I->seeLink('+ New', '/admin/tables/edit');
$I->see('Delete', '.page-header-action');
$I->see('Table List', 'h3');

//--------------------------------------------------------------------
// Expect list of tables
//--------------------------------------------------------------------
$I->expectTo('see list of all tables');
$I->see('Name Minimum Capacity Status ID', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no tables available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter table list by group, location date or status');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_status]');

//$I->makeScreenshot('tables_page');

//--------------------------------------------------------------------
//
// I want to add a new table
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new table page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Table: New ‹ Administrator Panel');
$I->see('Table   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Table Details']);

// Error due to empty fields
$I->amGoingTo('submit form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The Name field is required', '.text-danger');
$I->see('The Minimum field is required.', '.text-danger');
$I->see('The Capacity field is required.', '.text-danger');
$I->dontSee('The Status field is required.', '.text-danger');

//$I->makeScreenshot('add_table_page_errors');

// Success with table added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->click('Table Details', '#nav-tabs');
$I->fillField('table_name', 'Big Round Table');
$I->fillField('min_capacity', '2');
$I->fillField('max_capacity', '10');
$I->toggleButton('input-status');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new table added and page redirected to table list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Table added successfully.', '.alert-success');

$I->amGoingTo('check that added table appears in list');
$I->see('Big Round Table 2 10 Enabled', '#list-form tbody tr');

//$I->makeScreenshot('table_added');

//--------------------------------------------------------------------
//
// I want to update an existing table
//
//--------------------------------------------------------------------
$I->amGoingTo('update the last table in the list');
$I->expectTo('navigate to update an existing table page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:last-child .btn-edit');
$I->seeInTitle('Table: Big Round Table ‹ Administrator Panel');
$I->see('Table   Big Round Table', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Table Details']);

// Success with table updated
$I->amGoingTo('update table status, minimum and maximum capacity');
$I->fillField('min_capacity', '4');
$I->fillField('max_capacity', '12');
$I->toggleButton('input-status');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with table status, minimum and maximum capacity updated');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Table updated successfully.', '.alert-success');

$I->amGoingTo('check that updated table appears in list');
$I->see('Big Round Table 4 12 Disabled', '#list-form tbody tr');

//$I->makeScreenshot('table_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing table
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the last table in the list');
$I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with table deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Table deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted table does not appear in list');
$I->dontSee('Big Round Table 4 12 Disabled', '#list-form tbody tr');

//$I->makeScreenshot('table_deleted');

$I->comment('All Done!');