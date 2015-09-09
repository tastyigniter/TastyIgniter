<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ManageOrderCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
    }

    public function displayList(AcceptanceTester $I) {
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->wantTo('view orders from the administrator panel');

        $I->amOnPage('/admin/orders');
        $I->seeInTitle('Orders ‹ Administrator Panel');

        $I->expectTo('see list of all orders');
        $I->see('ID Location Customer Name Status Type Total Time - Date', '#list-form thead tr');
        $I->seeElement('#list-form tbody td');
        $I->seeNumberOfElements('#list-form tbody tr', [1,20]); //between 1 and 20 elements
        $I->dontSee('There are no orders available.', '#list-form');
        $I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

        $I->expectTo('see controls to filter order list by location, status, type or date');
        $I->click('.btn-filter');
        $I->waitForElementVisible('.panel-filter', 2);
        $I->seeElement('#filter-form input[name=filter_search]');
        $I->seeElement('#filter-form select[name=filter_location]');
        $I->seeElement('#filter-form select[name=filter_status]');
        $I->seeElement('#filter-form select[name=filter_type]');
        $I->seeElement('#filter-form select[name=filter_date]');
    }

    public function testChangeStatusAndAssignStaff(AcceptanceTester $I) {
        $I->wantTo('change an order status');

        $I->haveFriend('customer')
            ->does(function(AcceptanceTester $I) {
                $I->am('Customer');
                $I->doCreateCustomerOrder($I);
            });

        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');

        $I->amGoingTo('change the order status from received to pending');
        $I->lookForwardTo('prepare the order to be assigned to a kitchen staff');

        $I->amOnPage('/admin/orders/edit?id=20016');
        $I->seeInTitle('Order: 20016 ‹ Administrator Panel');

        $I->click('Status', '#nav-tabs');
        $I->seeInFormFields('#edit-form', [
            'assignee_id'       => '',
            'order_status'      => '11',
            'status_comment'    => 'Your order has been received.',
            'notify'            => '1',
        ]);

        $I->selectOption('#edit-form select[name=order_status]', 'Pending');
        $I->waitForText('Your order is pending', 2, 'textarea[name=status_comment]');
        $I->click('Save', '.page-header-action');

        $I->expectTo('see updated status in status history');
        $I->click('Status', '#nav-tabs');
        $I->see('Pending Admin Your order is pending YES', '#edit-form #history tbody tr');

        $I->amGoingTo('assign the order to kitchen staff for preparation');
        $I->see('Assign Staff', '.form-group');
        $I->selectOption('#edit-form select[name=assignee_id]', 'Kitchen Staff');
        $I->selectOption('#edit-form select[name=order_status]', 'Preparation');
        $I->waitForText('Your order is in the kitchen', 2, 'textarea[name=status_comment]');
        $I->click('Save', '.page-header-action');

        $I->expectTo('see assignee staff in status history');
        $I->click('Status', '#nav-tabs');
        $I->see('Preparation Admin Kitchen Staff Your order is in the kitchen YES', '#edit-form #history tbody tr');
    }
}