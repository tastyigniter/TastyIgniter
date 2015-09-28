<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageCustomerCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view customer from the administrator panel');

        $I->amOnPage('/admin/customers');
        $I->seeInTitle('Customers ‹ Administrator Panel');

        $I->expectTo('see list of all customers');
        $I->see('First Name Last Name Email Telephone Date Added Status ID', '#list-form thead tr');
        $I->seeElement('#list-form tbody td');
        $I->seeNumberOfElements('#list-form tbody tr', [1, 20]); //between 1 and 20 elements
        $I->dontSee('There are no customers available.', '#list-form');
        $I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

        $I->expectTo('see controls to filter customer list by date or status');
        $I->click('.btn-filter');
        $I->waitForElementVisible('.panel-filter', 2);
        $I->seeElement('#filter-form input[name=filter_search]');
        $I->seeElement('#filter-form select[name=filter_date]');
        $I->seeElement('#filter-form select[name=filter_status]');
    }

    public function textFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('add a new customer');

        $I->amOnPage('/admin/customers/edit');
        $I->seeInTitle('Customer: New ‹ Administrator Panel');

        $I->amGoingTo('submit customer form with empty fields');
        $I->submitForm('#edit-form', [], '.page-header-action .btn-primary');

        $I->expect('form errors due to empty required form field');
        $I->see('The First Name field is required', '.text-danger');
        $I->see('The Last Name field is required.', '.text-danger');
        $I->see('The Email field is required.', '.text-danger');
        $I->see('The Telephone field is required.', '.text-danger');
        $I->see('The Password field is required.', '.text-danger');
        $I->see('The Confirm Password field is required.', '.text-danger');
        $I->see('The Security Question field is required.', '.text-danger');
        $I->see('The Security Answer field is required.', '.text-danger');
        $I->dontSee('The Customer Group field is required.', '.text-danger');
        $I->dontSee('The Newsletter field is required.', '.text-danger');
        $I->dontSee('The Status field is required.', '.text-danger');

        $I->amGoingTo('submit customer form with invalid values');
        $I->fillField('first_name', 'J');
        $I->fillField('last_name', 'D');
        $I->fillField('email', 'john.doeexample.com');
        $I->fillField('telephone', 'tel123456789');
        $I->fillField('password', '123');
        $I->fillField('confirm_password', '123');
        $I->fillField('security_answer', 'P');
        $I->selectOption('select[name=customer_group_id]', 'Default');
        $I->toggleButton('input-newsletter');
        $I->toggleButton('input-status');
        $I->click('Save', '.page-header-action');

        $I->expect('form errors due to invalid values');
        $I->see('The First Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Last Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Email field must contain a valid email address', '.text-danger');
        $I->see('The Password field must be at least 6 characters in length.', '.text-danger');
        $I->see('The Telephone field must contain an integer.', '.text-danger');
        $I->see('The Security Answer field must be at least 2 characters in length.', '.text-danger');
        $I->dontSee('The Customer Group field is required.', '.text-danger');
        $I->dontSee('The Newsletter field is required.', '.text-danger');
        $I->dontSee('The Status field is required.', '.text-danger');
    }

    public function testDisableCustomer(AcceptanceTester $I) {
        $I->wantTo('disable a customer');

        $this->doAddCustomer($I);

        $I->amGoingTo('update customer status as disabled');
        $I->toggleButton('input-status');

        $I->click('Save & Close', '.page-header-action');

        $I->expect('success with customer disabled');
        $I->see('Customer updated successfully.', '.alert-success');
        $I->see('John Doe john.doe@example.com 123456789 Today Disabled', '#list-form tbody tr');

        $I->amGoingTo('log into customer account as customer');
        $I->lookForwardTo('check if customer account is disabled');
        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->login('john.doe@example.com', 'pass123456');
                $I->see('Username and password not found!', '.alert-danger');
            });
    }

    public function testChangePassword(AcceptanceTester $I) {
        $I->wantTo('change a customer account login password');

        $this->doAddCustomer($I);

        $I->amGoingTo('change the customer password');
        $I->fillField('password', 'password123456');
        $I->fillField('confirm_password', 'password123456');

        $I->click('Save & Close', '.page-header-action');
        $I->expect('success with customer password changed');
        $I->see('Customer updated successfully.', '.alert-success');

        $I->amGoingTo('log into customer account as customer with the new password');
        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->login('john.doe@example.com', 'password123456');
                $I->dontSeeElement('.alert-danger');
        });
    }

    public function testEmailField(AcceptanceTester $I) {
        $I->wantTo('create two new customer accounts');
        $I->lookForwardTo('check both does not have same email');

        $this->doAddCustomer($I);

        $I->amOnPage('/admin/customers/edit');
        $I->seeInTitle('Customer: New ‹ Administrator Panel');

        $I->amGoingTo('create another account with the registered email');
        $I->fillField('first_name', 'John');
        $I->fillField('last_name', 'Doe');
        $I->fillField('email', 'john.doe@example.com');
        $I->click('Save', '.page-header-action');

        $I->expect('form errors due to email already registered');
        $I->see('The Email field value already exist', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a customer from the administrator panel');

        $this->doAddCustomer($I);

        $I->seeInTitle('Customer: John Doe ‹ Administrator Panel');

        $I->amGoingTo('update customer details and un-subscribe from newsletter');
        $I->fillField('first_name', 'Johnny');
        $I->fillField('last_name', 'Smith');
        $I->fillField('telephone', '0123456789');
        $I->toggleButton('input-newsletter');

        $I->amGoingTo('add a new customer address');
        $I->click('Address', '#nav-tabs');
        $I->click('#sub-tabs .add_address a');
        $I->fillField('address[2][address_1]', 'Address 1');
        $I->fillField('address[2][address_2]', 'Address 2');
        $I->fillField('address[2][city]', 'City');
        $I->fillField('address[2][state]', 'State');
        $I->fillField('address[2][postcode]', '000 000');
        $I->selectOption('address[2][country_id]', 'United Kingdom');

        $I->click('Save', '.page-header-action');

        $I->expect('success with customer un-subscribed, details updated and new address added');
        $I->see('Customer updated successfully.', '.alert-success');
        $I->seeInField('first_name', 'Johnny');
        $I->seeInField('last_name', 'Smith');
        $I->seeInField('telephone', '0123456789');
        $I->click('Address', '#nav-tabs');
        $I->see('Address 1', '#sub-tabs');
        $I->see('Address 2', '#sub-tabs');
    }

    public function testDeleteCustomer(AcceptanceTester $I) {
        $I->wantTo('delete a customer');

        $this->doAddCustomer($I);

        $I->amOnPage('/admin/customers');

        $I->amGoingTo('delete the added customer in the list');
        $I->see('John Doe john.doe@example.com 123456789 Today Enabled', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with customer deleted and removed from the list');
        $I->see('Customer deleted successfully.', '.alert-success');
        $I->dontSee('John Doe john.doe@example.com 123456789 Today Enabled', '#list-form tbody tr');
    }

    protected function doAddCustomer(AcceptanceTester $I) {
        $I->amOnPage('/admin/customers/edit');
        $I->seeInTitle('Customer: New ‹ Administrator Panel');

        $I->amGoingTo('create a new customer account');
        $I->fillField('first_name', 'John');
        $I->fillField('last_name', 'Doe');
        $I->fillField('email', 'john.doe@example.com');
        $I->fillField('telephone', '123456789');
        $I->fillField('password', 'pass123456');
        $I->fillField('confirm_password', 'pass123456');
        $I->selectOption('select[name=security_question_id]', 'Whats your pets name?');
        $I->fillField('security_answer', 'Petie');
        $I->selectOption('select[name=customer_group_id]', 'Default');
        $I->toggleButton('input-newsletter');
        $I->toggleButton('input-status');

        $I->amGoingTo('add an address to the customer account');
        $I->click('Address', '#nav-tabs');
        $I->click('#sub-tabs .add_address a');
        $I->fillField('address[1][address_1]', '1 Address 1');
        $I->fillField('address[1][address_2]', '1 Address 2');
        $I->fillField('address[1][city]', 'City');
        $I->fillField('address[1][state]', 'State');
        $I->fillField('address[1][postcode]', '00 000');
        $I->selectOption('address[1][country_id]', 'United Kingdom');

        $I->click('Save', '.page-header-action');

        $I->expect('success with a new customer added');
        $I->see('Customer added successfully.', '.alert-success');
        $I->seeInField('first_name', 'John');
        $I->seeInField('last_name', 'Doe');
        $I->seeInField('email', 'john.doe@example.com');
    }
}