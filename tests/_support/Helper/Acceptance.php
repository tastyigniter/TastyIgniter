<?php
namespace Helper;
// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function doRegistration($I, $email = 'john.doe@example.com', $pass = 'pass123456') {
        $I->amOnPage('/register');

        $I->amGoingTo('register a customer');

        $fields = [
            'first_name'        => 'John',
            'last_name'         => 'Doe',
            'email'             => $email,
            'password'          => $pass,
            'password_confirm'  => $pass,
            'telephone'         => '0123456789',
            'security_question' => '11',
            'security_answer'   => 'Spike',
            'captcha'           => $I->grabValueFrom('input[name="captcha_word"]'),
        ];

        $I->click('#newsletter'); // Click subscribe to newsletter button
        $I->click('#terms-condition');  // Click agree terms button

        $I->submitForm('#register-form form', $fields, '#register-form button[type=submit]');

        $I->dontSeeElement('.text-danger');
        $I->dontSeeElement('.alert-danger');
        $I->see('Account created successfully, login below!');
    }

    public function doFindTable(\AcceptanceTester $I) {
        $I->amGoingTo('find a table in the selected restaurant');
        $I->lookForwardTo('reserve a reservation time slot');

        $I->amOnPage('/reservation');

        $I->seeElement('.panel-find-table');
        $I->selectOption('location', 'Lewisham');
        $I->selectOption('guest_num', '4');
        $I->fillField('reserve_date', date('d-m-Y', strtotime('+ 1 month', time())));
        $I->fillField('reserve_time', '2:45 PM');
        $I->click('Find Table', '#find-table-form');

        $I->expect('success with available reservation times slot displayed');
        $I->seeElement('.panel-time-slots');
        $I->seeNumberOfElements('#time-slots .btn-group > .btn', 5); // 5 elements
        $I->click('#time-slots .btn-group > .btn:nth-child(4)');
        $I->click('Select Time', '#find-table-form');

        $I->expectTo('see the reservation summary');
        $I->seeElement('.panel-summary');
    }

    public function doRestaurantSearch($I) {
        $I->amOnPage('/');

        $I->amGoingTo('search a nearby restaurant location');

        $I->fillField('search_query', 'E9 6QH');
        $I->click('#search');
        $I->wait('2');
        $I->see('Lewisham can deliver to you at E9 6QH', '.panel-local');
    }

    public function doAddMenuToOrder($I) {
        $this->doRestaurantSearch($I);

        $I->amOnPage('/local/lewisham');

        $I->amGoingTo('add a menu to order from the menus list');
        $I->see('african salad', '.menu-items > #menu82.menu-item');
        $I->click('#menu82 .btn-cart');
        $I->wait('2');

        $I->see('Menu has been added to your order.', '#cart-alert .alert-success');
        $I->see('1 × african salad', '.cart-items');
    }

    public function doAddMenuWithOptionToOrder(\AcceptanceTester $I) {
        $this->doRestaurantSearch($I);

        $I->amGoingTo('add a menu to order from the menus list');
        $I->click('#menu81 .btn-cart');
        $I->wait('2');
        $I->fillField('#menu-options81 input[name=quantity]', 30);
        $I->click('#menu-options81 .option-radio .radio:last-child label');
        $I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(4) input[type="checkbox"]');
        $I->fillField('comment', 'I want it extra hot');
        $I->click('UPDATE', '#menu-options81');
        $I->wait('2');

        $I->see('Menu has been added to your order.', '#cart-alert .alert-success');
    }

    public function doAddMenuOptionValue(\AcceptanceTester $I, $num, $name, $price, $quantity) {
        $I->click('#tfoot .action .btn-primary');
        $I->selectOption("#option-value{$num} select", $name);
        $I->fillField("menu_options[1][option_values][{$num}][price]", $price);
        $I->fillField("menu_options[1][option_values][{$num}][quantity]", $quantity);
        $I->click("#option-value{$num} label.btn:not(.active)");
    }

    public function doCreateCustomerOrder(\AcceptanceTester $I) {
        $I->amGoingTo('submit an order for delivery');

        $this->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $this->doAddMenuWithOptionToOrder($I);

        $I->amOnPage('/checkout');

        $I->click('#checkout .btn-group .btn:not(.active)');
        $I->click('Payment');
        $I->selectOption('#payment input[name=payment]', 'cod');
        $I->click('Confirm', '.buttons');

        $I->expectTo('see the order confirmation page');
        $I->see('Thanks for shopping with us online!', 'div');
        $I->see('This is a collection order.');
    }
}
