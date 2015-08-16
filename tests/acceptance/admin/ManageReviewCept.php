<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage review from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'review\' page, check page title, header and action buttons');
$I->amOnPage('/admin/reviews');
$I->seeInTitle('Reviews ‹ Administrator Panel');
$I->see('Reviews', '.page-header h1');
$I->seeLink('+ New', '/admin/reviews/edit');
$I->see('Delete', '.page-header-action');
$I->see('Review List', 'h3');

//--------------------------------------------------------------------
// Expect list of reviews
//--------------------------------------------------------------------
$I->expectTo('see list of all reviews');
$I->see('Restaurant Author Sale ID Sale Type Status Date Added', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no reviews available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter review list by location, status or date');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');
$I->seeElement('#filter-form select[name=filter_location]');
$I->seeElement('#filter-form select[name=filter_status]');
$I->seeElement('#filter-form select[name=filter_date]');

//$I->makeScreenshot('reviews_page');

//--------------------------------------------------------------------
//
// I want to add a new review
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new review page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Review: New ‹ Administrator Panel');
$I->see('Review   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Review Details']);

// Error due to empty fields
$I->amGoingTo('submit review form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->dontSee('The Location field is required', '.text-danger');
$I->dontSee('The Sale Type field is required.', '.text-danger');
$I->see('The Sale ID field is required.', '.text-danger');
$I->see('The Customer field is required.', '.text-danger');
$I->see('The Quality Rating field is required.', '.text-danger');
$I->see('The Delivery Rating field is required.', '.text-danger');
$I->see('The Service Rating field is required.', '.text-danger');
$I->see('The Review Text field is required.', '.text-danger');

//$I->makeScreenshot('add_review_page_errors');

// Success with review added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->selectOption('select[name=location_id]', 'Lewisham');
$I->fillField('sale_id', '20006');

$I->expectTo('choose an author from a dropdown list of customers');
$I->click('#s2id_input-author .select2-choice');
$I->wait(1);
$I->pressKey('#select2-drop .select2-input', 'sam');
$I->wait(2);
$I->click('#select2-drop .select2-result-selectable');

$I->click('div[data-score-name="rating[quality]"] i[data-alt="4"]');
$I->click('div[data-score-name="rating[delivery]"] i[data-alt="3"]');
$I->click('div[data-score-name="rating[service]"] i[data-alt="5"]');

$I->fillField('review_text', 'Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada.');
$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new review added and page redirected to review list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Review added successfully.', '.alert-success');

$I->amGoingTo('check that added review appears in list');
$I->see('Lewisham Sam Poyigi 20006 Order Pending Review '.date('d M y'), '#list-form tbody tr');

//$I->makeScreenshot('review_added');

//--------------------------------------------------------------------
//
// I want to update an existing review
//
//--------------------------------------------------------------------
$I->amGoingTo('update the first review in the list');
$I->expectTo('navigate to update an existing review page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:first-child .btn-edit');
$I->seeInTitle('Review: Lewisham ‹ Administrator Panel');
$I->see('Review   Lewisham', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Review Details']);

// Form Error with sale ID not found
$I->amGoingTo('switch the sale type to Reservation');
$I->lookForwardTo('can check error with sale ID not found');
$I->toggleButton('input-sale-type');
$I->click('Save & Close', '.page-header-action');

$I->expect('form errors due to sale ID not found in sale type');
$I->dontSee('Details updated successfully.', '.alert-success');
$I->see('The Sale ID entered can not be found in reservations', '.text-danger');

// Success with review approved
$I->amGoingTo('update review status as approved');
$I->toggleButton('input-sale-type');
$I->toggleButton('input-sale-type');
$I->toggleButton('input-status');
$I->click('Save & Close', '.page-header-action');

$I->expect('success with review approved and sale type updated');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Review updated successfully.', '.alert-success');

$I->amGoingTo('check that updated review appears in list');
$I->see('Lewisham Sam Poyigi 20006 Order Approved '.date('d M y'), '#list-form tbody tr');

//$I->makeScreenshot('review_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing review
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the first review in the list');
$I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with review deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Review deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted review does not appear in list');
$I->dontSee('Lewisham Sam Poyigi 20006 Order Approved '.date('d M y'), '#list-form tbody tr');

//$I->makeScreenshot('review_deleted');

$I->comment('All Done!');