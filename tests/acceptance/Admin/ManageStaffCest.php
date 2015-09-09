<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageStaffCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view staff from the administrator panel');

        $I->amOnPage('/admin/staffs');
        $I->seeInTitle('Staff ‹ Administrator Panel');

        $I->expectTo('see list of all staffs');
        $I->see('Name Email Staff Group Location Date Added Status ID', '#list-form thead tr');
        $I->seeElement('#list-form tbody td');
        $I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
        $I->dontSee('There are no staffs available.', '#list-form');
        $I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

        $I->expectTo('see controls to filter staff list by group, location date or status');
        $I->click('.btn-filter');
        $I->waitForElementVisible('.panel-filter', 2);
        $I->seeElement('#filter-form input[name=filter_search]');
        $I->seeElement('#filter-form select[name=filter_group]');
        $I->seeElement('#filter-form select[name=filter_location]');
        $I->seeElement('#filter-form select[name=filter_date]');
        $I->seeElement('#filter-form select[name=filter_status]');
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('create a new staff');

        $I->amOnPage('/admin/staffs/edit');
        $I->seeInTitle('Staff: New ‹ Administrator Panel');

        $I->amGoingTo('submit form with empty fields');
        $I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

        $I->expect('form errors due to empty required form field');
        $I->see('The Name field is required', '.text-danger');
        $I->see('The Email field is required.', '.text-danger');
        $I->see('The Username field is required.', '.text-danger');
        $I->see('The Password field is required.', '.text-danger');
        $I->see('The Password Confirm field is required.', '.text-danger');
        $I->dontSee('The Status field is required.', '.text-danger');

        $I->click('Basic Settings', '#nav-tabs');
        $I->see('The Department field is required.', '.text-danger');
        $I->dontSee('The Location field is required.', '.text-danger');
        $I->dontSee('The Timezone field is required.', '.text-danger');
        $I->dontSee('The Language field is required.', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a staff from the administrator panel');

        $this->doCreateStaff($I);

        $I->seeInTitle('Staff: Adam Smith ‹ Administrator Panel');

        $I->amGoingTo('update staff name, location and staff group');
        $I->fillField('staff_name', 'John Smith');

        $I->click('Basic Settings', '#nav-tabs');
        $I->selectOption('staff_group_id', 'Manager');
        $I->selectOption('staff_location_id', 'Lewisham');

        $I->click('Save', '.page-header-action');

        $I->expect('success with staff name, location and group updated');
        $I->see('Staff updated successfully.', '.alert-success');
        $I->seeInField('staff_name', 'John Smith');
    }

    public function testDeleteStaff(AcceptanceTester $I) {
        $I->wantTo('delete a staff');

        $this->doCreateStaff($I);

        $I->amOnPage('/admin/staffs');

        $I->amGoingTo('delete the created staff in the list');
        $I->see('Adam Smith adam.smith@example.com Delivery Today Enabled', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with staff deleted and removed from the list');
        $I->see('Staff deleted successfully.', '.alert-success');
        $I->dontSee('Adam Smith adam.smith@example.com Delivery Today Enabled', '#list-form tbody tr');
    }

    protected function doCreateStaff(AcceptanceTester $I) {
        $I->amOnPage('/admin/staffs/edit');
        $I->seeInTitle('Staff: New ‹ Administrator Panel');

        $I->amGoingTo('create a delivery staff');
        $I->click('Staff Details', '#nav-tabs');
        $I->fillField('staff_name', 'Adam Smith');
        $I->fillField('staff_email', 'adam.smith@example.com');
        $I->fillField('username', 'adamSmith');
        $I->fillField('password', 'pass123456');
        $I->fillField('password_confirm', 'pass123456');
        $I->toggleButton('input-status');

        $I->click('Basic Settings', '#nav-tabs');
        $I->selectOption('select[name=staff_group_id]', 'Delivery');
        $I->selectOption('select[name=staff_location_id]', 'Use Default');
        $I->selectOption('select[name=timezone]', 'Use Default');
        $I->selectOption('select[name=language_id]', 'Use Default');

        $I->click('Save', '.page-header-action');

        $I->expect('success with a new staff added to Delivery department');
        $I->see('Staff added successfully.', '.alert-success');
        $I->click('Staff Details', '#nav-tabs');
        $I->seeInField('staff_name', 'Adam Smith');
        $I->seeInField('staff_email', 'adam.smith@example.com');
        $I->seeInField('username', 'adamsmith');
    }
}