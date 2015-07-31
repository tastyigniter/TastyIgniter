<?php
$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('view list of customer recent orders then view, review and re-order a recent order.');

// Login Test user
$I->login('demo@demo.com', 'monday');

$I->amGoingTo('navigate to \'recent orders\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/orders');
$I->seeInTitle('Address Book');
$I->see('Recent Orders', 'h2');
$I->seeElement('.breadcrumb');
$I->see('My Account Recent Orders', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Expect all recent orders on Orders page without order #20015 missing
//--------------------------------------------------------------------
$I->expectTo('see list of recent orders with order number (20015) present');
$I->dontSee('There are no order(s).', '.order-lists');
$I->see('20015');
$I->see('ID', '.order-lists thead th');
$I->see('Status', '.order-lists thead th');
$I->see('Location', '.order-lists thead th');
$I->see('Ready Time - Date', '.order-lists thead th');
$I->see('Order Type', '.order-lists thead th');
$I->see('Total Items', '.order-lists thead th');
$I->see('Order Total', '.order-lists thead th');
$I->seeElement('.order-lists tbody td');
$I->see('Displaying 1 to ');  // ensure pagination is present.

//--------------------------------------------------------------------
// Check back navigation link and place new order link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link and place new order link');
$I->seeLink('Back', '/account');
$I->seeLink('Place New Order', '/locations');
//--------------------------------------------------------------------
// Expect back button and place an order links work.
//--------------------------------------------------------------------
$I->expect('the back and place an order buttons to be linked');
$I->click('Back');
$I->see('My Account', 'h2');
$I->amOnPage('/account/orders');
$I->click('Place New Order');

$I->wantTo('view, review and re-order a recent order.');
// Navigate to Order #20015 View Page
$I->amOnPage('/account/orders/view/20015');
$I->seeInCurrentUrl('orders/view/20015');
$I->see('My Order View', 'h2');
$I->seeElement('.breadcrumb');

//--------------------------------------------------------------------
// Expect all order info to be displayed -- for delivery order**
//--------------------------------------------------------------------
$I->expect('all order info to be displayed');
$I->see('ID:', 'table td b');
$I->see('20015', 'table td');
$I->see('Ready Time - Date:', 'table td b');
$I->see('16:39 - 15 Jul 15', 'table td');
$I->see('Order Type:', 'table td b');
$I->see('Delivery', 'table td');
$I->see('Delivery:', 'table td b');
$I->see('5 Paragon Rd', 'table td');
$I->see('Location:', 'table td b');
$I->see('Lewisham', 'table td');

//--------------------------------------------------------------------
// Expect order menu and options to be displayed
//--------------------------------------------------------------------
$I->expect('order menu and options to be displayed');
$I->see('Name/Options', 'table th');
$I->see('Price', 'table th');
$I->see('Total', 'table th');
$I->see('100x', 'table td');
$I->see('Whole catfish with rice and vegetables', 'table td');
$I->see('+ Chicken, Jalapenos, Peperoni, Sweetcorn', 'table td');
$I->see('£25.96', 'table td');
$I->see('£2,596.00', 'table td');
$I->see('Delivery', 'table td b');
$I->see('£10.00', 'table td b');
$I->see('Order Total', 'table td b');
$I->see('£2,770.67', 'table td b');

//--------------------------------------------------------------------
// Expect back and re-order buttons to be linked
//--------------------------------------------------------------------
$I->expect('the back and re-order buttons to be linked');
$I->click('Back');
$I->see('Recent Orders', 'h2');

$I->amOnPage('/account/orders/view/20015');
$I->click('Re-Order');
$I->see('You have successfully added the menus from order ID 20015 to your order.', '.alert-success');
$I->seeInCurrentUrl('local/lewisham');