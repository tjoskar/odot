<?php

// Ensure that login works

$I = new WebGuy($scenario);
$I->wantTo('ensure that login works');
$I->amOnPage('/');
$I->see('ODOT');

$I->fillField('.auth-user', 'Oskar');
$I->fillField('.auth-pass', 'osk');
$I->click('.login-button');

$I->wait('2000');

$I->seeElement('#logout');

$I->click('#logout');

$I->wait('2000');

$I->seeElement('.auth-user');
