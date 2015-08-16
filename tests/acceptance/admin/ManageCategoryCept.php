<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage category from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'menu category\' page, check page title, header and action buttons');
$I->amOnPage('/admin/categories');
$I->seeInTitle('Categories ‹ Administrator Panel');
$I->see('Categories', '.page-header h1');
$I->seeLink('+ New', '/admin/categories/edit');
$I->see('Delete', '.page-header-action');
$I->see('Category List', 'h3');

//--------------------------------------------------------------------
// Expect list of categories
//--------------------------------------------------------------------
$I->expectTo('see list of all categories');
$I->see('Name Description Parent Priority ID', '#list-form thead tr');
$I->seeElement('#list-form tbody td');
$I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
$I->dontSee('There are no categories available.', '#list-form');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

$I->expectTo('see controls to filter category list by name or description');
$I->click('.btn-filter');
$I->waitForElementVisible('.panel-filter', 2);
$I->seeElement('#filter-form input[name=filter_search]');

//$I->makeScreenshot('categories_page');

//--------------------------------------------------------------------
//
// I want to add a new category
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to add a new category page, check title, action buttons and nav tabs');
$I->click('+ New');
$I->seeInTitle('Category: New ‹ Administrator Panel');
$I->see('Category   New', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Category Details']);

// Error due to empty fields
$I->amGoingTo('submit category form with empty fields');
$I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

$I->expect('form errors due to empty required form field');
$I->see('The Name field is required.', '.text-danger');
$I->dontSee('The Permalink Slug field', '.text-danger');
$I->dontSee('The Parent field is required.', '.text-danger');
$I->dontSee('The Description field is required.', '.text-danger');
$I->dontSee('The Image field is required.', '.text-danger');
$I->see('The Priority field is required.', '.text-danger');

//$I->makeScreenshot('add_category_page_errors');

// Success with category added
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$I->fillField('name', 'Test Category');
$I->fillField('description', 'Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada.');
$I->fillField('priority', '8');
$I->click('Save & Close', '.page-header-action');

$I->expect('success with a new category added and page redirected to category list');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Category added successfully.', '.alert-success');

$I->amGoingTo('check that added category appears in list');
$I->see('Test Category Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada... 8', '#list-form tbody tr');

//$I->makeScreenshot('category_added');

//--------------------------------------------------------------------
//
// I want to update an existing category
//
//--------------------------------------------------------------------
$I->amGoingTo('update the last category in the list');
$I->expectTo('navigate to update an existing category page, see title, action buttons and nav tabs');
$I->click('#list-form tbody tr:last-child .btn-edit');
$I->seeInTitle('Category: Test Category ‹ Administrator Panel');
$I->see('Category   Test Category', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');
$I->seeNavTabs(['Category Details']);

$I->amGoingTo('update category parent, image and priority');
$I->selectOption('#edit-form select[name=parent_id]', 'Main Course');
$I->fillField('priority', '12');

$I->expectTo('choose a menu photo from the media manager');
$I->click('#select-image');
$I->switchToIframe('media_manager');
$I->click('.media-list > div figure');
$I->click('.btn-choose');
$I->wait(2);
$I->switchToIframe();

$I->click('Save & Close', '.page-header-action');

$I->expect('success with category parent, image and priority updated');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Category updated successfully.', '.alert-success');

$I->amGoingTo('check that updated category appears in list');
$I->see('Test Category Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada... Main Course 12', '#list-form tbody tr');

//$I->makeScreenshot('category_updated');

//--------------------------------------------------------------------
//
// I want to delete an existing category
//
//--------------------------------------------------------------------
$I->amGoingTo('delete the last category in the list');
$I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
$I->click('Delete', '.page-header-action');
$I->acceptPopup();

$I->expect('success with category deleted');
$I->dontSeeElement('.alert-danger');
$I->see('Category deleted successfully.', '.alert-success');

$I->amGoingTo('check that deleted category does not appear in list');
$I->dontSee('Test Category Proin vehicula erat volutpat est tempor, eu feugiat diam malesuada... Main Course 12', '#list-form tbody tr');

//$I->makeScreenshot('category_deleted');

$I->comment('All Done!');