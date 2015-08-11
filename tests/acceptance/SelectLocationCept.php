<?php
$I = new AcceptanceTester($scenario);
$I->am('Customer');
$I->wantTo('select restaurant location');

$I->amGoingTo('navigate to \'locations\' page, check page title, header and breadcrumb');
$I->amOnPage('/locations');
$I->seeInTitle('Restaurants');
$I->see('Restaurants', 'h2');
$I->see('Restaurants', '.breadcrumb');

//--------------------------------------------------------------------
// Expect list of all available restaurant locations
//--------------------------------------------------------------------
$I->expect('a list of available restaurant locations');
$I->seeElement('.location-list > .panel-local');
$I->seeNumberOfElements('.location-list > .panel-local', [1,10]); //between 1 and 10 elements
$I->see('Lewisham', '.panel-local:first-child');
$I->see('44 Darnley Road', '.panel-local:first-child');
$I->see('Greater London E9 6QH', '.panel-local:first-child');
$I->see('12:00 am - 11:59 pm', '.panel-local:first-child');
$I->see('We are OPEN', '.panel-local:first-child');
$I->see('Offers both delivery and collection.', '.panel-local:first-child');
$I->see('Delivery Time: 20 minutes', '.panel-local:first-child');
$I->see('Collection Time: 10 minutes', '.panel-local:first-child');
$I->seeNumberOfElements('.panel-local:first-child .rating .fa', 5);
$I->see('(2)', '.panel-local:first-child .rating');
$I->see('Earling Closed', '.panel-local:last-child');
$I->see('We are temporarily closed, check later.', '.panel-local:last-child');
$I->see('Offers collection only, delivery is not available.', '.panel-local:last-child');
$I->seeLink('Go To Menus', '/local/lewisham');
$I->seeLink('Go To Menus', '/local/hackney');
$I->seeLink('Go To Menus', '/local/earling');

//--------------------------------------------------------------------
//
// I want to view location menu, info and reviews
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'Lewisham\' restaurant location page, check page title, header and breadcrumb');
$I->click('Go To Menus', '.panel-local:first-child');
$I->seeInTitle('Lewisham - Restaurant');
$I->see('Lewisham', 'h4');
$I->see('Restaurants Lewisham', '.breadcrumb');
$I->see('Please type in a postcode/address to check if we can deliver to you.', '.text-danger');

//--------------------------------------------------------------------
// Expect success with search query entered
//--------------------------------------------------------------------
$I->amGoingTo('enter postcode/address to check if restaurant location can deliver');
$I->seeElement('.panel-local input[name=search_query]');
$I->fillField('search_query', 'E9 6QH');
$I->click('#search');
$I->wait('2');

$I->expect('the local restaurant information updated');
$I->see('Lewisham can deliver to you at E9 6QH');
$I->see('24 hours, 7 days.', '.panel-local');
$I->see('Service Offered: Delivery and collection', '.panel-local');

$I->expect('the delivery area information updated');
$I->see('Delivery Cost: £10.00', '.panel-local');
$I->see('Min. Order Amount: £100.00', '.panel-local');

//--------------------------------------------------------------------
// Expect success with search query changed
//--------------------------------------------------------------------
$I->amGoingTo('change the postcode/address');
$I->lookForwardTo('can change delivery area cost and min total');
$I->click('Change Location', '.panel-local');
$I->wait('1');
$I->seeElement('.panel-local input[name=search_query]');
$I->fillField('search_query', 'whitechapel road');
$I->click('#search');
$I->wait('2');

$I->expect('the found local restaurant information updated');
$I->see('Lewisham can deliver to you at whitechapel road');

$I->expect('the delivery area information updated');
$I->see('Delivery Cost: £10.00', '.panel-local');
$I->see('Min. Order Amount: £200.00', '.panel-local');

//--------------------------------------------------------------------
// Expect success with nav tabs, local reviews, local info and options displayed
//--------------------------------------------------------------------
$I->expect('customer to view local reviews');
$I->seeElement('#page-content #nav-tabs');
$I->click('Reviews', '#page-content #nav-tabs');
$I->wait('1');
$I->see('Customer Reviews of Lewisham', 'h4');
$I->see('Displaying 1 to', '.pagination-bar');
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

//--------------------------------------------------------------------
// Expect error when local restaurant delivery does not cover postcode/address
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'Hackney\' restaurant location page and check if they can delivery');
$I->amOnPage('local/hackney');
$I->seeInTitle('Hackney\'s Branch - Restaurant');
$I->see('Hackney\'s Branch', 'h4');
$I->see('Restaurants Hackney\'s Branch', '.breadcrumb');

$I->expect('error due to restaurant does not deliver to postcode/address');
$I->waitForElement('.alert-danger', 2);
$I->see('Sorry, this restaurant does not deliver to your address', '.alert-danger');
$I->see('Hackney\'s Branch can deliver to you at');

//--------------------------------------------------------------------
// Expect error with closed restaurant selected
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'Earling\' restaurant location page and check location is closed');
$I->amOnPage('local/earling');
$I->seeInTitle('Earling Closed - Restaurant');
$I->see('Earling Closed', 'h4');
$I->see('Restaurants Earling Closed', '.breadcrumb');

$I->expect('error due to local restaurant closed');
$I->waitForElement('.alert-danger', 2);
$I->see('Restaurant is currently closed.', '.alert-danger');
$I->see('Pre-ordering is available for later delivery.', '.alert-danger');
$I->see('We are temporarily closed, check later.', '.text-danger');

$I->comment('All Done!');