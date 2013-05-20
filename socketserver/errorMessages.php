<?php

$_JSONError = array(
    'status' => 400,
    'error'  => array(
        'name' => 'JSONError',
        'args' => 'Invalid JSON data'));

$_MethodError = array(
    'status' => 400,
    'error'  => array(
        'name' => 'MethodError',
        'args' => 'Invalid method call'));

$_ArgumentError = array(
    'status' => 400,
    'error'  => array(
        'name' => 'ArgumentError',
        'args' => 'Invalid argument'));

$_UnauthorizedError = array(
    'status' => 401,
    'error'  => array(
        'name' => 'Unauthorized',
        'args' => 'You are unauthorized for this operation'));
