<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage location from the administrator panel');

// Login Test location user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'locations\' page, check page title, header and action buttons');
$I->amOnPage('/admin/locations');
$I->seeInTitle('Locations ‹ Administrator Panel');
$I->see('Locations', '.page-header h1');
$I->seeLink('+ New', '/admin/locations/edit');
$I->see('Delete', '.page-header-action');
$I->see('Location List', 'h3');

//--------------------------------------------------------------------
// Expect list of locations
//--------------------------------------------------------------------
$I->expectTo('see list of all locations');
$I->see('Name City State Postcode Telephone Status ID', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no locations available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter location list by name, city, postcode or status');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_status]');

//$I->makeScreenshot('locations_page');

//--------------------------------------------------------------------
//
// I want to add a new location
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new location page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Location: New ‹ Administrator Panel');
$I->see('Location   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Location', 'Opening Hours', 'Order', 'Reservation', 'Delivery']);

// Error due to empty fields
$I->amGoingTo('submit form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The Name field is required', '.text-danger');
$I->see('The Address 1 field is required.', '.text-danger');
$I->dontSee('The Address 2 field is required.', '.text-danger');
$I->see('The City field is required.', '.text-danger');
$I->dontSee('The State field is required.', '.text-danger');
$I->see('The Postcode field is required.', '.text-danger');
$I->dontSee('The Country field is required.', '.text-danger');
$I->see('The Email field is required.', '.text-danger');
$I->see('The Telephone field is required.', '.text-danger');
$I->dontSee('The Description field is required.', '.text-danger');
$I->dontSee('The Permalink Slug field is required.', '.text-danger');
$I->dontSee('The Image field is required.', '.text-danger');
$I->dontSee('The Status field is required.', '.text-danger');

$I->click('Opening Hours', '#nav-tabs');
$I->dontSee('The Type field is required.', '.text-danger');

$I->click('Delivery', '#nav-tabs');
$I->see('Delivery area map will be visible after location has been saved.', '.text-danger');

//$I->makeScreenshot('add_location_page_errors');

// Success with location added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->click('Location', '#nav-tabs');
$I->fillField('location_name', 'Belvedere Hill');
$I->fillField('address[address_1]', '191 Belvedere Rd');
$I->fillField('address[address_2]', '');
$I->fillField('address[city]', 'Salford');
$I->fillField('address[state]', 'Manchester');
$I->fillField('address[postcode]', 'M6 5FL');
$I->selectOption('address[country]', 'United Kingdom');
$I->fillField('email', 'belvedere@example.com');
$I->fillField('telephone', '8929292020');
$I->fillField('description', 'Morbi sed efficitur eros. Sed ex est, ullamcorper ut nisi vitae, rhoncus lobortis lectus. Fusce sagittis commodo maximus.');

$I->expectTo('choose an image from the media manager');
$I->click('#select-image');
$I->switchToIframe('media_manager');
$I->click('.media-list > div figure');
$I->click('.btn-choose');
$I->wait(2);
$I->switchToIframe();

$I->toggleButton('input-status');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new location added and page redirected to location list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Location added successfully.', '.alert-success');

$I->amGoingTo('check that added location appears in list');
$I->see('Belvedere Hill Salford Manchester M6 5FL 8929292020 Enabled', '#list-form tbody tr');

//$I->makeScreenshot('location_added');

//--------------------------------------------------------------------
//
// I want to update an existing location
//
//--------------------------------------------------------------------
$I->amGoingTo('update the last location in the list');
$I->expectTo('navigate to update an existing location page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:last-child .btn-edit');
$I->seeInTitle('Location: Belvedere Hill ‹ Administrator Panel');
$I->see('Location   Belvedere Hill', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Location', 'Opening Hours', 'Order', 'Reservation', 'Delivery']);

// Success with location updated
$I->amGoingTo('update location payments, tables and delivery areas');
$I->click('Order', '#nav-tabs');
$I->toggleButton('input-offer-delivery');
$I->toggleButton('input-offer-collection');
$I->selectOption('payments[]', ['Cash On Delivery', 'PayPal Express']);

$I->expectTo('choose two tables from a dropdown list');
$I->click('Reservation', '#nav-tabs');
$I->click('#s2id_input-table .select2-choice');
$I->wait(1);
$I->pressKey('#select2-drop .select2-input', 'SW');
$I->wait(2);
$I->click('#select2-drop .select2-result-selectable');

$I->click('#s2id_input-table .select2-choice');
$I->wait(1);
$I->pressKey('#select2-drop .select2-input', 'NE');
$I->wait(2);
$I->click('#select2-drop .select2-result-selectable');

$I->click('Delivery', '#nav-tabs');
$I->click('button.area-new');
$I->click('#delivery-area1 .panel-heading');
$I->click('.area-types .area-type-circle');
$I->fillField('delivery_areas[1][charge]', '10');
$I->fillField('delivery_areas[1][min_amount]', '100');

$I->click('Save & Close', '.page-header-action');

$I->expect('success with location payments, tables and delivery areas updated');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Location updated successfully.', '.alert-success');

$I->amGoingTo('check that updated location appears in list');
$I->see('Belvedere Hill Salford Manchester M6 5FL 8929292020 Enabled', '#list-form tbody tr');

//$I->makeScreenshot('location_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing location
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the last location in the list');
$I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with location deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Location deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted location does not appear in list');
$I->dontSee('Belvedere Hill Salford Manchester M6 5FL 8929292020 Enabled', '#list-form tbody tr');

//$I->makeScreenshot('location_deleted');

$I->comment('All Done!');