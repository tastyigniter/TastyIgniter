<?php
namespace Main\Acceptance;

use \AcceptanceTester;

/**
 * @group main
 */
class OrderCest {

    private $fields = [
        'first_name'            => 'John',
        'last_name'             => 'Doe',
        'email'                 => 'john.doe@example.com',
        'telephone'             => '444455634',
        'order_time'            => 'ASAP',
        'order_type'            => '1', // I suppose delivery selected
        'address[0][address_1]' => '95 Wilton Way',
        'address[0][address_2]' => '',
        'address[0][city]'      => 'London',
        'address[0][state]'     => 'London',
        'address[0][postcode]'  => 'E8 1BN',
        'address[0][country_id]'=> '222',
        'comment'               => 'I do really want it extra extra hot',
    ];

    public function _before(AcceptanceTester $I) {
        $I->am('Customer');
    }

    public function testEmailAddressField(AcceptanceTester $I) {
        $I->wantTo('submit an order');

        $I->doRegistration($I);

        $I->doAddMenuWithOptionToOrder($I);

        $I->amGoingTo('logout from the registered account');
        $I->lookForwardTo('place the order as guest with the registered email');
        $I->amOnPage('/logout');
        $I->amOnPage('/checkout');

        $I->submitForm('#checkout-form', $this->fields, 'Payment');

        $I->expect('form errors due to email already registered to an account');
        $I->see('Warning: E-Mail Address is already registered!', '.text-danger');
    }

    public function testDeliveryArea(AcceptanceTester $I) {
        $I->wantTo('submit an order');

        $I->doAddMenuWithOptionToOrder($I);

        $I->amGoingTo('submit a delivery order');
        $I->lookForwardTo('check if the order can be delivered');
        $I->amOnPage('/logout');
        $I->amOnPage('/checkout');

        $fields = $this->fields;
        $fields['address[0][address_1]'] = '14 Lime Close';
        $fields['address[0][postcode]'] = 'HA3 7JG';
        $I->submitForm('#checkout-form', $fields, 'Payment');

        $I->expect('form errors due to address not within restaurant delivery area');
        $I->see('This restaurant currently does not deliver to your address', '.text-danger');
    }

    public function testApplyCoupon(AcceptanceTester $I) {
        $I->wantTo('apply coupon to an order');

        $I->doAddMenuWithOptionToOrder($I);

        $I->amGoingTo('enter an invalid/expired coupon');
        $I->fillField('coupon_code', '382903');
        $I->click('Apply Coupon', '.cart-coupon');

        $I->expect('error due to invalid or expired coupon');
        $I->waitForText('Your coupon is either invalid or expired.', 2, '#cart-alert .alert-danger');

        $I->amGoingTo('enter an valid coupon');
        $I->fillField('coupon_code', '5555');
        $I->click('Apply Coupon', '.cart-coupon');

        $I->expect('error can not be applied due to below minimum order total');
        $I->waitForText('Your coupon can not be applied to orders below £5,000.00.', 2, '#cart-alert .alert-danger');

        $I->amGoingTo('enter a different valid coupon');
        $I->fillField('coupon_code', '2222');
        $I->click('Apply Coupon', '.cart-coupon');

        $I->expect('success with coupon applied to order');
        $I->waitForText('Your coupon has been applied successfully.', 2, '#cart-alert .alert-success');
        $I->see('Coupon:   -£100.00', '.cart-total');
    }

    public function testDeliveryOrder(AcceptanceTester $I) {
        $I->wantTo('submit an order for delivery as guest');

        $I->doAddMenuWithOptionToOrder($I);

        $I->amOnPage('/checkout');

        $I->submitForm('#checkout-form', $this->fields, 'Payment');

        $I->expect('form success and checkout progressed to payment');
        $I->see('Payment Method', '#payment');
        $I->seeElement('input[name=payment][value=cod]');
        $I->seeElement('input[name=payment][value=paypal_express]');

        $I->amGoingTo('select cash on delivery payment method and confirm order');
        $I->selectOption('#payment input[name=payment]', 'cod');
        $I->click('Confirm', '.buttons');

        $I->expectTo('see the order confirmation page');
        $I->see('Thanks for shopping with us online!');
        $I->see('This is a delivery order.');
    }

    public function testCollectionOrder(AcceptanceTester $I) {
        $I->wantTo('submit an order for collection as guest');

        $I->doAddMenuWithOptionToOrder($I);

        $I->amOnPage('/checkout');

        $fields = $this->fields;
        unset($fields['address[0][address_1]'], $fields['address[0][address_2]'], $fields['address[0][city]'],
            $fields['address[0][state]'], $fields['address[0][postcode]'], $fields['address[0][country_id]']);
        $fields['order_type'] = '2';
        $I->click('#checkout .btn-group .btn:not(.active)');
        $I->submitForm('#checkout-form', $fields, 'Payment');

        $I->expect('form success and checkout progressed to payment');
        $I->see('Payment Method', '#payment');
        $I->seeElement('input[name=payment][value=cod]');
        $I->seeElement('input[name=payment][value=paypal_express]');

        $I->amGoingTo('select cash on delivery payment method and confirm order');
        $I->selectOption('#payment input[name=payment]', 'cod');
        $I->click('Confirm', '.buttons');

        $I->expectTo('see the order confirmation page');
        $I->see('Thanks for shopping with us online!', 'div');
        $I->see('This is a collection order.', 'p');
    }

    public function testPreviousOrder(AcceptanceTester $I) {
        $I->wantTo('submit an order for collection');
        $I->lookForwardTo('view and reorder the order under the account recent orders');

        $I->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $I->doAddMenuWithOptionToOrder($I);

        $I->amOnPage('/checkout');

        $I->click('#checkout .btn-group .btn:not(.active)');
        $I->click('Payment');
        $I->selectOption('#payment input[name=payment]', 'cod');
        $I->click('Confirm', '.buttons');

        $I->expectTo('see the order confirmation page');
        $I->see('Thanks for shopping with us online!', 'div');

        $I->amGoingTo('view the recent orders');
        $I->amOnPage('/account/orders');

        $I->dontSee('There are no order(s).', '.order-lists');
        $I->seeNumberOfElements('.order-lists tbody tr', [1,10]); //between 1 and 10 elements
        $I->seeElement('.order-lists tbody td');
        $I->seeElement('.pagination-bar  .info > span');
        $I->see('Collection 30 £659.40', '.order-lists tbody tr');

        $I->amGoingTo('re-order the recent order');
        $I->click('.order-lists tbody tr:first-child a.re-order');

        $I->expectTo('see the order menu and options added to cart successfully');
        $I->see('You have successfully added the menus from order ID ', '.alert-success');
        $I->seeInCurrentUrl('local/lewisham');
        $I->see('30 × whole catfish with rice a...', '#cart-info');
        $I->see('+ Fish = 4.00', '#cart-info');
        $I->see('+ Jalapenos = 3.99', '#cart-info');
        $I->see('[I want it extra hot]', '#cart-info');
        $I->see('Sub Total: £659.40', '#cart-info');
        $I->see('Order Total: £659.40', '#cart-info');
    }
}