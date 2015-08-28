<?php
// @group main

$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('reset customer account password');

$I->expect('customer record in database');
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

//--------------------------------------------------------------------
// Ensure customer can login before reset
//--------------------------------------------------------------------
$I->amGoingTo('login successfully then logout before resetting password (for reference)');
$I->amOnPage('/login');
$I->seeElement('#login-form button');
$I->submitForm('#login-form form', ['email' => 'tester@example.com', 'password' => 'monday'], '#login-form button');
$I->see('My Account', 'h2');
$I->see('tester@example.com', '#details');
$I->see('Change Password', '#details');
$I->amOnPage('/logout');
$I->expect('successful login and logout');

//--------------------------------------------------------------------
// Go to Account Password Reset page
//--------------------------------------------------------------------
$I->amGoingTo('navigate to \'account password reset\' page, check page title and header');
$I->amOnPage('/forgot-password');
$I->seeInTitle('Account Password Reset');
$I->see('Account Password Reset', 'h3');

//--------------------------------------------------------------------
// Expect Error in form with unregistered email and blank security answer
//--------------------------------------------------------------------
$I->amGoingTo('submit form with an unregistered email address only');
$I->seeElement('button[type=submit]');
$I->submitForm('form', ['email' => 'test@fake.com'], 'form button[type=submit]');
$I->expect('error due to empty required security answer field and unregistered email address');
$I->see('The Security Answer: field is required.', '.text-danger');
$I->see('No matching email address', '.text-danger');

//--------------------------------------------------------------------
// Error with invalid details
//--------------------------------------------------------------------
$I->amGoingTo('submit form with an invalid answer');
$fields = [
    // I suppose email is not registered
    'email'             => 'tester@example.com',
    // I suppose security question is correct
    'security_question' => '11',
    // I suppose answer is incorrect
    'security_answer'   => 'Spikey',
];

$I->seeElement('form button[type=submit]');
$I->submitForm('form', $fields, 'form button[type=submit]');
$I->expect('error returned due to invalid answer');
$I->see('Security answer does not match', '.text-danger');

//--------------------------------------------------------------------
// Successfully reset customer account password
//--------------------------------------------------------------------
$I->amGoingTo('submit form with registered email and valid answer');
$fields = [
    'email'             => 'tester@example.com',
    'security_question' => '11',
    'security_answer'   => 'Spike',
];

$I->submitForm('form', $fields, 'form button[type=submit]');
$I->expect('the form is submitted and a new password is created');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Password reset successfully, please check your email for your new password.', '.alert-success');

//--------------------------------------------------------------------
// Ensure customer can not login with old password
//--------------------------------------------------------------------
$I->amGoingTo('try logging in with the old password');
$I->amOnPage('/login');
$I->seeElement('#login-form button');
$I->submitForm('#login-form form', ['email' => 'tester@example.com', 'password' => 'monday'], '#login-form button');
$I->expect('login failure due successful password reset, old password no longer recognised');
$I->see('Username and password not found!', '.alert-danger');
$I->dontSee('My Account', 'h2');
$I->dontSee('tester@example.com', '#details');

$I->comment('Can not test with new password since its randomly generated and sent to customer email');
$I->comment('All Done!');