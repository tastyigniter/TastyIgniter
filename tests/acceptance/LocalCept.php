<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('view all available restaurants');

$I->amOnPage('/locations');
$I->see('Restaurants', 'h2');
$I->seeElement('.breadcrumb');

//--------------------------------------------------------------------
// Expect Success with all element and content present
//--------------------------------------------------------------------
$I->expect('a list of the three available restaurants');
$I->seeElement('.location-list > .panel-local');
$I->seeNumberOfElements('.panel-local', 3);
$I->see('45 minutes');
$I->see('20 minutes');
$I->see('15 minutes');
$I->see('10 minutes');
$I->see('Lewisham', '.panel-local:first-child');
$I->see('(2)', '.panel-local:first-child');
$I->see('We are OPEN', '.panel-local:first-child');
$I->see('Offers both delivery and collection.', '.panel-local:first-child');
$I->see('Delivery Time:', '.panel-local:first-child');
$I->see('Collection Time:', '.panel-local:first-child');
$I->see('Offers collection only, delivery is not available.', '.panel-local:last-child');
$I->seeInPageSource('<div class="rating rating-sm');

// Go to Local Menus page
$I->click('Go To Menus', '.panel-local:first-child');
$I->see('Lewisham', '.breadcrumb');
$I->seeElement('.menu-items');
$I->seeElement('.menu-items > .menu-category');
$I->seeElement('.menu-items > .menu-item');

//--------------------------------------------------------------------
// Expect success with search query entered
//--------------------------------------------------------------------
$I->expect('success after valid search query is entered');
$I->see('Please type in a postcode/address to check if we can deliver to you.', '.text-danger');
$I->seeElement('.panel-local input[name=search_query]');
$I->fillField('search_query', 'E9 6QH');
$I->click('#search');
$I->wait('2');

$I->expect('the found local restaurant information updated');
$I->see('Lewisham can deliver to you at E9 6QH');
$I->see('24 hours, 7 days.', '.panel-local');
$I->see('Service Offered: Delivery and collection', '.panel-local');
$I->see('Delivery Cost: £10.00', '.panel-local');
$I->see('Min. Order Amount: £100.00', '.panel-local');

//--------------------------------------------------------------------
// Expect error when out of delivery area local restaurant is selected
//--------------------------------------------------------------------
$I->expect('error due to search query not covered by local');
$I->amOnPage('local/hackney');
$I->see('Hackney\'s Branch', '.breadcrumb');
$I->waitForElement('.alert-danger');
$I->see('Sorry, this restaurant does not deliver to your address', '.alert-danger');

//--------------------------------------------------------------------
// Expect error with closed restaurant selected
//--------------------------------------------------------------------
$I->expect('error due to local restaurant closed');
$I->amOnPage('local/earling');
$I->see('Earling Closed', '.breadcrumb');
$I->waitForElement('.alert-danger', 2);
$I->see('Restaurant is currently closed.', '.alert-danger');
$I->see('Pre-ordering is available for later delivery.', '.alert-danger');
$I->see('We are temporarily closed, check later.', '.text-danger');
$I->see('Service Offered: Collection only');

//--------------------------------------------------------------------
// Expect success with search query changed
//--------------------------------------------------------------------
$I->expect('customer to successfully change their search query');
$I->click('Change Location', '.panel-local');
$I->wait('1');
$I->seeElement('.panel-local input[name=search_query]');
$I->fillField('search_query', 'whitechapel road');
$I->click('#search');
$I->wait('2');

$I->expect('the found local restaurant information updated');
$I->see('Lewisham can deliver to you at whitechapel road');
// Ensure the delivery area changed
$I->see('Delivery Cost: £10.00', '.panel-local');
$I->see('Min. Order Amount: £200.00', '.panel-local');

$I->seeOptionIsSelected('#cart-box input[name=order_type]', '1');
$I->see('Delivery', '#cart-box .location-control label');
$I->see('20 min', '#cart-box .location-control label');
$I->see('Collection', '#cart-box .location-control label');
$I->see('10 min', '#cart-box .location-control label');

//--------------------------------------------------------------------
// Expect success with nav tabs, local reviews, local info and options displayed
//--------------------------------------------------------------------
$I->expect('customer to view local reviews');
$I->seeElement('#page-content #nav-tabs');
$I->click('Reviews', '#page-content #nav-tabs');
$I->wait('1');
$I->see('Customer Reviews of Lewisham', 'h4');
$I->see('Sam Poyigi from Greater London on 26 May 15 ');
$I->seeElement('.reviews-list .review-item');
$I->seeElement('.rating-star .fa-star');

$I->expect('customer to view local info, map, opening hours');
$I->click('Info', '#page-content #nav-tabs');
$I->wait('1');
$I->see('More info about Lewisham local restaurant', 'h4');
$I->see('Mauris maximus tempor ligula vitae placerat.', 'p'); // see local description
$I->seeElement('#map-holder .gm-style'); // see google map
$I->seeElement('dl.opening-hour dd'); // see opening hour list
$I->seeElement('dl.dl-group dd'); // see delivery options
$I->see('Last Order Time', 'dl.dl-group dd');
$I->see('23:59', 'dl.dl-group dd');
$I->see('24 hours a day & 7 days a week', 'dl.dl-group dd');

$I->expect('customer to see accepted payments and delivery areas');
$I->see('Cash On Delivery, PayPal Express.', 'dl.dl-group dd');
$I->see('Delivery Areas', 'h4');
$I->see('Name', '#local-information .row');
$I->see('Delivery Charge', '#local-information .row');
$I->see('Min Total', '#local-information .row');
$I->see('Area 1', '#local-information .row');
$I->see('Area 2', '#local-information .row');
$I->see('Area 3', '#local-information .row');
$I->see('Area 4', '#local-information .row');