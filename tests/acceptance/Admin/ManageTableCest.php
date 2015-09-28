<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageTableCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view tables from the administrator panel');

        $I->amOnPage('/admin/tables');
        $I->seeInTitle('Tables ‹ Administrator Panel');

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
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('create a new table');

        $I->amOnPage('/admin/tables/edit');
        $I->seeInTitle('Table: New ‹ Administrator Panel');

        $I->amGoingTo('submit form with empty fields');
        $I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

        $I->expect('form errors due to empty required form field');
        $I->see('The Name field is required', '.text-danger');
        $I->see('The Minimum field is required.', '.text-danger');
        $I->see('The Capacity field is required.', '.text-danger');
        $I->dontSee('The Status field is required.', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a table from the administrator panel');

        $this->doAddTable($I);

        $I->seeInTitle('Table: Big Round Table ‹ Administrator Panel');

        $I->amGoingTo('update table status, minimum and maximum capacity');
        $I->fillField('min_capacity', '4');
        $I->fillField('max_capacity', '12');
        $I->toggleButton('input-status');

        $I->click('Save', '.page-header-action');

        $I->expect('success with table status, minimum and maximum capacity updated');
        $I->see('Table updated successfully.', '.alert-success');
        $I->seeInField('min_capacity', '4');
        $I->seeInField('max_capacity', '12');
    }

    public function testDeleteTable(AcceptanceTester $I) {
        $I->wantTo('delete a table');

        $this->doAddTable($I);

        $I->amOnPage('/admin/tables');

        $I->amGoingTo('delete added last table in the list');
        $I->see('Big Round Table 2 10 Enabled', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with table deleted and removed from the list');
        $I->see('Table deleted successfully.', '.alert-success');
        $I->dontSee('Big Round Table 2 10 Enabled', '#list-form tbody tr');
    }

    public function doAddTable(AcceptanceTester $I) {
        $I->amOnPage('/admin/tables/edit');
        $I->seeInTitle('Table: New ‹ Administrator Panel');

        $I->amGoingTo('add a table');
        $I->click('Table Details', '#nav-tabs');
        $I->fillField('table_name', 'Big Round Table');
        $I->fillField('min_capacity', '2');
        $I->fillField('max_capacity', '10');
        $I->toggleButton('input-status');

        $I->click('Save', '.page-header-action');

        $I->expect('success with a new table added');
        $I->see('Table added successfully.', '.alert-success');
        $I->amGoingTo('check that added table appears in list');
        $I->seeInField('table_name', 'Big Round Table');
        $I->seeInField('min_capacity', '2');
        $I->seeInField('max_capacity', '10');
    }
}