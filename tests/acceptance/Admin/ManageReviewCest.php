<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageReviewCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->wantTo('view reviews from the administrator panel');

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amOnPage('/admin/reviews');
        $I->seeInTitle('Reviews ‹ Administrator Panel');

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
    }

    public function testStatusField(AcceptanceTester $I) {
        $I->wantTo('update an order review status');

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amGoingTo('add a new order review as admin');
        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->doCreateCustomerOrder($I);
            });
        $this->doAddOrderReviewAsAdmin($I);

        $I->seeInTitle('Review: Lewisham ‹ Administrator Panel');

        $I->amGoingTo('update review status as approved');
        $I->toggleButton('input-status');
        $I->click('Save', '.page-header-action');

        $I->expect('success with review approved');
        $I->see('Review updated successfully.', '.alert-success');
        $I->see('Approved', 'label.active');
    }

    public function testSaleIDField(AcceptanceTester $I) {
        $I->wantTo('add an order review');

        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->doCreateCustomerOrder($I);
            });

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amOnPage('/admin/reviews/edit');
        $I->seeInTitle('Review: New ‹ Administrator Panel');

        $I->amGoingTo('switch the sale type to Reservation');
        $I->lookForwardTo('can check error with sale ID not found');
        $I->fillField('sale_id', '20016');
        $I->toggleButton('input-sale-type');

        $I->click('Save', '.page-header-action');

        $I->expect('form errors due to sale ID not found in Reservation sale type');
        $I->see('The Sale ID entered can not be found in reservations', '.text-danger');
        $I->dontSee('Details updated successfully.', '.alert-success');
    }

    public function testApproveCustomerReview(AcceptanceTester $I) {
        $I->wantTo('approve an order review add by customer');

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amGoingTo('add a new order review as a customer');
        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->doCreateCustomerOrder($I);
                $this->doAddOrderReviewAsCustomer($I);
            });

        $I->amOnPage('/admin/reviews');
        $I->click('#list-form tbody tr:first-child .btn');

        $I->amGoingTo('update review status as approved');
        $I->see('Pending Review', 'label.active');
        $I->toggleButton('input-status');
        $I->click('Save', '.page-header-action');

        $I->expect('success with review approved');
        $I->see('Review updated successfully.', '.alert-success');
        $I->see('Approved', 'label.active');
    }

    public function testFailedEditForm(AcceptanceTester $I) {
        $I->wantTo('add an order review');

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amOnPage('/admin/reviews/edit');
        $I->seeInTitle('Review: New ‹ Administrator Panel');

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
    }

    public function testDeleteReview(AcceptanceTester $I) {
        $I->wantTo('delete an order review');

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amGoingTo('add a new order review as admin');
        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->doCreateCustomerOrder($I);
            });
        $this->doAddOrderReviewAsAdmin($I);

        $I->amOnPage('/admin/reviews');

        $I->amGoingTo('delete the added review in the list');
        $I->see('Lewisham John Doe 20016 Order Pending Review '.date('d M y'), '#list-form tbody tr');
        $I->checkOption('#list-form tbody tr:first-child input[type=checkbox]');
        $I->click('Delete', '.page-header-action');
        $I->acceptPopup();

        $I->expect('success with review deleted and removed from the list');
        $I->see('Review deleted successfully.', '.alert-success');
        $I->dontSee('Lewisham John Doe 20016 Order Pending Review '.date('d M y'), '#list-form tbody tr');
    }

    protected function doAddOrderReviewAsAdmin(AcceptanceTester $I) {
        $I->amOnPage('/admin/reviews/edit');
        $I->seeInTitle('Review: New ‹ Administrator Panel');

        $I->amGoingTo('add review for the customer order');
        $I->selectOption('select[name=location_id]', 'Lewisham');
        $I->fillField('sale_id', '20016');
        $I->selectAjaxOption('#s2id_input-author', 'john');
        $I->click('div[data-score-name="rating[quality]"] i[data-alt="4"]');
        $I->click('div[data-score-name="rating[delivery]"] i[data-alt="3"]');
        $I->click('div[data-score-name="rating[service]"] i[data-alt="5"]');
        $I->fillField('review_text', 'This is a sample review text');

        $I->click('Save', '.page-header-action');

        $I->expect('success with review added');
        $I->see('Review added successfully.', '.alert-success');
        $I->seeInField('sale_id', '20016');
        $I->seeOptionIsSelected('select[name=location_id]', 'Lewisham');
        $I->see('Pending Review', 'label.active');
    }

    protected function doAddOrderReviewAsCustomer(AcceptanceTester $I) {
        $I->amOnPage('/account/reviews/add/order/20016/11');
        $I->seeInTitle('Write Review');

        $I->amGoingTo('add review for the order');
        $I->click('div[data-score-name="rating[quality]"] i[data-alt="4"]');
        $I->click('div[data-score-name="rating[delivery]"] i[data-alt="3"]');
        $I->click('div[data-score-name="rating[service]"] i[data-alt="5"]');
        $I->fillField('review_text', 'This is a sample review text.');
        $I->click('form button[type=submit]');

        $I->expect('success with customer review sent to admin for approval');
        $I->see('Review sent successfully, it will be visible once approved.', '.alert-success');
    }
}