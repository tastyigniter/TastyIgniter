<?php
$I = new AcceptanceTester($scenario);
$I->am('Guest Customer');
$I->wantTo('register a new customer account');

$I->amGoingTo('navigate to \'register\' page, check page title and header');
$I->amOnPage('/register');
$I->seeInTitle('Register');
$I->see('Please Register It\'s easy and always will be.', 'h3');

//--------------------------------------------------------------------
// Error with blank required form field
//--------------------------------------------------------------------
$I->amGoingTo('submit register form with empty fields');
$I->seeElement('#register-form button[type=submit]');
$I->submitForm('#register-form form', [], '#register-form button[type=submit]');

$I->expect('form errors due to empty required form field');
$I->see('The First Name field is required.', '.text-danger');
$I->see('The Last Name field is required.', '.text-danger');
$I->see('The Email Address field is required.', '.text-danger');
$I->see('The Password field is required.', '.text-danger');
$I->see('The Password Confirm field is required.', '.text-danger');
$I->see('The Telephone field is required.', '.text-danger');
$I->dontSee('The Security Question field is required.', '.text-danger');
$I->see('The Security Answer field is required.', '.text-danger');
$I->see('The Type the code shown field is required.', '.text-danger');
$I->dontSee('The Subscribe field is required.', '.text-danger');
$I->see('The I Agree field is required.', '.text-danger');

//--------------------------------------------------------------------
// Error with non permitted characters and incorrect criteria
//--------------------------------------------------------------------
$I->amGoingTo('submit register form with incorrect criteria or unacceptable characters');
$bad_fields = [
    // I suppose value is longer than maximum length of 32
    'first_name'        => 'Test TestTest Test TestTest Test TestTest Test TestTest ',
    // I suppose value is longer than maximum length of 32
    'last_name'         => 'User User User User User User User User ',
    // I suppose email is already registered
    'email'             => 'demo@demo.com',
    // I suppose password is shorter than minimum length of 6
    'password'          => '12345',
    'password_confirm'  => '12345',
    // I suppose telephone field only permits numbers
    'telephone'         => '4a4a44a5a5a634',
    // I suppose security answer is shorter than minimum length of 2
    'security_answer'   => 'S',
    // I suppose captcha does not match
    'captcha'           => '7382s',
];

$I->click('#newsletter'); // Click subscribe to newsletter button
$I->submitForm('#register-form form', $bad_fields, '#register-form button[type=submit]');

$I->expect('form errors due to incorrect criteria and unacceptable characters');
$I->see('The First Name field cannot exceed 32 characters in length.', '.text-danger');
$I->see('The Last Name field cannot exceed 32 characters in length.', '.text-danger');
$I->see('The Email Address field value already exists.', '.text-danger');
$I->see('The Password field must be at least 6 characters in length.', '.text-danger');
$I->dontSee('The Password Confirm field is required.', '.text-danger');
$I->see('The Telephone field must contain an integer.', '.text-danger');
$I->dontSee('The Security Question field is required.', '.text-danger');
$I->see('The Security Answer field must be at least 2 characters in length.', '.text-danger');
$I->see('The letters you entered does not match the image.', '.text-danger');
$I->see('The I Agree field is required.', '.text-danger');


//--------------------------------------------------------------------
// Successfully register customer account
//--------------------------------------------------------------------
$I->amGoingTo('submit register form with the correct criteria and permitted characters');
$fields = [
    'first_name'        => 'Test',
    'last_name'         => 'User',
    'email'             => 'tester@example.com',
    'password'          => '123456',
    'password_confirm'  => '123456',
    'telephone'         => '444455634',
    'security_question' => '11',
    'security_answer'   => 'Spike',
    'captcha'           => $I->grabValueFrom('input[name="captcha_word"]'),
];

$I->click('#newsletter'); // Click subscribe to newsletter button
$I->click('#terms-condition');  // Click agree terms button
$I->submitForm('#register-form form', $fields, '#register-form button[type=submit]');

$I->expect('the form is submitted without errors and a new customer account is created');
$I->dontSeeElement('.text-danger');
$I->dontSeeElement('.alert-danger');
$I->see('Account created successfully, login below!');

$I->comment('All Done!');