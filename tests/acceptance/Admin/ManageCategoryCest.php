<?php
namespace Admin;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageCategoryCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view menu categories from the administrator panel');

        $I->amOnPage('/admin/categories');
        $I->seeInTitle('Categories ‹ Administrator Panel');

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
    }

    public function testSpecialCategory(AcceptanceTester $I) {
        $I->wantTo('mark a category as special');

        $this->doAddCategory($I);

        $I->amOnPage('/admin/settings');
        $I->click('Options', '#nav-tabs');

        $I->selectOption('special_category_id', 'Main Category');

        $I->click('Save', '.page-header-action');

        $I->expect('success with category marked as special');
        $I->see('Settings updated successfully.', '.alert-success');
        $I->click('Options', '#nav-tabs');
        $I->seeOptionIsSelected('special_category_id', 'Main Category');
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('add a menu category');

        $I->amOnPage('/admin/categories/edit');
        $I->seeInTitle('Category: New ‹ Administrator Panel');

        $I->amGoingTo('submit category form with empty fields');
        $I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

        $I->expect('form errors due to empty required form field');
        $I->see('The Name field is required.', '.text-danger');
        $I->dontSee('The Permalink Slug field', '.text-danger');
        $I->dontSee('The Parent field is required.', '.text-danger');
        $I->dontSee('The Description field is required.', '.text-danger');
        $I->dontSee('The Image field is required.', '.text-danger');
        $I->see('The Priority field is required.', '.text-danger');

        $I->amGoingTo('submit category form with invalid values');
        $I->fillField('name', 'M');
        $I->fillField('description', 'T');
        $I->fillField('priority', 'one');
        $I->click('Save', '.page-header-action');

        $I->expect('form errors due to invalid values');
        $I->see('The Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Description field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Priority field must contain an integer.', '.text-danger');
        $I->dontSee('The Permalink Slug field', '.text-danger');
        $I->dontSee('The Parent field is required.', '.text-danger');
        $I->dontSee('The Description field is required.', '.text-danger');
        $I->dontSee('The Image field is required.', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a menu category from the administrator panel');

        $this->doAddCategory($I);

        $I->expect('success with the category added');
        $I->see('Category added successfully.', '.alert-success');
        $I->seeInFormFields('#edit-form', [
            'name' => 'Main Category',
            'description' => 'This is a menu category description.',
            'priority' => '8',
        ]);

        $I->seeInTitle('Category: Main Category ‹ Administrator Panel');

        $I->amGoingTo('update the added menu category');
        $I->fillField('name', 'Main Category 2');
        $I->selectOption('#edit-form select[name=parent_id]', 'Main Course');
        $I->fillField('priority', '1');

        $I->chooseMedia('a menu category photo');
        $I->click('Save', '.page-header-action');

        $I->expect('success with the category updated');
        $I->see('Category updated successfully.', '.alert-success');
        $I->seeInFormFields('#edit-form', [
            'name' => 'Main Category 2',
            'description' => 'This is a menu category description.',
            'priority' => '1',
            'parent_id' => '16',
        ]);
    }

    public function testDeleteCategory(AcceptanceTester $I) {
        $I->wantTo('delete a menu category');

        $this->doAddCategory($I);

        $I->amOnPage('/admin/categories');

        $I->amGoingTo('delete the added category in the list');
        $I->see('Main Category This is a menu category description...', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with category deleted and removed from the list');
        $I->see('Category deleted successfully.', '.alert-success');
        $I->dontSee('Main Category This is a menu category description...', '#list-form tbody tr');
    }

    protected function doAddCategory(AcceptanceTester $I) {
        $I->amOnPage('/admin/categories/edit');
        $I->seeInTitle('Category: New ‹ Administrator Panel');

        $I->amGoingTo('add a new menu category');
        $I->fillField('name', 'Main Category');
        $I->fillField('description', 'This is a menu category description.');
        $I->fillField('priority', '8');
        $I->click('Save', '.page-header-action');
    }
}