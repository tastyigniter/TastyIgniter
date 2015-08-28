<?php
// @group main

$I = new AcceptanceTester($scenario);
$I->am('Customer');
$I->wantTo('search restaurant location');

$I->amGoingTo('navigate to \'home\' page, check page title, header and breadcrumb');
$I->amOnPage('/');
$I->seeInTitle('Welcome To TastyIgniter!');
$I->see('Order delicious food online', 'h2');

//--------------------------------------------------------------------
// Expect Error with empty search query
//--------------------------------------------------------------------
$I->amGoingTo('submit search location form with no postcode/address');
$I->seeElement('input[name=search_query]');
$I->click('#search');
$I->wait('1');
$I->expect('error due to blank postcode/address');
$I->see('Please type in a postcode/address to check if we can deliver to you.', '.alert-danger');

//--------------------------------------------------------------------
// Expect Error with non matching search query
//--------------------------------------------------------------------
$I->amGoingTo('submit search location form with valid postcode/address');
$I->fillField('search_query', 'SE10 9HF');
$I->click('#search');
$I->wait('2');
$I->expect('error due to no local restaurant found nearby the postcode/address');
$I->see('We do not have any local restaurant near you.', '.alert-danger');

//--------------------------------------------------------------------
// Expect Error with invalid search query
//--------------------------------------------------------------------
$I->amGoingTo('submit search location form with invalid postcode/address');
$I->fillField('search_query', '832829203938');
$I->click('#search');
$I->wait('2');
$I->expect('error due to invalid postcode/address');
$I->see('We couldn\'t locate the entered address/postcode, please enter a valid address/postcode.', '.alert-danger');

//--------------------------------------------------------------------
// Successfully find a local restaurant
//--------------------------------------------------------------------
$I->amGoingTo('submit search location form with valid postcode/address');
$I->fillField('search_query', 'E9 6QH');
$I->click('#search');
$I->wait('2');
$I->expect('success with local restuarant found nearby postcode/address, page redirected to local page');
$I->see('Lewisham can deliver to you at E9 6QH');
$I->see('Lewisham', 'h4');

$I->comment('All Done!');