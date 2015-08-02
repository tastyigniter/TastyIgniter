<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('view a customer inbox');

// Log in Test User
$I->login('demo@demo.com', 'monday');

$I->amOnPage('/account/inbox');
$I->see('My Inbox', 'h2');
$I->seeElement('.breadcrumb');

//--------------------------------------------------------------------
// Expect inbox to contain one or more message
//--------------------------------------------------------------------
$I->expect('inbox to contain one or more message');
$I->seeElement('.list-group .list-group-item');
$I->see('Displaying');  // ensure pagination is present.

//--------------------------------------------------------------------
// Expect back link work.
//--------------------------------------------------------------------
$I->expect('the back button to be linked');
$I->click('Back');
$I->see('My Account', 'h2');

$I->wantTo('view a customer inbox message');
$I->amOnPage('/account/inbox/view/62');
$I->see('My Inbox Message', 'h2');
$I->see('Date:', 'table td');
$I->see('Subject:', 'table td');

//--------------------------------------------------------------------
// Expect back link work.
//--------------------------------------------------------------------
$I->expect('the back button to be linked');
$I->click('Back');
$I->see('My Inbox', 'h2');