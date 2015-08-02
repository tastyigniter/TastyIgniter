<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('successfully add menu to order');

$I->amOnPage('/local/lewisham');
$I->see('Lewisham', '.breadcrumb');
$I->seeElement('.menu-items');
$I->seeElement('.menu-items > .menu-category');
$I->seeElement('.menu-items > .menu-item');

// Ensure no menu exist in order
$I->see('There are no menus added in your cart.', '#cart-info');

//--------------------------------------------------------------------
// Expect error with no search query found
//--------------------------------------------------------------------
$I->expect('error due to customer yet to enter their search query');
$I->click('#menu76 .btn-cart');
$I->wait('2');
$I->seeElement('#menu76 .btn-cart.failed');
$I->dontSeeElement('#cart-alert .alert-success');
$I->see('Please type in a postcode/address to check if we can deliver to you.', '#cart-alert');

//--------------------------------------------------------------------
// Expect success with search query found
//--------------------------------------------------------------------
$I->expect('success after customer enter their search query');
$I->seeElement('.panel-local input[name=search_query]');
$I->fillField('search_query', 'E9 6QH');
$I->click('#search');
$I->wait('2');
$I->see('Lewisham can deliver to you at E9 6QH');

//--------------------------------------------------------------------
// Expect success with menu added to order
//--------------------------------------------------------------------
$I->expect('to add menu to order successfully');
$I->click('#menu76 .btn-cart');
$I->wait('2');
$I->seeElement('#menu76 .btn-cart.added');
$I->see('Menu has been added to your order.', '#cart-alert .alert-success');

// Ensure user can hide alert message
$I->click('#cart-alert .close');
$I->dontSeeElement('#cart-alert .alert-success');

$I->expect('the menu\'s quantity added to order to be its minimum quantity');
$I->see('3 × puff-puff', '.cart-items li:first-child');
$I->see('£14.97', '.cart-items li:first-child');

//--------------------------------------------------------------------
// Expect success with menu removed from order
//--------------------------------------------------------------------
$I->expect('customer to successfully remove menu from order');
$I->click('#cart-box .cart-items li:first-child .remove');
$I->wait('2');
$I->see('Menu has been updated successfully', '#cart-alert .alert-success');
$I->see('There are no menus added in your cart.', '#cart-info');

//--------------------------------------------------------------------
// Expect success with menu option modal opened
//--------------------------------------------------------------------
$I->expect('menu option modal to popup');
$I->see('whole catfish with rice and veg', '#menu81');
$I->click('#menu81 .btn-cart');
$I->wait('2');
$I->seeElement('#optionsModal .modal-menu-options');
$I->seeElement('#optionsModal #menu-options81');
$I->see('Whole catfish with rice and vegetables', '#menu-options81');
$I->see('£13.99', '#menu-options81');

//--------------------------------------------------------------------
// Expect success controlling the quantity plus and minus controls
//--------------------------------------------------------------------
$I->expect('success with quantity plus and minus controls');
$I->see('Menu Quantity', '#menu-options81');
$I->seeInField('#menu-options81 input[name=quantity]','1');
$I->click('#menu-options81 button[data-dir=up]');
$I->seeInField('#menu-options81 input[name=quantity]','2');
$I->click('#menu-options81 button[data-dir=up]');
$I->seeInField('#menu-options81 input[name=quantity]','3');
$I->click('#menu-options81 button[data-dir=dwn]');
$I->seeInField('#menu-options81 input[name=quantity]','2');
$I->click('#menu-options81 button[data-dir=dwn]');
$I->seeInField('#menu-options81 input[name=quantity]','1');
$I->click('#menu-options81 button[data-dir=dwn]');
$I->seeInField('#menu-options81 input[name=quantity]','0');
$I->click('#menu-options81 button[data-dir=dwn]');
$I->seeInField('#menu-options81 input[name=quantity]','0');
$I->dontSeeInField('#menu-options81 input[name=quantity]','-1');
$I->click('#menu-options81 button[data-dir=up]');
$I->seeInField('#menu-options81 input[name=quantity]','1');

//--------------------------------------------------------------------
// Expect success with menu and options added to order
//--------------------------------------------------------------------
$I->expect('success with selecting menu options');
$I->see('Cooked', '#menu-options81 .menu-options');
$I->see('Meat £3.00', '#menu-options81 .menu-options');
$I->see('Chicken £4.00', '#menu-options81 .menu-options');
$I->see('Fish £4.00', '#menu-options81 .menu-options');
$I->click('#menu-options81 .option-radio .radio:last-child label');
$I->see('Toppings', '#menu-options81 .menu-options');
$I->see('Jalapenos £3.99', '#menu-options81 .menu-options');
$I->see('Peperoni £1.99', '#menu-options81 .menu-options');
$I->see('Sweetcorn £1.99', '#menu-options81 .menu-options');
$I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(4) input[type="checkbox"]');
$I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(5) input[type="checkbox"]');
$I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(6) input[type="checkbox"]');
$I->see('Add Comment', '#menu-options81');
$I->click('UPDATE', '#menu-options81');
$I->wait('2');
$I->see('Menu has been added to your order.', '#cart-alert .alert-success');

