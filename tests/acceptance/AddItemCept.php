<?php
$I = new WebGuy($scenario);
$I->wantTo('ensure that we can add and remove an item');
$I->amOnPage('/');
$I->see('ODOT');

$I->fillField('.auth-user', 'Oskar');
$I->fillField('.auth-pass', 'osk');
$I->click('.login-button');

$I->wait('2000');

$I->seeElement('input.add-item');

$I->fillField('input.add-item', 'New Item');
$I->click('.add-item-button');

$I->wait('1000');

$I->see('New Item', 'h3');

// $I->click('//*[@id="items-holder"]/ul/li[last()]/*[@class="head-item"]/*[contains(@class, "item-button-holder")]/*[@class="icon-trash"]');

// $I->wait('1000');

// $I->dontSee('New Item', 'h3');
