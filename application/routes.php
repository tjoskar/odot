<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/
/*
Route::get('/', array('before' => 'auth', function() { }));
//


Route::get('login', function() {
    return View::make('login');
});
*/
/*Route::get('/', array('before' => 'auth', 'do' => function() { 
	return View::make('home');
}));
*/
//Route::get('/', 'home.index');
//Route::get('/', 'home@index');
Route::controller('home');
/*
Route::get('/', 'home@index');
Route::get('home', 'home@index');
Route::get('login', 'home@get_login');
Route::post('login', 'home@post_login');
Route::get('logout', 'home@get_logout');
*/
/*
Route::get('home', array('before' => 'auth', 'do' => function() {
    return View::make('home.index');
}));
*/
//Route::controller('home');

Route::get('item', 'item@index');
Route::get('item/(:num)', 'item@index');
Route::post('item', 'item@index');
Route::put('item/(:num)', 'item@index');
Route::delete('item/(:num)', 'item@index');

Route::get('lists', 'lists@index');
Route::get('list/(:num)', 'lists@list');
Route::post('list', 'lists@list');
Route::delete('lists/(:num)', 'lists@list');

Route::get('subitem', 'subitem@index');
Route::post('subitem', 'subitem@index');
Route::put('subitem/(:num)', 'subitem@index');
Route::delete('subitem/(:num)', 'subitem@index');






/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function() {
	return Response::error('404');
});

Event::listen('500', function($exception) {
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

//Route::filter('pattern: /*', 'auth');
/*
Route::filter('guest', function() {
	if (Auth::check()) {
		return Redirect::route('home')->with('flash-notice', 'You are already logged in!');
	}
});
*/
/*
Route::filter('auth', function() {
	if (Auth::guest()) { 
		Session::put('redirect', URL::full());
		return Redirect::to('login')->with('flash_error', 'You must be logged in to view this page!');
	}
	
	if ($redirect = Session::get('redirect')) {
        Session::forget('redirect');
        return Redirect::to($redirect);
    }
});
*/
Route::filter('before', function() {
	// Do stuff before every request to your application...
	
});

Route::filter('after', function($response) {
	// Do stuff after every request to your application...
});

Route::filter('csrf', function() {
	if (Request::forged()) return Response::error('500');
});

