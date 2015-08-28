<?php
// @group main

$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('login a valid customer');

$I->expect('a customer record in database');
$I->haveInDatabase('ti_customers', [
    'customer_id'    => 100,
    'first_name'    => 'Nulla',
    'last_name'    => 'Ipsum',
    'email' => 'tester@example.com',
    'password' => '553eed138976c9c3cc57f6d74edc976a6be1302b',  // 'monday'
    'salt' => 'ee9c4c289',
    'telephone' => '43434343',
    'address_id' => '1',
    'security_question_id' => '11',
    'security_answer' => 'Spike',
    'newsletter' => '1',
    'customer_group_id' => '11',
    'ip_address' => '::1',
    'date_added' => date('Y-m-d H:i:s', strtotime('-1 month')),
    'status' => 1,
]);

// First - ensure that we are logged out
$I->amOnPage('/logout');

// Then back on the login page
$I->amGoingTo('navigate to \'login\' page, check page title and header');
$I->amOnPage('/login');
$I->seeInTitle('Login');
$I->see('Log In', 'h3');

//--------------------------------------------------------------------
// Error with blank fields
//--------------------------------------------------------------------
$I->amGoingTo('submit login form with blank email and password');
$I->seeElement('#login-form button[type=submit]');
$I->submitForm('#login-form form', [], '#login-form button[type=submit]');

$I->expect('the form is not submitted due to form errors');
$I->see('The Email Address field is required.', '.text-danger');
$I->see('The Password field is required.', '.text-danger');


//--------------------------------------------------------------------
// Error with invalid password
//--------------------------------------------------------------------
$I->amGoingTo('submit login form with an invalid password');
$I->seeElement('#login-form button');
$I->submitForm('#login-form form', ['email' => 'tester@example.com', 'password' => 'badstuff'], '#login-form button');

$I->expect('error returned due to invalid password');
$I->see('Username and password not found!', '.alert-danger');

//--------------------------------------------------------------------
// Error with invalid email
//--------------------------------------------------------------------
$I->amGoingTo('submit login form with an invalid email');
$I->seeElement('#login-form button');
$I->submitForm('#login-form form', ['email' => 'testerexammplecom', 'password' => ''], '#login-form button');

$I->expect('error returned due to bad email');
$I->see('The Email Address field must contain a valid email address.', '.text-danger');

//--------------------------------------------------------------------
// Successfully login
//--------------------------------------------------------------------
$I->amGoingTo('submit login form with valid email and password');
$I->seeElement('#login-form button');
$I->submitForm('#login-form form', ['email' => 'tester@example.com', 'password' => 'monday'], '#login-form button');

$I->expect('customer logged in and landed on account dashboard page');
$I->dontSeeElement('.alert-danger');
$I->dontSeeElement('.text-danger');
$I->see('My Account', 'h2');
$I->see('tester@example.com', '#details');
$I->see('Change Password', '#details');

$I->comment('All Done!');