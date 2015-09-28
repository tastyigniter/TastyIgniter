<?php
namespace Main\Acceptance;

use \AcceptanceTester;

/**
 * @group main
 */
class LocationCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Customer');
    }

    public function testFailedSearchRestaurant(AcceptanceTester $I) {
        $I->wantTo('search a nearby restaurant location');

        $I->amOnPage('/');

        $I->amGoingTo('enter a valid postcode or address');
        $I->fillField('search_query', 'SE10 9HF');
        $I->click('#search');
        $I->wait('2');

        $I->expect('failure due to no restaurant found near the postcode or address');
        $I->see('We do not have any local restaurant near you.', '.alert-danger');

        $I->amGoingTo('enter an invalid postcode or address');
        $I->fillField('search_query', '832829203938');
        $I->click('#search');
        $I->wait('2');

        $I->expect('failure due to the invalid postcode or address entered');
        $I->see('We couldn\'t locate the entered address/postcode, please enter a valid address/postcode.', '.alert-danger');
    }

    public function testSearchRestaurant(AcceptanceTester $I) {
        $I->wantTo('search a nearby restaurant location');

        $I->amOnPage('/');

        $I->amGoingTo('enter a valid postcode or address');
        $I->fillField('search_query', 'E9 6QH');
        $I->click('#search');
        $I->wait('2');

        $I->expectTo('be redirected to the nearby restaurant page');
        $I->seeCurrentUrlEquals('/local/lewisham');
        $I->see('Lewisham can deliver to you at E9 6QH', '.panel-local');
        $I->see('Delivery Cost: £10.00', '.panel-local');
        $I->see('Min. Order Amount: £100.00', '.panel-local');

        $I->amGoingTo('enter a different postcode or address');
        $I->lookForwardTo('compare the delivery charge and order minimum total');
        $I->click('Change Location', '.panel-local');
        $I->seeElement('.panel-local input[name=search_query]');
        $I->fillField('search_query', 'Dalston Lane');
        $I->click('#search');
        $I->wait('2');

        $I->expect('success with the restaurant delivery area option updated');
        $I->see('Lewisham can deliver to you at Dalston Lane', '.panel-local');
        $I->see('Delivery Cost: £4.00', '.panel-local');
        $I->see('Min. Order Amount: £10.00', '.panel-local');
    }

    public function testChooseRestaurant(AcceptanceTester $I) {
        $I->wantTo('choose a restaurant');

        $I->amOnPage('/locations');
        $I->click('Go To Menus', '.panel-local:first-child');

        $I->expectTo('be redirected to the chosen restaurant page');
        $I->seeCurrentUrlEquals('/local/lewisham');
        $I->see('Please type in a postcode/address to check if we can deliver to you.', '.text-danger');

        $I->expectTo('see restaurant opening, delivery and collection times, e.t.c');
        $I->see('24 hours, 7 days.', '.panel-local');
        $I->see('We will deliver your order in 20 min.', '.panel-local');
        $I->see('Collect your order in 10 min.', '.panel-local');
        $I->see('Service Offered: Delivery and collection', '.panel-local');
        $I->see('Free Delivery', '.panel-local');
    }

    public function testClosedRestaurant(AcceptanceTester $I) {
        $I->wantTo('search a nearby restaurant');
        $I->lookForwardTo('place an order when the restaurant is closed');

        $I->amOnPage('/');

        $I->fillField('search_query', 'HA3 7JG');
        $I->click('#search');
        $I->wait('2');

        $I->expectTo('see restaurant closed alert message');
        $I->seeCurrentUrlEquals('/local/earling');
        $I->dontSee('We are open', '.panel-local');
        $I->see('Earling Closed', '.panel-local');
        $I->see('We are temporarily closed, check later.', '.panel-local');
        $I->see('Restaurant is currently closed.', '#local-alert .alert-danger');
        $I->dontSee('Pre-ordering is available for later delivery.', '#local-alert .alert-danger');

        $I->amGoingTo('add menu to cart when restaurant is closed');
        $I->click('#menu76 .btn-cart');
        $I->wait('2');

        $I->expectTo('see restaurant closed alert message');
        $I->seeElement('#menu76 .btn-cart.failed');
        $I->see('Sorry, you can\'t place an order now, we are currently closed', '#cart-alert .alert-danger');
        $I->see('There are no menus added in your cart.', '#cart-info');
    }

    public function testMinimumOrderTotal(AcceptanceTester $I) {
        $I->wantTo('place an order');

        $I->amOnPage('/');

        $I->amGoingTo('enter a valid postcode or address');
        $I->fillField('search_query', 'E9 6QH');
        $I->click('#search');
        $I->wait('2');

        $I->expectTo('be redirected to the nearby restaurant page');
        $I->seeCurrentUrlEquals('/local/lewisham');
        $I->see('Lewisham can deliver to you at E9 6QH', '.panel-local');
        $I->see('Delivery Cost: £10.00', '.panel-local');
        $I->see('Min. Order Amount: £100.00', '.panel-local');

        $I->amGoingTo('add menu to order then checkout');
        $I->click('#menu76 .btn-cart');
        $I->see('Min. Order Amount: £100.00', '.panel-local');
        $I->click('Checkout', '.side-bar .buttons');

        $I->expectTo('see minimum delivery order total alert message');
        $I->wait('2');
        $I->see('Order total is below the minimum delivery order total.', '#local-alert .alert-danger');
        $I->see('Order Total: £24.97', '.cart-total');
    }

    public function checkRestaurantReviews(AcceptanceTester $I) {
        $I->wantTo('check restaurant customers review');

        $I->amOnPage('/local/lewisham');

        $I->click('Reviews', '#page-content #nav-tabs');
        $I->wait('1');

        $I->see('Customer Reviews of Lewisham', 'h4');
        $I->seeElement('.pagination-bar .info > span');
        $I->seeElement('.reviews-list .review-item');
        $I->seeElement('.review-item .review-text');
        $I->seeElement('.rating-star .fa-star');
    }

    public function checkRestaurantInformation(AcceptanceTester $I) {
        $I->wantTo('check restaurant information');

        $I->amOnPage('/local/lewisham');

        $I->click('Info', '#page-content #nav-tabs');
        $I->wait('1');

        $I->see('More info about Lewisham local restaurant', 'h4');
        $I->seeElement('#map-holder .gm-style'); // see google map
        $I->seeElement('dl.opening-hour dd'); // see opening hour list
        $I->seeElement('dl.dl-group dd'); // see delivery options
        $I->see('Last Order Time', 'dl.dl-group dd');
        $I->see('23:59', 'dl.dl-group dd');
        $I->see('24 hours a day & 7 days a week', 'dl.dl-group dd');

        $I->expectTo('see the restaurant accepted payments and delivery areas');
        $I->see('Cash On Delivery, PayPal Express.', 'dl.dl-group dd');
        $I->see('Delivery Areas', 'h4');
        $I->see('Area 1', '#local-information .row');
        $I->see('Area 2', '#local-information .row');
        $I->see('Area 3', '#local-information .row');
        $I->see('Area 4', '#local-information .row');
    }
}
