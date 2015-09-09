<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageLocationCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view locations from the administrator panel');

        $I->amOnPage('/admin/locations');
        $I->seeInTitle('Locations ‹ Administrator Panel');

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
    }

    public function testLocationSearch(AcceptanceTester $I) {
        $this->doAddLocation($I);

        $I->amGoingTo('add the restaurant delivery area');
        $I->click('Delivery', '#nav-tabs');
        $I->click('button.area-new');
        $I->click('#delivery-area1 .panel-heading');
        $I->click('.area-types .area-type-circle');
        $I->fillField('delivery_areas[1][charge]', '10');
        $I->fillField('delivery_areas[1][min_amount]', '100');

        $I->click('Save', '.page-header-action');

        $I->expect('success with location delivery areas added');
        $I->see('Location updated successfully.', '.alert-success');

        $I->amGoingTo('search for this location as a customer');
        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->amOnPage('/');
                $I->amGoingTo('enter a valid postcode or address');
                $I->fillField('search_query', 'DA2 7PP');
                $I->click('#search');
                $I->wait('2');

                $I->see('Dartford can deliver to you at DA2 7PP', '.panel-local');
            });
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('add a new restaurant location');

        $I->amOnPage('/admin/locations/edit');
        $I->seeInTitle('Location: New ‹ Administrator Panel');

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

        $I->amGoingTo('submit form with invalid values');
        $I->click('Location', '#nav-tabs');
        $I->fillField('location_name', '1');
        $I->fillField('email', 'locationexample.com');
        $I->fillField('telephone', 'tel456789');
        $I->fillField('address[postcode]', '00 000');
        $I->selectOption('address[country]', 'Turkey');

        $I->click('Save', '.page-header-action');

        $I->expect('form errors due to invalid values and blank fields');
        $I->see('The Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Address 1 field is required.', '.text-danger');
        $I->see('The City field is required.', '.text-danger');
        $I->see('The Email field must contain a valid email address.', '.text-danger');
    }

    public function testEditForm(AcceptanceTester $I) {
        $I->wantTo('add then update a location from the administrator panel');

        $this->doAddLocation($I);

        $I->seeInTitle('Location: Dartford ‹ Administrator Panel');

        $I->amGoingTo('enable restaurant delivery and collection order types and payments methods');
        $I->click('Order', '#nav-tabs');
        $I->toggleButton('input-offer-delivery');
        $I->toggleButton('input-offer-collection');
        $I->selectOption('payments[]', ['Cash On Delivery', 'PayPal Express']);

        $I->amGoingTo('add two tables to the restaurant seat map');
        $I->click('Reservation', '#nav-tabs');
        $I->selectAjaxOption('#s2id_input-table', 'SW');
        $I->selectAjaxOption('#s2id_input-table', 'NE');

        $I->amGoingTo('add the restaurant delivery area');
        $I->click('Delivery', '#nav-tabs');
        $I->click('button.area-new');
        $I->click('#delivery-area1 .panel-heading');
        $I->click('.area-types .area-type-circle');
        $I->fillField('delivery_areas[1][charge]', '10');
        $I->fillField('delivery_areas[1][min_amount]', '100');

        $I->click('Save', '.page-header-action');

        $I->expect('success with location order types, payments, tables and delivery areas updated');
        $I->see('Location updated successfully.', '.alert-success');
    }

    public function testDeleteLocation(AcceptanceTester $I) {
        $I->wantTo('delete a restaurant location');

        $this->doAddLocation($I);

        $I->amOnPage('/admin/locations');

        $I->amGoingTo('delete the added location in the list');
        $I->see('Dartford Dartford Kent DA2 7PJ 0123456789 Enabled', '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:last-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with location deleted and removed from the list');
        $I->see('Location deleted successfully.', '.alert-success');
        $I->dontSee('Dartford Dartford Kent DA2 7PJ 0123456789 Enabled', '#list-form tbody tr');
    }

    protected function doAddLocation(AcceptanceTester $I) {
        $I->amOnPage('/admin/locations/edit');
        $I->seeInTitle('Location: New ‹ Administrator Panel');

        $I->amGoingTo('add a new restaurant location');
        $I->click('Location', '#nav-tabs');
        $I->fillField('location_name', 'Dartford');
        $I->fillField('email', 'northampton@example.com');
        $I->fillField('telephone', '0123456789');
        $I->fillField('description', 'This is a restaurant location description or additional information');
        $I->fillField('address[address_1]', '35 Brewers Field');
        $I->fillField('address[address_2]', '');
        $I->fillField('address[city]', 'Dartford');
        $I->fillField('address[state]', 'Kent');
        $I->fillField('address[postcode]', 'DA2 7PJ');
        $I->selectOption('address[country]', 'United Kingdom');
        $I->chooseMedia('an image');
        $I->toggleButton('input-status');

        $I->click('Save', '.page-header-action');

        $I->expect('success with a new location added');
        $I->see('Location added successfully.', '.alert-success');
        $I->seeInField('location_name', 'Dartford');
        $I->seeInField('email', 'northampton@example.com');
        $I->seeInField('telephone', '0123456789');
        $I->seeInField('address[address_1]', '35 Brewers Field');
        $I->seeInField('address[address_2]', '');
        $I->seeInField('address[city]', 'Dartford');
        $I->seeInField('address[state]', 'Kent');
        $I->seeInField('address[postcode]', 'DA2 7PJ');
    }
}