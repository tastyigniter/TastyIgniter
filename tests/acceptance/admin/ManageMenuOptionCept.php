<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage menu option from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'menu options\' page, check page title, header and action buttons');
$I->amOnPage('/admin/menu_options');
$I->seeInTitle('Menu Options ‹ Administrator Panel');
$I->see('Menu Options', '.page-header h1');
$I->seeLink('+ New', '/admin/menu_options/edit');
$I->see('Delete', '.page-header-action');
$I->see('Menu Option List', 'h3');

//--------------------------------------------------------------------
// Expect list of menu options
//--------------------------------------------------------------------
$I->expectTo('see list of all menu options');
$I->see('Name Priority Display Type ID', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no menu options available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter menu list by display type');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_display_type]');

//$I->makeScreenshot('menu_options_page');

//--------------------------------------------------------------------
//
// I want to add a new menu item
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new menu option page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Menu Option: New ‹ Administrator Panel');
$I->see('Menu Option   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Details', 'Option Values']);

// Error due to empty fields
$I->amGoingTo('submit menu option form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The Option Name field is required.', '.text-danger');
$I->dontSee('The Display Type field is required.', '.text-danger');
$I->see('The Priority field is required.', '.text-danger');
$I->dontSee('The Option Value field is required.', '.text-danger');
$I->dontSee('The Option Price field is required.', '.text-danger');
$I->dontSee('The Option ID field is required.', '.text-danger');

//$I->makeScreenshot('add_menu_option_page_errors');

// Success with menu added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->fillField('option_name', 'Extras');
$I->selectOption('#edit-form select[name=display_type]', 'Radio');
$I->fillField('priority', '1');

$I->amGoingTo('add four option values to the [cooked] menu option');
$I->lookForwardTo('add menu option values to menu from the the menu\'s edit form');
$I->click('Option Values', '#nav-tabs');
$I->click('#tfoot .action .btn-primary');
$I->fillField('option_values[1][value]', 'Meat');
$I->fillField('option_values[1][price]', '4.00');

$I->click('#tfoot .action .btn-primary');
$I->fillField('option_values[2][value]', 'Chicken');
$I->fillField('option_values[2][price]', '2.99');

$I->click('#tfoot .action .btn-primary');
$I->fillField('option_values[3][value]', 'Fish');
$I->fillField('option_values[3][price]', '3.00');

$I->click('#tfoot .action .btn-primary');
$I->fillField('option_values[4][value]', 'Beef');
$I->fillField('option_values[4][price]', '4.99');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new menu option added and page redirected to menu option list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Menu option added successfully.', '.alert-success');

$I->amGoingTo('check that added menu option appears in list');
$I->see('Extras 1 Radio', '#list-form tbody tr');

//$I->makeScreenshot('menu_option_added');

//--------------------------------------------------------------------
//
// I want to update an existing menu option
//
//--------------------------------------------------------------------
$I->amGoingTo('update the first menu option in the list');
$I->expectTo('navigate to update an existing menu option page, see title, action buttons and nav tabs');
$I->click('ID', '#list-form');
$I->click('#list-form tbody tr:first-child .btn-edit');
$I->seeInTitle('Menu Option: Extras ‹ Administrator Panel');
$I->see('Menu Option   Extras', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Details', 'Option Values']);

$I->amGoingTo('update menu option display type and option values');
$I->selectOption('#edit-form select[name=display_type]', 'Checkbox');
$I->fillField('priority', '10');

$I->click('Option Values', '#nav-tabs');
$I->click('#tfoot .action .btn-primary');
$I->fillField('option_values[5][value]', 'Assorted Meat');
$I->fillField('option_values[5][price]', '5.99');

$I->click('#tfoot .action .btn-primary');
$I->fillField('option_values[6][value]', 'Assorted Fish');
$I->fillField('option_values[6][price]', '3.99');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with menu option display type and values updated');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Menu option updated successfully.', '.alert-success');

$I->amGoingTo('check that updated menu option appears in list');
$I->see('Extras 10 Checkbox', '#list-form tbody tr');

//$I->makeScreenshot('menu_option_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing menu option
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the last menu option in the list');
$I->click('ID', '#list-form');
$I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with menu option deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Menu option deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted menu option does not appear in list');
$I->dontSee('Extras 10 Checkbox', '#list-form tbody tr');

//$I->makeScreenshot('menu_option_deleted');

$I->comment('All Done!');