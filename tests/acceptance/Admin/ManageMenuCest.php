<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageMenuCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view menus from the administrator panel');

        $I->amOnPage('/admin/menus');
        $I->seeInTitle('Menus ‹ Administrator Panel');

        $I->expectTo('see list of all menus');
        $I->see('Name Price Category Stock Qty Status ID', '#list-form thead tr');
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
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('add a new menu item');

        $I->amOnPage('/admin/menus/edit');
        $I->seeInTitle('Menu: New ‹ Administrator Panel');

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

        $I->click('Menu Options', '#nav-tabs');
        $I->dontSee('The Option ID field is required.', '.text-danger');

        $I->click('Specials', '#nav-tabs');
        $I->dontSee('The Special Status field is required.', '.text-danger');
        $I->dontSee('The Start Date field is required.', '.text-danger');
        $I->dontSee('The End Date field is required.', '.text-danger');
        $I->dontSee('The Special Price field is required.', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a menu item from the administrator panel');

        $this->doMarkSpecialCategory($I);

        $this->doAddMenuItem($I);

        $I->seeInTitle('Menu: Menu Item ‹ Administrator Panel');

        $I->expectTo('update the added menu item photo, options and special');
        $I->chooseMedia('a menu photo');

        $I->click('Menu Options', '#nav-tabs');
        $I->amGoingTo('choose a menu option from the menu options dropdown list');
        $I->selectAjaxOption('#s2id_input-status', 'cooked');
        $I->waitForElementVisible('#menu-option .tab-content > div', 2);
        $I->toggleButton('input-required');

        $I->amGoingTo('add four option values to the selected menu option');
        $I->doAddMenuOptionValue($I, '1', 'Meat', '4.99', '100');
        $I->doAddMenuOptionValue($I, '2', 'Chicken', '3.99', '50');
        $I->doAddMenuOptionValue($I, '3', 'Fish', '2.99', '150');
        $I->doAddMenuOptionValue($I, '4', 'Beef', '1.99', '200');

        $I->amGoingTo('choose the special start and end date');
        $I->lookForwardTo('move the menu into the marked special category');
        $I->click('Specials', '#nav-tabs');
        $I->toggleButton('input-special-status');
        $I->waitForElementVisible('#special-toggle', 1);
        $I->fillField('start_date', date('d-m-Y'));
        $I->fillField('end_date', date('d-m-Y', strtotime('+ 1 month', time())));
        $I->fillField('special_price', '6.99');

        $I->click('Save', '.page-header-action');

        $I->expect('success with menu options and special updated');
        $I->see('Menu updated successfully.', '.alert-success');
    }

    public function testDeleteMenu(AcceptanceTester $I) {
        $I->wantTo('delete a menu item');

        $this->doAddMenuItem($I);

        $I->amOnPage('/admin/menus');

        $I->amGoingTo('delete the added menu item in the list');
        $I->see('Menu Item £9.99   Main Course 999 Enabled', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with menu item deleted and removed from the list');
        $I->see('Menu deleted successfully.', '.alert-success');
        $I->dontSee('Menu Item £9.99   Main Course 999 Enabled', '#list-form tbody tr');
    }

    protected function doAddMenuItem(AcceptanceTester $I) {
        $I->amOnPage('/admin/menus/edit');
        $I->seeInTitle('Menu: New ‹ Administrator Panel');

        $I->amGoingTo('create a new menu item');
        $I->fillField('menu_name', 'Menu Item');
        $I->fillField('menu_description', 'This is a description for the menu item');
        $I->fillField('menu_price', '9.99');
        $I->selectOption('#edit-form select[name=menu_category]', 'Main Course');
        $I->fillField('stock_qty', '999');
        $I->fillField('minimum_qty', '1');
        $I->toggleButton('input-subtract-stock');
        $I->toggleButton('input-status');
        $I->click('Save', '.page-header-action');

        $I->expect('success with a new menu item created');
        $I->see('Menu added successfully.', '.alert-success');
        $I->seeInField('menu_name', 'Menu Item');
        $I->seeInField('menu_description', 'This is a description for the menu item');
        $I->seeInField('menu_price', '9.99');
        $I->seeInField('stock_qty', '999');
        $I->seeInField('minimum_qty', '1');
    }

    protected function doMarkSpecialCategory(AcceptanceTester $I) {
        $I->amGoingTo('select the default special category in system settings');
        $I->amOnPage('/admin/settings');
        $I->click('Options', '#nav-tabs');
        $I->selectOption('select[name=special_category_id]', 'Specials');
        $I->click('Save', '.page-header-action');
    }
}