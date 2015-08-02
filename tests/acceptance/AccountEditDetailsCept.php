<?php
$I = new AcceptanceTester($scenario);
$I->am('Registered Customer');
$I->wantTo('edit customer account information');

// Login Test user
$I->login('demo@demo.com', 'monday');

$I->amGoingTo('navigate to \'account details\' page, check page title, header and breadcrumb');
$I->amOnPage('/account/details');
$I->seeInTitle('My Details');
$I->see('My Details', 'h2');
$I->see('My Account My Details', '.breadcrumb');
$I->seeAccountSidebarLinks();

//--------------------------------------------------------------------
// Expect Success without info changed
//--------------------------------------------------------------------
$I->amGoingTo('submit the form without making any changes');
$old_fields = [
    'first_name'            => 'Nulla',
    'last_name'             => 'Ipsum',
    'telephone'             => '43434343',
    'email'                 => 'demo@demo.com',
    'security_question_id'  => '11',
    'security_answer'       => 'Spike',
    'newsletter'            => true,
    'old_password'          => '',
    'new_password'          => '',
    'confirm_new_password'  => '',
];
$I->see('Whats your pets name?', '.form-group');
$I->seeInFormFields('form', $old_fields);
$I->submitForm('form', [], '.buttons button[type=submit]');

$I->expect('form submitted with success but no changes made');
$I->see('Details updated successfully.', '.alert-success');
$I->see('Whats your pets name?', '.form-group');
$I->seeInFormFields('form', $old_fields);

//--------------------------------------------------------------------
// Expect Error with weak new password
//--------------------------------------------------------------------
$I->amGoingTo('change account password');
$I->fillField('old_password', 'monday');
$I->fillField('new_password', 'qwert');
$I->fillField('confirm_new_password', 'qwert');
$I->click('Save Details', '.buttons');

$I->expect('form error due to weak password and no changes');
$I->see('The New Password field must be at least 6 characters in length.', '.text-danger');
$I->dontSee('Details updated successfully.', '.alert-success');
$I->seeInFormFields('form', $old_fields);

//--------------------------------------------------------------------
// Form Error with non permitted characters and incorrect criteria
//--------------------------------------------------------------------
$I->amGoingTo('submit form with incorrect criteria or unacceptable characters');
$bad_fields = [
    // I suppose value is longer than maximum length of 32
    'first_name'        => 'Test TestTest Test TestTest Test TestTest Test TestTest ',
    // I suppose value is longer than maximum length of 32
    'last_name'         => 'User User User User User User User User ',
    // I suppose telephone field only permits numbers
    'telephone'         => '4a4a44a5a5a634',
    // I suppose email can not be changed
    'email'             => 'demo_acct@demo.com',
    // I suppose security question is selected
    'security_question_id'  => '11',
    // I suppose security answer is shorter than minimum length of 2
    'security_answer'   => 'S',
    // I suppose captcha does not match
    'newsletter'        => true,
];
$I->submitForm('form', $bad_fields, 'button[type=submit]');

$I->expect('form errors due to incorrect criteria and unacceptable characters');
$I->dontSee('Details updated successfully.', '.alert-success');
$I->see('The First Name field cannot exceed 32 characters in length.', '.text-danger');
$I->see('The Last Name field cannot exceed 32 characters in length.', '.text-danger');
$I->see('The Telephone field must contain an integer.', '.text-danger');
$I->dontSee('The Email Address field ', '.text-danger');
$I->dontSee('The Security Question field', '.text-danger');
$I->see('The Security Answer field must be at least 2 characters in length.', '.text-danger');
$I->seeCheckboxIsChecked('#newsletter');
$I->dontSee('The New Password', '.text-danger');
$I->dontSee('The Old Password', '.text-danger');

//--------------------------------------------------------------------
// Successfully update customer information
//--------------------------------------------------------------------
$I->amGoingTo('submit form with the correct criteria and permitted characters');
$fields = [
    'first_name'            => 'Mullaa',
    'last_name'             => 'Lpsumm',
    'telephone'             => '7483923',
    'security_question_id'  => '13',
    'security_answer'       => 'Mabel',
];
$I->submitForm('form', $fields, 'button[type=submit]');

$I->expect('form is submitted without errors and customer information is updated');
$I->see('Details updated successfully.', '.alert-success');
$I->seeInFormFields('form', $fields);
$I->seeCheckboxIsChecked('#newsletter');
$I->dontSeeElement('.text-danger');

//--------------------------------------------------------------------
// Check back navigation link.
//--------------------------------------------------------------------
$I->amGoingTo('check the back navigation link');
$I->seeLink('Back', '/account');

$I->comment('All Done!');