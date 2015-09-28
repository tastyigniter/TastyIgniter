<?php
namespace Main\Acceptance;

use \AcceptanceTester;

/**
 * @group main
 */
class AccountCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Customer');
    }

    public function checkInformation(AcceptanceTester $I) {
        $I->wantTo('view my account information on account page');

        $I->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $I->amOnPage('/account');

        $I->click('My Details', '#nav-tabs');

        $I->expectTo('see my account information');
        $I->see('First Name: John', '#details');
        $I->see('Last Name: Doe', '#details');
        $I->see('Email Address: john.doe@example.com', '#details');
        $I->see('Password: Change Password', '#details');
        $I->see('Telephone: 0123456789', '#details');
        $I->see('Security Question: Whats your pets name?', '#details');
        $I->see('Security Answer: ******', '#details');
    }

    public function testFailedEditInformation(AcceptanceTester $I) {
        $I->wantTo('update account information');

        $I->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $I->amOnPage('/account/details');

        $fields = [
            'first_name'        => 'J', // I suppose value is longer than maximum length of 32
            'last_name'         => 'D', // I suppose value is longer than maximum length of 32
            'telephone'         => 'Telea5a634', // I suppose telephone field only permits numbers
            'email'             => 'johndoe@example.com', // I suppose email can not be changed
            'security_question_id'  => '11', // I suppose security question is selected
            'security_answer'   => 'S', // I suppose security answer is shorter than minimum length of 2
            'newsletter'        => true, // I suppose captcha does not match
        ];
        $I->submitForm('form', $fields, 'button[type=submit]');

        $I->expectTo('failure with form errors due to invalid form values');
        $I->see('Sorry but form validation has failed, please check for errors', '.alert-danger');
        $I->see('The First Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Last Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Telephone field must contain an integer.', '.text-danger');
        $I->see('The Security Answer field must be at least 2 characters in length.', '.text-danger');

        $I->dontSee('The Email Address field ', '.text-danger');
        $I->dontSee('The Security Question field', '.text-danger');
        $I->dontSee('The New Password', '.text-danger');
        $I->dontSee('The Old Password', '.text-danger');

        $I->seeCheckboxIsChecked('#newsletter');

        $I->dontSeeInField('email','johndoe@example.com');
    }

    public function testEditInformation(AcceptanceTester $I) {
        $I->wantTo('edit account information');

        $I->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $I->amOnPage('/account/details');

        $fields = [
            'first_name'            => 'Adam',
            'last_name'             => 'Smith',
            'telephone'             => '012345678910',
            'security_question_id'  => '13',
            'security_answer'       => 'Eve',
        ];
        $I->submitForm('form', $fields, 'button[type=submit]');

        $I->expect('account information updated without errors');
        $I->see('Details updated successfully.', '.alert-success');
        $I->dontSeeElement('.text-danger');

        $I->seeInFormFields('form', $fields);

        $I->seeCheckboxIsChecked('#newsletter');
    }

    public function testAddAddress(AcceptanceTester $I) {
        $I->wantTo('add a new delivery address');

        $I->doRegistration($I);

        $I->login('john.doe@example.com', 'pass123456');

        $I->amOnPage('/account/address/edit');

        $fields = [
            'address[address_1]'    => 'Address 1',
            'address[address_2]'    => 'Address 2',
            'address[city]'         => 'City',
            'address[state]'        => 'State',
            'address[postcode]'     => '0000 000',
            'address[country]'      => '222',
        ];
        $I->submitForm('form', $fields, 'button[type=submit]');

        $I->expect('the delivery address added without errors');
        $I->see('Address added/updated successfully.', '.alert-success');
        $I->dontSeeElement('.text-danger');
        $I->see('Address 1', 'address');
        $I->see('Address 2', 'address');
        $I->see('City', 'address');
        $I->see('State', 'address');
    }

    public function testFailedLogin(AcceptanceTester $I) {
        $I->wantTo('login into account');

        $I->doRegistration($I);

        $I->amOnPage('/logout');
        $I->amOnPage('/login');

        $I->amGoingTo('submit login form with an invalid password');
        $I->fillField('email', 'john.doe@example.com');
        $I->fillField('password', 'badstuff');
        $I->click('#login-form button');

        $I->expect('login failure due to invalid password');
        $I->see('Username and password not found!', '.alert-danger');
    }

    public function testLogin(AcceptanceTester $I) {
        $I->wantTo('login into account');

        $I->doRegistration($I);

        $I->amOnPage('/logout');
        $I->amOnPage('/login');

        $I->amGoingTo('submit login form with the registered email and password');
        $I->fillField('email', 'john.doe@example.com');
        $I->fillField('password', 'pass123456');
        $I->click('#login-form button');

        $I->expect('to be logged in');
        $I->dontSeeElement('.alert-danger');
        $I->seeCurrentUrlEquals('/account');
        $I->see('My Account', 'h2');
        $I->see('john.doe@example.com', '#details');
    }

    public function testPasswordReset(AcceptanceTester $I) {
        $I->wantTo('reset account password');

        $I->doRegistration($I);

        $I->amOnPage('/logout');
        $I->amOnPage('/account/reset');

        $fields = [
            'email'             => 'john.doe@example.com',
            'security_question' => '11',
            'security_answer'   => 'Spike',
        ];
        $I->submitForm('form', $fields, 'form button[type=submit]');

        $I->expect('new account password generated and emailed');
        $I->dontSeeElement('.alert-danger');
        $I->see('Password reset successfully, please check your email for your new password.', '.alert-success');

        $I->expect('the old password is no longer recognised');
        $I->login('john.doe@example.com', 'pass123456');
        $I->see('Username and password not found!', '.alert-danger');
    }

    public function testFailedRegistration(AcceptanceTester $I) {
        $I->wantTo('register an account');

        $I->amOnPage('/register');

        $I->amGoingTo('submit register form with all required fields blank');
        $I->seeElement('#register-form button[type=submit]');
        $I->submitForm('#register-form form', [], '#register-form button[type=submit]');

        $I->expect('form errors due to blank required form fields');
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

        $I->amGoingTo('submit register form with incorrect and acceptable characters');
        $fields = [
            'first_name'        => 'F', // I suppose value is shorter than minimum length of 2
            'last_name'         => 'L', // I suppose value is shorter than minimum length of 2
            'email'             => 'fake_email_address.com', // I suppose email is invalid
            'password'          => 'bad', // I suppose password is shorter than minimum length of 6
            'password_confirm'  => 'bad',
            'telephone'         => 'tel1283', // I suppose telephone field only permits numbers
            'security_answer'   => 'S', // I suppose security answer is shorter than minimum length of 2
            'captcha'           => '7382s', // I suppose captcha does not match
        ];
        $I->click('#newsletter'); // Click subscribe to newsletter button
        $I->submitForm('#register-form form', $fields, '#register-form button[type=submit]');

        $I->expect('registration failure with form errors');
        $I->see('The First Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Last Name field must be at least 2 characters in length.', '.text-danger');
        $I->see('The Email Address field must contain a valid email address', '.text-danger');
        $I->see('The Password field must be at least 6 characters in length.', '.text-danger');
        $I->see('The Telephone field must contain an integer.', '.text-danger');
        $I->see('The Security Answer field must be at least 2 characters in length.', '.text-danger');
        $I->see('The letters you entered does not match the image.', '.text-danger');
        $I->see('The I Agree field is required.', '.text-danger');
        $I->dontSee('The Password Confirm field is required.', '.text-danger');
        $I->dontSee('The Security Question field is required.', '.text-danger');
    }
}
