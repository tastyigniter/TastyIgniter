<?php
// @group main

$I = new AcceptanceTester($scenario);
$I->am('Customer');
$I->wantTo('search location, add menu to order and apply coupon');

$I->amGoingTo('navigate to \'local restaurant\' page, check page title and header');
$I->amOnPage('/local/lewisham');
$I->seeInTitle('Lewisham - Restaurant');
$I->see('Lewisham', 'h4');
$I->see('Restaurants Lewisham', '.breadcrumb');

$I->expectTo('see list of menu items');
$I->seeElement('.menu-items');
$I->seeElement('.menu-items > .menu-category');
$I->seeElement('.menu-items > #menu76.menu-item');
$I->see('puff-puff', '.menu-items > #menu76.menu-item');
$I->see('Traditional Nigerian donut ball, rolled in sugar', '.menu-items > #menu76.menu-item');
$I->see('£4.99', '.menu-items > #menu76.menu-item');
$I->seeElement('.menu-items > #menu77.menu-item');
$I->see('scotch egg', '.menu-items > #menu77.menu-item');
$I->see('Boiled egg wrapped in a ground meat mixture, coated in breadcrumbs, and deep-fried.', '.menu-items > #menu77.menu-item');
$I->see('£2.00', '.menu-items > #menu77.menu-item');
$I->seeElement('.menu-items > #menu81.menu-item');
$I->see('WHOLE CATFISH WITH RICE AND VEGETABLES', '.menu-items > #menu81.menu-item');
$I->see('Whole catfish slow cooked in tomatoes, pepper and onion sauce with seasoning to taste', '.menu-items > #menu81.menu-item');
$I->see('£13.99', '.menu-items > #menu81.menu-item');

$I->amGoingTo('check the categories sidebar links');
$I->click('a[data-filter=".appetizer"]');
$I->wait('3');
$I->see('Appetizer', '.menu-category h3');
$I->click('a[data-filter=".salads"]');
$I->wait('3');
$I->see('Salads', '.menu-category h3');
$I->click('a[data-filter=".seafoods"]');
$I->wait('3');
$I->see('Seafoods', '.menu-category h3');
$I->click('a[data-filter=".traditional"]');
$I->wait('3');
$I->see('Traditional', '.menu-category h3');
$I->click('a[data-filter=".vegetarian"]');
$I->wait('3');
$I->see('Vegetarian', '.menu-category h3');
$I->click('a[data-filter=".soups"]');
$I->wait('3');
$I->see('Soups', '.menu-category h3');
$I->click('a[data-filter=".rice-dishes"]');
$I->wait('3');
$I->see('Rice Dishes', '.menu-category h3');
$I->click('a[data-filter=".main-course"]');
$I->wait('3');
$I->see('Main Course', '.menu-category h3');
$I->click('a[data-filter="all"]');

//--------------------------------------------------------------------
// Ensure no menu exist in order
//--------------------------------------------------------------------
$I->expectTo('see no menus added in cart');
$I->seeElement('#cart-box #cart-info');
$I->see('There are no menus added in your cart.', '#cart-info');

//--------------------------------------------------------------------
// Error with no search query found
//--------------------------------------------------------------------
$I->amGoingTo('add menu to order before entering postcode/address');
$I->click('#menu76 .btn-cart');
$I->wait('2');

$I->expect('error due to blank postcode/address');
$I->seeElement('#menu76 .btn-cart.failed');
$I->dontSeeElement('#cart-alert .alert-success');
$I->see('Please type in a postcode/address to check if we can deliver to you.', '#cart-alert');

//--------------------------------------------------------------------
// Success with search query found
//--------------------------------------------------------------------
$I->amGoingTo('enter postcode/address to check if restaurant can deliver');
$I->seeElement('.panel-local input[name=search_query]');
$I->fillField('search_query', 'E9 6QH');
$I->click('#search');
$I->wait('2');

$I->expect('success after customer enter their postcode/address');
$I->see('Lewisham can deliver to you at E9 6QH', '.panel-local');

