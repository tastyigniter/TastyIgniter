<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('manage orders from the administrator panel');

// Login Test staff user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to \'orders\' page, check page title, header and action buttons');
$I->amOnPage('/admin/orders');
$I->seeInTitle('Orders ‹ Administrator Panel');
$I->see('Orders', '.page-header h1');
$I->see('Delete', '.page-header-action');
$I->see('Order List', 'h3');

//--------------------------------------------------------------------
// Expect list of orders
//--------------------------------------------------------------------
$I->expectTo('see list of all orders');
$I->seeTableHeads('#list-form', ['ID', 'Location', 'Customer Name',
    'Status', 'Type', 'Total', 'Time - Date']);
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

//--------------------------------------------------------------------
//
// I want to change order status
//
//--------------------------------------------------------------------
$I->amGoingTo('view the first order from the list of orders');
$I->seeElement('#list-form tbody tr:first-child .btn-edit');
$I->click('#list-form tbody tr:first-child .btn-edit');
//$I->seeInTitle('Order: 20015 ‹ Administrator Panel');
$I->see('Order', '.page-header h1');
$I->seeElement('.page-header .btn-back');
$I->see('Save', '.page-header-action');
$I->see('Save & Close', '.page-header-action');

$I->expectTo('see nav tabs');
$I->seeNavTabs(['Order', 'Status', 'Restaurant', 'Delivery Address', 'Payment', 'Menus']);

$I->amGoingTo('change the order status from received to pending');
$I->lookForwardTo('send it to kitchen staff for preparation');
$I->click('Status', '#nav-tabs');
$I->seeInFormFields('#edit-form', [
    'assignee_id'       => '',
    'order_status'      => '11',
    'status_comment'    => 'Your order has been received.',
    'notify'            => '1',
]);

$I->selectOption('#edit-form select[name=order_status]', 'Pending');
$I->wait(2);
$I->click('Save', '.page-header-action');

$I->expectTo('see updated status in status history');
$I->click('Status', '#nav-tabs');
$I->see('Pending', '#edit-form #history tbody tr:first-child');
$I->see('Your order is pending', '#edit-form #history tbody tr:first-child');

//--------------------------------------------------------------------
//
// I want to assign a single order to a kitchen staff
//
//--------------------------------------------------------------------
$I->amGoingTo('assign the order to kitchen staff for preparation');
$I->see('Assign Staff', '.form-group');
$I->selectOption('#edit-form select[name=assignee_id]', 'Kitchen Staff');
$I->selectOption('#edit-form select[name=order_status]', 'Preparation');
$I->wait(2);
$I->click('Save', '.page-header-action');

$I->expectTo('see assignee staff in status history');
$I->click('Status', '#nav-tabs');
$I->see('Admin', '#edit-form #history tbody tr:first-child');
$I->see('Kitchen Staff', '#edit-form #history tbody tr:first-child');
$I->see('Preparation', '#edit-form #history tbody tr:first-child');
$I->see('Your order is in the kitchen', '#edit-form #history tbody tr:first-child');

$I->comment('All Done!');