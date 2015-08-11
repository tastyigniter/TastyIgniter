<?php
$I = new AcceptanceTester($scenario);
$I->am('Customer');
$I->wantTo('submit both new delivery and collection order as guest and registered customer');

//--------------------------------------------------------------------
// First search location then add menu to order
//--------------------------------------------------------------------
function testAddMenuToOrder($I) {
    $I->amGoingTo('navigate to \'home\' page, to search nearest location');
    $I->amOnPage('/');
    $I->fillField('search_query', 'E8 1BN');
    $I->click('#search');
    $I->wait('2');
    $I->see('Lewisham can deliver to you at E8 1BN');

    $I->amGoingTo('add menus to order then proceed with order');
    $I->click('#menu76 .btn-cart');
    $I->click('#menu81 .btn-cart');
    $I->wait('2');
    $I->seeElement('#optionsModal #menu-options81');
    $I->fillField('#menu-options81 input[name=quantity]', 10);
    $I->click('#menu-options81 .option-radio .radio:last-child label');
    $I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(4) input[type="checkbox"]');
    $I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(5) input[type="checkbox"]');
    $I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(6) input[type="checkbox"]');
    $I->click('UPDATE', '#menu-options81');
    $I->wait('2');

    $I->expectTo('see menu added to order successfully');
    $I->see('3 × puff-puff', '.cart-items');
    $I->see('10 × whole catfish with rice a...', '.cart-items');
    $I->see('Sub Total: £274.57', '.cart-total');
    $I->see('Delivery: £10.00', '.cart-total');
    $I->see('Order Total: £284.57', '.cart-total');
}
testAddMenuToOrder($I);

//--------------------------------------------------------------------
//
// Submit Delivery Order as Guest
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'Checkout\' page and first validate checkout form');
$I->seeLink('Checkout', '/checkout');
$I->click('Checkout', '.buttons');
$I->seeInTitle('Checkout');
$I->see('Checkout', '.breadcrumb');

$I->expect('customer is not logged in');
$I->see('Already have an account? Login Here', '#checkout .text-info');

$I->amGoingTo('check the checkout form is validated');
$I->lookForwardTo('submit delivery order as guest');
$fields = [
    'first_name'            => 'Guest',
    'last_name'             => 'Customer',
    'email'                 => 'guest_customer@example.com',
    'telephone'             => '444455634',
    'order_time'            => 'ASAP',
    'order_type'            => '1', // I suppose delivery selected
    'address[0][address_1]' => '95 Wilton Way',
    'address[0][address_2]' => '',
    'address[0][city]'      => 'London',
    'address[0][postcode]'  => 'E8 1BN',
    'address[0][country_id]'=> '222',
    'comment'               => 'I want it extra hot',
];

$bad_fields = $fields;
$bad_fields['email'] = 'demo@demo.com';
$bad_fields['address[0][address_1]'] = '';
$bad_fields['address[0][address_2]'] = '';
$bad_fields['address[0][city]'] = '';
$bad_fields['address[0][postcode]'] = '';
$bad_fields['address[0][country_id]'] = '222';
$I->seeElement('#checkout-form');
$I->submitForm('#checkout-form', $bad_fields, 'Payment');

$I->expect('form errors due to email already registered');
$I->see('Warning: E-Mail Address is already registered!', '.text-danger');
$I->see('This restaurant currently does not deliver to your address', '.text-danger');
$I->dontSee('The Delivery or Collection Time can not be less than current time!', '.text-danger');

$I->amGoingTo('submit delivery order as guest using checkout form');
$I->submitForm('#checkout-form', $fields, 'Payment');

$I->expect('success with form submitted and checkout progress to payment');
$I->see('Payment Method', '#payment');
$I->seeElement('input[name=payment][value=cod]');
$I->seeElement('input[name=payment][value=paypal_express]');

$I->expect('success with payment method selected and order confirmed');
$I->selectOption('#payment input[name=payment]', 'cod');
$I->click('Confirm', '.buttons');

$I->expectTo('see order confirmation page');
$I->see('Thanks for shopping with us online!');
$I->see('This is a delivery order.');
$I->see('Your Delivery Address:');
$I->see('95 Wilton Way');
$I->see('Sub Total: £274.57');
$I->see('Delivery: £10.00');
$I->see('Order Total: £284.57');
$I->see('Your local restaurant');
$I->see('Lewisham');
$I->see('44 Darnley Road');

