<?php

// Ensure that we can rename an item

$I = new WebGuy($scenario);
$I->wantTo('ensure that we can rename an item');
$I->amOnPage('/');
$I->see('ODOT');

$I->fillField('.auth-user', 'Oskar');
$I->fillField('.auth-pass', 'osk');
$I->click('.login-button');

$I->wait('2000');

$I->seeElement('//*[@id="items-holder"]/ul/li[1]//h3');

$I->dontSee('New item title', 'h3');

$I->click('//*[@id="items-holder"]/ul/li[1]//h3');
$I->click('//*[@id="items-holder"]/ul/li[1]//h3');

$I->wait('2000');

$I->fillField('.itemEdit', 'New item title');

$I->click('.logo');

$I->wait('1000');

$I->see('New item title', 'h3');