//--------------------------------------------------------------------
// Success with menu added to order
//--------------------------------------------------------------------
$I->amGoingTo('add menu to order again');
$I->click('#menu76 .btn-cart');
$I->wait('2');

$I->expectTo('see menu added to order successfully');
$I->seeElement('#menu76 .btn-cart.added');
$I->see('Menu has been added to your order.', '#cart-alert .alert-success');

$I->expect('the menu\'s quantity added to order to be its minimum quantity');
$I->see('3 × puff-puff', '.cart-items li:first-child');
$I->see('£14.97', '.cart-items li:first-child');

// Ensure user can hide alert message
$I->click('#cart-alert .close');
$I->dontSeeElement('#cart-alert .alert-success');

//--------------------------------------------------------------------
// Remove menu from order
//--------------------------------------------------------------------
$I->amGoingTo('remove menu from order');
$I->click('#cart-box .cart-items li:first-child .remove');
$I->wait('2');

$I->expect('success with menu removed from order');
$I->see('Menu has been updated successfully', '#cart-alert .alert-success');
$I->see('There are no menus added in your cart.', '#cart-info');

//--------------------------------------------------------------------
// Add menu with menu options to order
//--------------------------------------------------------------------
$I->amGoingTo('add menu with menu options to order');
$I->see('whole catfish with rice and veg', '#menu81');
$I->click('#menu81 .btn-cart');
$I->wait('2');

$I->expectTo('see the menu option modal');
$I->seeElement('#optionsModal .modal-menu-options');
$I->seeElement('#optionsModal #menu-options81');
$I->see('Whole catfish with rice and vegetables', '#menu-options81');
$I->see('£13.99', '#menu-options81');

//--------------------------------------------------------------------
// Expect success controlling the quantity plus and minus controls
//--------------------------------------------------------------------
$I->amGoingTo('check the quantity plus and minus controls, that it does not reach a negative number');
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

$I->expect('success with positive number');
$I->dontSeeInField('#menu-options81 input[name=quantity]','-1');
$I->click('#menu-options81 button[data-dir=dwn]');
$I->seeInField('#menu-options81 input[name=quantity]','0');
$I->click('#menu-options81 button[data-dir=up]');
$I->seeInField('#menu-options81 input[name=quantity]','1');

//--------------------------------------------------------------------
// Select menu option and add to order
//--------------------------------------------------------------------
$I->amGoingTo('select menu options in modal and add to order');
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
$I->fillField('comment', 'I want it extra hot');
$I->click('UPDATE', '#menu-options81');
$I->wait('2');

$I->expect('success with menu and menu options added to order');
$I->see('Menu has been added to your order.', '#cart-alert .alert-success');

$I->amGoingTo('check that menu was added successfully');
$I->see('1 × whole catfish with rice a...', '.cart-items li:first-child');
$I->see('+ Fish = 4.00', '.cart-items li:first-child');
$I->see('+ Jalapenos = 3.99', '.cart-items li:first-child');
$I->see('+ Peperoni = 1.99', '.cart-items li:first-child');
$I->see('+ Sweetcorn = 1.99', '.cart-items li:first-child');
$I->see('[I want it extra hot]', '.cart-items li:first-child');
$I->see('£25.96', '.cart-items li:first-child');

//--------------------------------------------------------------------
// Expect success with cart total
//--------------------------------------------------------------------
$I->amGoingTo('check the  sub total, cart total and delivery charge');
$I->see('Sub Total: £25.96', '.cart-total');
$I->see('Delivery: £10.00', '.cart-total');
$I->see('Delivery Cost: £10.00', '.panel-local');
$I->see('Order Total: £35.96', '.cart-total');

//--------------------------------------------------------------------
// Switch between delivery and collection order type
//--------------------------------------------------------------------
$I->amGoingTo('switch to collection order type');
$I->seeElement('.location-control .order-type');
$I->click('.location-control .order-type label:not(.active)');
$I->wait('2');