$I->expect('added menu to be shown in my order');
$I->see('1 × whole catfish with rice a...', '.cart-items li:first-child');
$I->see('+ Fish = 4.00', '.cart-items li:first-child');
$I->see('+ Jalapenos = 3.99', '.cart-items li:first-child');
$I->see('+ Peperoni = 1.99', '.cart-items li:first-child');
$I->see('+ Sweetcorn = 1.99', '.cart-items li:first-child');
$I->see('£25.96', '.cart-items li:first-child');

//--------------------------------------------------------------------
// Expect success with cart total
//--------------------------------------------------------------------
$I->expect('success with sub total, cart total and delivery charge');
$I->see('Sub Total: £25.96', '.cart-total');
$I->see('Delivery: £10.00', '.cart-total');
$I->see('Delivery Cost: £10.00', '.panel-local');
$I->see('Order Total: £35.96', '.cart-total');

//--------------------------------------------------------------------
// Expect error with minimum delivery order total
//--------------------------------------------------------------------
$I->expect('customer to switch to collection order type and delivery cost removed');
$I->seeElement('.location-control .order-type');
$I->click('.location-control .order-type label:not(.active)');
$I->wait('2');
$I->dontSee('Delivery: £10.00', '.cart-total');
$I->see('Order Total: £25.96', '.cart-total');

$I->expect('customer to switch to delivery order type and delivery cost added');
$I->click('.location-control .order-type label:not(.active)');
$I->wait('2');
$I->see('Delivery: £10.00', '.cart-total');
$I->see('Order Total: £35.96', '.cart-total');

$I->expect('error due to minimum delivery order total');
$I->see('Min. Order Amount: £100.00', '.panel-local dd');
$I->see('Order total is below the minimum delivery order total.', '#local-alert .alert-danger');

//--------------------------------------------------------------------
// Expect success with order menu quantity updated
//--------------------------------------------------------------------
$I->expect('customer to successfully update order menu quantity');
$I->click('#cart-box .cart-items li:first-child .name-image');
$I->wait('2');
$I->seeElement('#optionsModal .modal-menu-options');
$I->seeElement('#optionsModal #menu-options81');
$I->seeCheckboxIsChecked('#menu-options81 .option-checkbox .checkbox:nth-child(4) input[type="checkbox"]');
$I->seeCheckboxIsChecked('#menu-options81 .option-checkbox .checkbox:nth-child(5) input[type="checkbox"]');
$I->seeCheckboxIsChecked('#menu-options81 .option-checkbox .checkbox:nth-child(6) input[type="checkbox"]');
$I->fillField('#menu-options81 input[name=quantity]', 100);
$I->click('UPDATE', '#menu-options81');
$I->wait('2');
$I->see('Menu has been updated successfully', '#cart-alert .alert-success');

$I->expect('order total to be updated');
$I->see('Sub Total: £2,596.00', '.cart-total');
$I->see('Delivery: £10.00', '.cart-total');
$I->see('Order Total: £2,606.00', '.cart-total');

//--------------------------------------------------------------------
// Expect error with invalid or expired coupon
//--------------------------------------------------------------------
$I->expect('error due to invalid or expired coupon');
$I->fillField('coupon_code', '382903');
$I->click('Apply Coupon', '.cart-coupon');
$I->wait('2');
$I->see('Your coupon is either invalid or expired.', '#cart-alert .alert-danger');
$I->dontSee('Coupon:', '.cart-total');

//--------------------------------------------------------------------
// Expect error with coupon order total limit
//--------------------------------------------------------------------
$I->expect('valid coupon (5555) can not be applied to order total');
$I->fillField('coupon_code', '5555');
$I->click('Apply Coupon', '.cart-coupon');
$I->wait('2');
$I->see('Your coupon can not be applied to orders below £5,000.00.', '#cart-alert .alert-danger');
$I->dontSee('Coupon:', '.cart-total');

//--------------------------------------------------------------------
// Successfully apply coupon to order
//--------------------------------------------------------------------
$I->expect('success when apply coupon to order');
$I->fillField('coupon_code', '2222');
$I->click('Apply Coupon', '.cart-coupon');
$I->wait('2');
$I->see('Your coupon has been applied successfully.', '#cart-alert .alert-success');
$I->see('Coupon:   -£100.00', '.cart-total');
$I->see('Order Total: £2,506.00', '.cart-total');