//--------------------------------------------------------------------
//
// Submit Collection Order as Guest
//
//--------------------------------------------------------------------
$temp_fields = $fields;
$temp_fields['order_type'] = '2';
unset($temp_fields['address[0][address_1]']);
unset($temp_fields['address[0][address_2]']);
unset($temp_fields['address[0][city]']);
unset($temp_fields['address[0][postcode]']);
unset($temp_fields['address[0][country_id]']);

$I->amGoingTo('submit collection order as guest using checkout form');

testAddMenuToOrder($I);

$I->seeLink('Checkout', '/checkout');
$I->click('Checkout', '.buttons');
$I->seeInTitle('Checkout');
$I->see('Checkout', '.breadcrumb');

$I->expect('customer is not logged in');
$I->see('Already have an account? Login Here', '#checkout .text-info');

$I->click('#checkout .btn-group .btn:not(.active)');
$I->submitForm('#checkout-form', $temp_fields, 'Payment');

$I->expect('success with form submitted and checkout progress to payment');
$I->dontSee('This restaurant currently does not deliver to your address', '.text-danger');
$I->see('Payment Method', '#payment');
$I->seeElement('input[name=payment][value=cod]');
$I->seeElement('input[name=payment][value=paypal_express]');
$I->selectOption('#payment input[name=payment]', 'cod');
$I->click('Confirm', '.buttons');

$I->expectTo('see order confirmation page');
$I->see('Thanks for shopping with us online!');
$I->see('This is a collection order.');
$I->dontSee('Your Delivery Address:');
$I->see('Your local restaurant');
$I->see('Sub Total: £274.57');
$I->dontSee('Delivery: £10.00');
$I->see('Order Total: £274.57');

$I->login('demo@demo.com', 'monday');

//--------------------------------------------------------------------
//
// Submit Delivery Order as Registered Customer
//
//--------------------------------------------------------------------
$I->amGoingTo('submit delivery order as registered customer using checkout form');

testAddMenuToOrder($I);

$I->amOnPage('/checkout');
$I->seeInTitle('Checkout');
$I->see('Checkout', '.breadcrumb');

$I->expect('customer is logged in and form fields are populated with customer information');
$I->see('Welcome Back', '#checkout .text-info');

$I->seeElement('#checkout-form');
$I->click('Payment', '.buttons');

$I->expect('success with form submitted and checkout progress to payment');
$I->see('Payment Method', '#payment');
$I->seeElement('input[name=payment][value=cod]');
$I->seeElement('input[name=payment][value=paypal_express]');

$I->expect('success with payment method selected and order confirmed');
$I->selectOption('#payment input[name=payment]', 'cod');
$I->click('Confirm', '.buttons');

$I->expectTo('see order confirmation page');
$I->see('Thanks for shopping with us online!');
$I->see('This is a delivery order.');
$I->see('Your Delivery Address:');

//--------------------------------------------------------------------
//
// Submit Collection Order as Registered Customer
//
//--------------------------------------------------------------------
$I->amGoingTo('submit collection order as registered customer using checkout form');

testAddMenuToOrder($I);

$I->amOnPage('/checkout');
$I->seeInTitle('Checkout');
$I->see('Checkout', '.breadcrumb');

$I->expect('customer is logged in and form fields are populated with customer information');
$I->see('Welcome Back', '#checkout .text-info');

$I->seeElement('#checkout-form');
$I->click('#checkout .btn-group .btn:not(.active)');
$I->click('Payment', '.buttons');

$I->expect('success with form submitted and checkout progress to payment');
$I->see('Payment Method', '#payment');
$I->seeElement('input[name=payment][value=cod]');
$I->seeElement('input[name=payment][value=paypal_express]');

$I->expect('success with payment method selected and order confirmed');
$I->selectOption('#payment input[name=payment]', 'cod');
$I->click('Confirm', '.buttons');

$I->expectTo('see order confirmation page');
$I->see('Thanks for shopping with us online!');
$I->see('This is a collection order.');
$I->dontSee('Your Delivery Address:');

$I->comment('All Done!');