$I->expect('delivery cost removed from order total');
$I->see('Sub Total: £25.96', '.cart-total');
$I->dontSee('Delivery: £10.00', '.cart-total');
$I->see('Order Total: £25.96', '.cart-total');

$I->amGoingTo('switch to delivery order type');
$I->click('.location-control .order-type label:not(.active)');
$I->wait('2');

$I->expect('delivery cost added to order total');
$I->see('Sub Total: £25.96', '.cart-total');
$I->see('Delivery: £10.00', '.cart-total');
$I->see('Order Total: £35.96', '.cart-total');

// Expect error with minimum delivery order total
$I->expect('error due to current order total below minimum delivery order total');
$I->see('Min. Order Amount: £100.00', '.panel-local dd');
$I->see('Order Total: £35.96', '.cart-total');
$I->see('Order total is below the minimum delivery order total.', '#local-alert .alert-danger');

//--------------------------------------------------------------------
// Expect success with order menu quantity updated
//--------------------------------------------------------------------
$I->amGoingTo('update menu quantity in cart');
$I->lookForwardTo('increase the order total amount');
$I->see('1 × whole catfish with rice a...', '.cart-items li:first-child');
$I->click('#cart-box .cart-items li:first-child .name-image');
$I->wait('2');

$I->expectTo('see the menu option modal with previous selected options');
$I->seeElement('#optionsModal .modal-menu-options');
$I->seeElement('#optionsModal #menu-options81');
$I->seeCheckboxIsChecked('#menu-options81 .option-checkbox .checkbox:nth-child(4) input[type="checkbox"]');
$I->seeCheckboxIsChecked('#menu-options81 .option-checkbox .checkbox:nth-child(5) input[type="checkbox"]');
$I->seeCheckboxIsChecked('#menu-options81 .option-checkbox .checkbox:nth-child(6) input[type="checkbox"]');
$I->fillField('#menu-options81 input[name=quantity]', 100);
$I->click('UPDATE', '#menu-options81');
$I->wait('2');

$I->expect('success with menu quantity updated to 100');
$I->see('Menu has been updated successfully', '#cart-alert .alert-success');
$I->see('100 × whole catfish with rice a...', '.cart-items li:first-child');
$I->see('Sub Total: £2,596.00', '.cart-total');
$I->see('Delivery: £10.00', '.cart-total');
$I->see('Order Total: £2,606.00', '.cart-total');

//--------------------------------------------------------------------
//
// I want to apply coupon
//
//--------------------------------------------------------------------
$I->amGoingTo('enter an invalid/expired coupon');
$I->fillField('coupon_code', '382903');
$I->click('Apply Coupon', '.cart-coupon');
$I->wait('2');

$I->expect('error due to invalid or expired coupon');
$I->see('Your coupon is either invalid or expired.', '#cart-alert .alert-danger');
$I->dontSee('Coupon:', '.cart-total');

//--------------------------------------------------------------------
// Expect error with coupon order total limit
//--------------------------------------------------------------------
$I->amGoingTo('enter an valid coupon');
$I->expect('valid coupon (5555) can not be applied to order total');
$I->fillField('coupon_code', '5555');
$I->click('Apply Coupon', '.cart-coupon');
$I->wait('2');

$I->expect('error can not be applied due to below minimum order total');
$I->see('Your coupon can not be applied to orders below £5,000.00.', '#cart-alert .alert-danger');
$I->dontSee('Coupon:', '.cart-total');

//--------------------------------------------------------------------
// Successfully apply coupon to order
//--------------------------------------------------------------------
$I->amGoingTo('enter an valid coupon');
$I->fillField('coupon_code', '2222');
$I->click('Apply Coupon', '.cart-coupon');
$I->wait('2');

$I->expect('success with coupon applied to order');
$I->see('Your coupon has been applied successfully.', '#cart-alert .alert-success');
$I->see('Coupon:   -£100.00', '.cart-total');
$I->see('Order Total: £2,506.00', '.cart-total');

$I->comment('All Done!');