<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage menus from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

//--------------------------------------------------------------------
// Expect special category selected in system settings
//--------------------------------------------------------------------
$I->amGoingTo('ensure [Specials] is the default special category in system settings');
$I->lookForwardTo('know which category to check for specials');
$I->amOnPage('/admin/settings');
$I->click('Options', '#nav-tabs');
$I->selectOption('select[name=special_category_id]', 'Specials');
$I->click('Save', '.page-header-action');

$I->amGoingTo('navigate to \'menus\' page, check page title, header and action buttons');
$I->amOnPage('/admin/menus');
$I->seeInTitle('Menus ‹ Administrator Panel');
$I->see('Menus', '.page-header h1');
$I->seeLink('+ New', '/admin/menus/edit');
$I->see('Delete', '.page-header-action');
$I->see('Menu Item List', 'h3');

//--------------------------------------------------------------------
// Expect list of menus
//--------------------------------------------------------------------
$I->expectTo('see list of all menus');
$I->seeTableHeads('#list-form', ['Name', 'Price', 'Category', 'Stock Qty', 'Status', 'ID']);
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no menus available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter menu list by category or status');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_category]');
$I->seeElement('#filter-form select[name=filter_status]');

$I->makeScreenshot('menus_page');

//--------------------------------------------------------------------
//
// I want to add a new menu item
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new menu item page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Menu: New ‹ Administrator Panel');
$I->see('Menu   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Menu', 'Menu Options', 'Specials']);

// Error due to empty fields
$I->amGoingTo('submit menu form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The Name field is required.', '.text-danger');
$I->dontSee('The Description field is required.', '.text-danger');
$I->see('The Price field is required.', '.text-danger');
$I->see('The Category field is required.', '.text-danger');
$I->dontSee('The Image field is required.', '.text-danger');
$I->see('The Stock Quantity field is required.', '.text-danger');
$I->dontSee('The Minimum Quantity field is required.', '.text-danger');
$I->dontSee('The Subtract Stock field is required.', '.text-danger');
$I->dontSee('The Status field is required.', '.text-danger');
$I->dontSee('The Option ID field is required.', '.text-danger');
$I->dontSee('The Special Status field is required.', '.text-danger');
$I->dontSee('The Start Date field is required.', '.text-danger');
$I->dontSee('The End Date field is required.', '.text-danger');
$I->dontSee('The Special Price field is required.', '.text-danger');

$I->makeScreenshot('add_menu_page_errors');

// Success with menu added
$I->amGoingTo('submit menu form with the correct criteria and permitted characters');
$I->fillField('menu_name', 'Fried coconut rice and vegetables');
$I->fillField('menu_description', 'coconut rice cooked and fried in tomatoes, pepper and onion sauce with seasoning to taste');
$I->fillField('menu_price', '23.99');
$I->selectOption('#edit-form select[name=menu_category]', 'Main Course');
$I->fillField('stock_qty', '100');
$I->fillField('minimum_qty', '1');
$I->toggleButton('input-subtract-stock');
$I->toggleButton('input-status');
$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new menu without option added and page redirected to menu item list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Menu added successfully.', '.alert-success');

$I->amGoingTo('check that added menu item appears in list');
$I->see('Fried coconut rice and vegetables £23.99   Main Course 100 Enabled 89', '#list-form tbody tr:last-child');

$I->makeScreenshot('menu_added');

//--------------------------------------------------------------------
//
// I want to update an existing menu item
//
//--------------------------------------------------------------------
$I->amGoingTo('update the last menu item in the list');
$I->expectTo('navigate to update an existing menu item page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:last-child .btn-edit');
$I->seeInTitle('Menu: Fried coconut rice and vegetables ‹ Administrator Panel');
$I->see('Menu   Fried coconut rice and vegetables', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Menu', 'Menu Options', 'Specials']);

$I->amGoingTo('update menu item with menu photo, options and specials');
$I->expectTo('choose a menu photo from the media manager');
$I->click('#select-image');
$I->switchToIframe('media_manager');
$I->click('.media-list > div figure');
$I->click('.btn-choose');
$I->wait(2);
$I->switchToIframe();

$I->expectTo('choose a menu option and add some option values to it');
$I->click('Menu Options', '#nav-tabs');
$I->click('#s2id_input-status .select2-choice');
$I->wait(1);
$I->seeElement('#select2-drop .select2-search input');
$I->pressKey('#select2-drop .select2-input', 'cooked');
$I->wait(2);
$I->click('#select2-drop .select2-result-selectable');
$I->waitForElementVisible('#menu-option .tab-content > div', 2);
$I->toggleButton('input-required');

$I->expectTo('add four option values to the [cooked] menu option');
$I->selectOption('#option-value1 select', 'Meat');
$I->fillField('menu_options[1][option_values][1][price]', '4.99');
$I->fillField('menu_options[1][option_values][1][quantity]', '100');
$I->click('#option-value1 label.btn:not(.active)');

$I->click('#tfoot .action .btn-primary');
$I->selectOption('#option-value2 select', 'Chicken');
$I->fillField('menu_options[1][option_values][2][price]', '3.99');
$I->fillField('menu_options[1][option_values][2][quantity]', '99');
$I->click('#option-value2 label.btn:not(.active)');

$I->click('#tfoot .action .btn-primary');
$I->selectOption('#option-value3 select', 'Fish');
$I->fillField('menu_options[1][option_values][3][price]', '2.99');
$I->fillField('menu_options[1][option_values][3][quantity]', '150');
$I->click('#option-value3 label.btn:not(.active)');

$I->click('#tfoot .action .btn-primary');
$I->selectOption('#option-value4 select', 'Beef');
$I->fillField('menu_options[1][option_values][4][price]', '1.99');
$I->fillField('menu_options[1][option_values][4][quantity]', '300');
$I->click('#option-value4 label.btn:not(.active)');

$I->expectTo('enable specials, choose a start and end date');
$I->lookForwardTo('move the menu from [main course] category to [specials] category');
$I->click('Specials', '#nav-tabs');
$I->toggleButton('input-special-status');
$I->waitForElementVisible('#special-toggle', 1);
$I->fillField('start_date', date('d-m-Y'));
$I->fillField('end_date', date('d-m-Y', strtotime('+ 1 month', time())));
$I->fillField('special_price', '6.99');

$I->expect('success with menu photo, option and special updated');
$I->click('Save & Close', '.page-header-action');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Menu updated successfully.', '.alert-success');

$I->amGoingTo('check that updated menu item appears in list with specials enabled');
$I->seeElement('#list-form tbody tr:last-child .fa-star-special');
$I->see('Fried coconut rice and vegetables £23.99   Specials 100 Enabled 89', '#list-form tbody tr:last-child');

$I->makeScreenshot('menu_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing menu item
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the last menu item in the list');
$I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with menu item deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Menu deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted menu item does not appear in list');
$I->dontSee('Fried coconut rice and vegetables £23.99   Specials 100 Enabled 89', '#list-form tbody tr');

$I->makeScreenshot('menu_deleted');

$I->comment('All Done!');