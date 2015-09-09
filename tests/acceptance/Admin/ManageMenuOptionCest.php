<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageMenuOptionCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view menu options from the administrator panel');

        $I->amOnPage('/admin/menu_options');
        $I->seeInTitle('Menu Options ‹ Administrator Panel');

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
    }

    public function testAssignOptionsToMenu(AcceptanceTester $I) {
        $I->wantTo('create a menu option then add it to a menu');

        $this->doAddMenuOption($I);

        $I->seeInTitle('Menu Option: Sides extra ‹ Administrator Panel');

        $I->amGoingTo('create a menu item');
        $I->lookForwardTo('add the menu option to the menu item');

        $I->amOnPage('/admin/menus/edit');
        $I->seeInTitle('Menu: New ‹ Administrator Panel');

        $I->fillField('menu_name', 'Menu Item');
        $I->fillField('menu_description', 'This is a description for the menu item');
        $I->fillField('menu_price', '9.99');
        $I->selectOption('#edit-form select[name=menu_category]', 'Main Course');
        $I->fillField('stock_qty', '999');
        $I->fillField('minimum_qty', '1');
        $I->toggleButton('input-subtract-stock');
        $I->toggleButton('input-status');
        $I->chooseMedia('a menu photo');

        $I->amGoingTo('choose the menu option from the menu options dropdown list');
        $I->click('Menu Options', '#nav-tabs');
        $I->selectAjaxOption('#s2id_input-status', 'Sides extra');
        $I->waitForElementVisible('#menu-option .tab-content > div', 2);

        $I->amGoingTo('add four option values to the selected menu option');
        $I->doAddMenuOptionValue($I, '1', 'Meat', '4.99', '100');
        $I->doAddMenuOptionValue($I, '2', 'Chicken', '3.99', '50');

        $I->click('Save', '.page-header-action');

        $I->expect('success with menu created and menu options added');
        $I->see('Menu added successfully.', '.alert-success');
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('add a new menu option');

        $I->amOnPage('/admin/menu_options/edit');
        $I->seeInTitle('Menu Option: New ‹ Administrator Panel');

        $I->amGoingTo('submit menu option form with empty fields');
        $I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

        $I->expect('form errors due to empty required form field');
        $I->see('The Option Name field is required.', '.text-danger');
        $I->dontSee('The Display Type field is required.', '.text-danger');
        $I->see('The Priority field is required.', '.text-danger');
        $I->dontSee('The Option Value field is required.', '.text-danger');
        $I->dontSee('The Option Price field is required.', '.text-danger');
        $I->dontSee('The Option ID field is required.', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a menu option from the administrator panel');

        $this->doAddMenuOption($I);

        $I->seeInTitle('Menu Option: Sides extra ‹ Administrator Panel');

        $I->amGoingTo('update menu option display type and option values');
        $I->selectOption('#edit-form select[name=display_type]', 'Checkbox');
        $I->fillField('priority', '10');

        $I->click('Option Values', '#nav-tabs');
        $this->doAddOptionValue($I, 5, 'Assorted Meat', '5.99');
        $this->doAddOptionValue($I, 6, 'Assorted Fish', '3.99');

        $I->click('Save', '.page-header-action');

        $I->expect('success with menu option display type and values updated');
        $I->see('Menu option updated successfully.', '.alert-success');
        $I->seeInField('priority', '10');
    }

    public function testDeleteMenuOption(AcceptanceTester $I) {
        $I->wantTo('delete a menu option');

        $this->doAddMenuOption($I);

        $I->amOnPage('/admin/menu_options');

        $I->amGoingTo('delete the added menu option in the list');
        $I->see('Sides extra 1 Radio', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with menu option deleted and removed from the list');
        $I->see('Menu option deleted successfully.', '.alert-success');
        $I->dontSee('Sides extra 1 Checkbox', '#list-form tbody tr');
    }

    protected function doAddMenuOption(AcceptanceTester $I) {
        $I->amOnPage('/admin/menu_options/edit');
        $I->seeInTitle('Menu Option: New ‹ Administrator Panel');

        $I->amGoingTo('create a new menu option');
        $I->fillField('option_name', 'Sides extra');
        $I->selectOption('#edit-form select[name=display_type]', 'Radio');
        $I->fillField('priority', '1');

        $I->amGoingTo('add four option values to the selected menu option');
        $I->click('Option Values', '#nav-tabs');
        $this->doAddOptionValue($I, 1, 'Meat', '4.00');
        $this->doAddOptionValue($I, 2, 'Chicken', '2.99');
        $this->doAddOptionValue($I, 3, 'Fish', '3.00');
        $this->doAddOptionValue($I, 4, 'Beef', '4.99');

        $I->click('Save', '.page-header-action');

        $I->expect('success with a new menu option added');
        $I->see('Menu option added successfully.', '.alert-success');
    }

    protected function doAddOptionValue(AcceptanceTester $I, $num, $name, $price) {
        $I->click('#tfoot .action .btn-primary');
        $I->fillField("option_values[{$num}][value]", $name);
        $I->fillField("option_values[{$num}][price]", $price);
    }
}