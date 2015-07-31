<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure relevant info is visible on the homepage');

$I->amOnPage('/');
$I->see('Search');
$I->see('Choose');
$I->see('Pay by cash or card');
$I->see('Enjoy');

//--------------------------------------------------------------------
// Expect Error without info
//--------------------------------------------------------------------
$I->expect('the search form is submitted with no data');
$I->see('Order delicious food online');
$I->seeElement('input[name=search_query]');
$I->click('#search');
$I->wait('1');
$I->see('Please type in a postcode/address to check if we can deliver to you.', '.alert-danger');

//--------------------------------------------------------------------
// Expect Error with non matching search query
//--------------------------------------------------------------------
$I->expect('the search form is submitted but no local restautant found');
$I->fillField('search_query', 'SE10 9HF');
$I->click('#search');
$I->wait('2');
$I->see('We do not have any local restaurant near you.', '.alert-danger');

//--------------------------------------------------------------------
// Expect Error with invalid search query
//--------------------------------------------------------------------
$I->expect('the search form is submitted with invalid search query');
$I->fillField('search_query', '832829203938');
$I->click('#search');
$I->wait('2');
$I->see('We couldn\'t locate the entered address/postcode, please enter a valid address/postcode.', '.alert-danger');

//--------------------------------------------------------------------
// Successfully find a local restaurant
//--------------------------------------------------------------------
$I->expect('the search form is submitted with local restuarant found');
$I->fillField('search_query', 'E9 6QH');
$I->click('#search');
$I->wait('2');
$I->see('E9 6QH');
$I->see('Lewisham');

//--------------------------------------------------------------------
// Expect user is redirected to local restaurant menu page
//--------------------------------------------------------------------
$I->expect('the categories sidebar links to be clickable on local menu page');

// Ensure page partials are present
$I->seeElement('#category-box');
$I->seeElement('#cart-box');
$I->seeElement('#local-box');
$I->seeElement('.menu-items');

$I->click('a[data-filter=".appetizer"]');
$I->wait('2');
$I->see('Appetizer', 'h3');

$I->click('a[data-filter=".salads"]');
$I->wait('2');
$I->see('Salads', 'h3');

$I->click('a[data-filter=".seafoods"]');
$I->wait('2');
$I->see('Seafoods', 'h3');

$I->click('a[data-filter=".traditional"]');
$I->wait('2');
$I->see('Traditional', 'h3');

$I->click('a[data-filter=".vegetarian"]');
$I->wait('2');
$I->see('Vegetarian', 'h3');

$I->click('a[data-filter=".soups"]');
$I->wait('2');
$I->see('Soups', 'h3');

$I->click('a[data-filter=".rice-dishes"]');
$I->wait('2');
$I->see('Rice Dishes', 'h3');

$I->click('a[data-filter=".main-course"]');
$I->wait('2');
$I->see('Main Course', 'h3');