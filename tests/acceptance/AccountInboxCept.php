<?php
$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('view customer inbox and messages');

// Log in Test User
$I->login('demo@demo.com', 'monday');

$I->amGoingTo('navigate to \'inbox\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/inbox');
$I->seeInTitle('My Inbox');
$I->see('My Inbox', 'h2');
$I->see('My Account My Inbox', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Expect inbox to contain one or more message
//--------------------------------------------------------------------
$I->expect('inbox to contain one or more messages');
$I->seeNumberOfElements('.list-group .list-group-item', [1,10]); //between 0 and 10 elements
$I->see('Displaying 1 to', '.pagination-bar');  // ensure pagination is present.

//--------------------------------------------------------------------
// Check back navigation link and place new order link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link and place new order link');
$I->seeLink('Back', '/account');

//--------------------------------------------------------------------
//
// I want to view an inbox message
//
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'view inbox message\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/inbox/view/62');
$I->seeInTitle('My Inbox Message');
$I->see('My Inbox Message', 'h2');
$I->see('My Account My Inbox My Inbox Message', '.breadcrumb');

$I->expectTo('see the inbox message, date, subject and message body');
$I->see('Date:', 'table td');
$I->see('06 Jun 15 - 01:26', 'table td');
$I->see('Subject: Aenean eget euismod massa', 'table');
$I->seeElement('.msg_body');
$I->see('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum volutpat enim in tellus tristique facilisis. Etiam vulputate et nisi tristique venenatis. Suspendisse hendrerit mi ac aliquam tincidunt. In maximus consequat lectus, vitae bibendum ipsum suscipit mattis. Donec mi magna, fringilla sed orci eget, scelerisque lobortis nunc. Donec commodo tristique commodo. Curabitur pellentesque dui libero. Suspendisse id nisl quis nulla pharetra malesuada. Integer eget nibh tristique, commodo arcu sed, sagittis tellus. Aliquam pharetra cursus nisi quis porta. Donec bibendum sem ipsum, quis eleifend est iaculis quis. Integer suscipit enim sit amet gravida lobortis. Sed fermentum lorem et mauris pharetra, nec dignissim felis finibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent ut mi tellus. Vestibulum varius, lectus ac scelerisque blandit, odio urna accumsan diam, in pulvinar est dolor non quam.', 'table');

//--------------------------------------------------------------------
// Check back navigation link and place new order link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link and place new order link');
$I->seeLink('Back', '/account/inbox');

$I->comment('All Done!');