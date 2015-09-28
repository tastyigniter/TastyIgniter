<?php
namespace Main\Acceptance;

use \AcceptanceTester;

/**
 * @group main
 */
class MenuCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Customer');
    }

    public function testAddMenu(AcceptanceTester $I) {
        $I->wantTo('add menu to order');

        $I->doRestaurantSearch($I);

        $I->amOnPage('/local/lewisham');

        $I->expectTo('see list of menu items');
        $I->seeElement('.menu-items');
        $I->seeElement('.menu-items > .menu-category');
        $I->seeElement('.menu-items > #menu82.menu-item');

        $I->doAddMenuToOrder($I);

        $I->expectTo('menu added to order successfully');
        $I->seeElement('#menu82 .btn-cart.added');
        $I->see('Menu has been added to your order.', '#cart-alert .alert-success');
        $I->see('1 × african salad', '.cart-items');
        $I->see('£8.99', '.cart-items');
    }

    public function testAddMenuWithOptions(AcceptanceTester $I) {
        $I->wantTo('add menu with options to order');

        $I->doRestaurantSearch($I);

        $I->amOnPage('/local/lewisham');

        $I->click('#menu81 .btn-cart');
        $I->wait('2');

        $I->expectTo('see the menu option modal dialog box');
        $I->seeElement('#optionsModal #menu-options81');
        $I->see('Whole catfish with rice and vegetables', '#menu-options81');

        $I->amGoingTo('select menu options in modal and add to order');
        $I->click('#menu-options81 .option-radio .radio:last-child label');
        $I->checkOption('#menu-options81 .option-checkbox .checkbox:nth-child(4) input[type="checkbox"]');
        $I->fillField('comment', 'I want it extra hot');
        $I->click('UPDATE', '#menu-options81');
        $I->wait('2');

        $I->expect('success with menu and menu options added to order');
        $I->see('Menu has been added to your order.', '#cart-alert .alert-success');
        $I->see('1 × whole catfish with rice a...', '.cart-items');
        $I->see('+ Fish = 4.00', '.cart-items');
        $I->see('+ Jalapenos = 3.99', '.cart-items');
        $I->see('[I want it extra hot]', '.cart-items');
        $I->see('£21.98', '.cart-items');
    }

    public function testRemoveMenu(AcceptanceTester $I) {
        $I->wantTo('add menu to order');
        $I->lookForwardTo('remove the menu from order');

        $I->doAddMenuToOrder($I);

        $I->amGoingTo('remove menu from order');
        $I->click('#cart-box .cart-items li:first-child .remove');
        $I->wait('2');

        $I->expect('success with menu removed from order');
        $I->see('Menu has been updated successfully', '#cart-alert .alert-success');
        $I->dontSee('1 × african salad', '.cart-items');
        $I->see('There are no menus added in your cart.', '#cart-info');
    }

    public function testQuantityField(AcceptanceTester $I) {
        $I->wantTo('add menu to order');

        $I->doRestaurantSearch($I);

        $I->amOnPage('/local/lewisham');

        $I->click('#menu81 .btn-cart');
        $I->wait('1');

        $I->amGoingTo('check that the quantity plus and minus controls does not reach a negative number');
        $I->see('Menu Quantity', '#menu-options81');
        $I->seeInField('#menu-options81 input[name=quantity]','1');
        $I->click('#menu-options81 button[data-dir=dwn]');
        $I->click('#menu-options81 button[data-dir=dwn]');
        $I->seeInField('#menu-options81 input[name=quantity]','0');
        $I->dontSeeInField('#menu-options81 input[name=quantity]','-1');
    }

    public function testUpdateQuantity(AcceptanceTester $I) {
        $I->wantTo('add menu to order');
        $I->lookForwardTo('update the menu quantity in order');

        $I->doAddMenuToOrder($I);

        $I->amGoingTo('update menu quantity in cart');
        $I->click('#cart-box .cart-items .name-image');
        $I->wait('2');

        $I->expectTo('see the menu option modal to update menu quantity');
        $I->fillField('#menu-options82 input[name=quantity]', 100);
        $I->click('UPDATE', '#menu-options82');
        $I->wait('2');

        $I->expect('success with menu quantity updated to 100');
        $I->see('Menu has been updated successfully', '#cart-alert .alert-success');
        $I->see('100 × african salad', '.cart-items');
        $I->dontSee('1 × african salad', '.cart-items');
    }

    public function checkOrderTotal(AcceptanceTester $I) {
        $I->wantTo('add menu to order');
        $I->lookForwardTo('remove the menu from order');

        $I->doAddMenuToOrder($I);

        $I->amGoingTo('check the restaurant delivery charge');
        $I->see('Delivery Cost: £10.00', '.panel-local');

        $I->amGoingTo('switch to collection order type');
        $I->lookForwardTo('remove delivery charge from order total');
        $I->click('.location-control .order-type label:not(.active)');
        $I->wait('2');

        $I->dontSee('Delivery: £10.00', '.cart-total');
        $I->see('Sub Total: £8.99', '.cart-total');
        $I->see('Order Total: £8.99', '.cart-total');

        $I->amGoingTo('switch to delivery order type');
        $I->lookForwardTo('add delivery charge to order total');
        $I->click('.location-control .order-type label:not(.active)');
        $I->wait('2');

        $I->see('Sub Total: £8.99', '.cart-total');
        $I->see('Delivery: £10.00', '.cart-total');
        $I->see('Order Total: £18.99', '.cart-total');
        $I->see('Order total is below the minimum delivery order total.', '#local-alert .alert-danger');
    }
}