<?php
$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('view customer recent orders list and a single recent order, then re-order.');

// Login Test user
$I->login('demo@demo.com', 'monday');

$I->amGoingTo('navigate to \'recent orders\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/orders');
$I->seeInTitle('Recent Orders');
$I->see('Recent Orders', 'h2');
$I->see('My Account Recent Orders', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Expect list of recent orders on Orders page without order #20015 missing
//--------------------------------------------------------------------
$I->expectTo('see list of recent orders with order number (20015) present');
$I->dontSee('There are no order(s).', '.order-lists');
$I->seeNumberOfElements('.order-lists tbody tr', [1,10]); //between 1 and 10 elements
$I->see('20015');
$I->see('ID', '.order-lists thead th');
$I->see('Status', '.order-lists thead th');
$I->see('Location', '.order-lists thead th');
$I->see('Ready Time - Date', '.order-lists thead th');
$I->see('Order Type', '.order-lists thead th');
$I->see('Total Items', '.order-lists thead th');
$I->see('Order Total', '.order-lists thead th');
$I->seeElement('.order-lists tbody td');
$I->see('Displaying 1 to ', '.pagination-bar');  // I suppose pagination is present.

//--------------------------------------------------------------------
// Check back navigation link and place new order link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link and place new order link');
$I->seeLink('Back', '/account');
$I->seeLink('Place New Order', '/locations');

//--------------------------------------------------------------------
//
// I want to view a single recent order
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'view recent order\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/orders/view/20015');
$I->seeInTitle('My Order View');
$I->see('My Order View', 'h2');
$I->see('My Account Recent Orders My Order View', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Expect all order info to be displayed -- for delivery order**
//--------------------------------------------------------------------
$I->expect('all order info to be displayed');
$I->see('ID: 20015', 'table');
$I->see('Ready Time - Date: 16:39 - 15 Jul 15', 'table');
$I->see('Order Type: Delivery', 'table');
$I->see('Delivery: 5 Paragon Rd', 'table');
$I->see('Location: Lewisham', 'table');
$I->see('44 Darnley Road', 'table');

//--------------------------------------------------------------------
// Expect order menu and options to be displayed
//--------------------------------------------------------------------
$I->expect('order menu and options to be displayed');
$I->see('Name/Options Price Total', 'table');
$I->see('33x PUFF-PUFF', 'table');
$I->see('£4.99 £164.67', 'table');
$I->see('100x Whole catfish with rice and vegetables', 'table');
$I->see('+ Chicken, Jalapenos, Peperoni, Sweetcorn', 'table');
$I->see('£25.96 £2,596.00', 'table');
$I->see('Sub Total £2,760.67', 'table');
$I->see('Delivery £10.00', 'table');
$I->see('Order Total £2,770.67', 'table');

//--------------------------------------------------------------------
// Check back navigation link and place new order link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link and place new order link');
$I->seeLink('Back', '/account/orders');
$I->seeLink('Re-Order', '/account/orders/reorder/20015/11');

//--------------------------------------------------------------------
//
// I want to re-order a recent order
//
//--------------------------------------------------------------------
$I->amGoingTo('re-order this recent order');
$I->click('Re-Order');

$I->expect('order menu and options to be added to cart');
$I->see('You have successfully added the menus from order ID 20015 to your order.', '.alert-success');
$I->seeInCurrentUrl('local/lewisham');
$I->see('33 × puff-puff', '#cart-info');
$I->see('£164.67', '#cart-info');
$I->see('100 × whole catfish with rice a...', '#cart-info');
$I->see('+ Chicken = 4.00', '#cart-info');
$I->see('+ Jalapenos = 3.99', '#cart-info');
$I->see('+ Peperoni = 1.99', '#cart-info');
$I->see('+ Sweetcorn = 1.99', '#cart-info');
$I->see('£2,596.00', '#cart-info');
$I->see('Sub Total: £2,760.67', '#cart-info');
$I->see('Order Total: £2,760.67', '#cart-info');

$I->comment('All Done!');