ODOT
==================================================

Functional specification:
--------------------------------------

Our project is a web based to-do list. The purpose of the site is to allow user to keep track of and manage to-do items.
The site allow users to do the following:
- Creating to-do lists.
- Creating to-do items inside a to-do list.
- Sort to-do items and lists.
- Grouping to-do items, by adding sub-items to to-do items.
- Create user accounts by using Facebook SDK and Laravels user authentication.
- Sharing to-do lists with other users.
- Get realtime updates by using websocket

Technological specification
--------------------------------------

We are using Laravel4 as server framework and Backbone on the client side. The communication between server and client is done using web sockets in JSON format. We are using web sockets instead of polling and in other cases there it is a benefit over ajax. However, some data communication is still made by traditional ajax request.
Authentication is made with an integrated authentication system provided with laravel and we are using Facebooks SDK authentication as an option.
We are using phpunit and Codeception (whith Selenium) for unit- and acceptance testning.

## Software

- [Laravel4](http://laravel.com/) - Backend framework
- [Ratchet](http://socketo.me/) - PHP library for websocket
- [Backbone](http://backbonejs.org) - Frontend framework
- [Underscore](http://underscorejs.org/) - Template manager. Required by Backbone
- [jQuery](http://jquery.com/) - Required by Backbone
- [Bower](https://github.com/bower/bower) - JavaScript package manager
- [Grunt](http://gruntjs.com/) - JavaScript Task Runner
- [Composer](http://getcomposer.org/) - PHP package manager
- [PHPunit](https://github.com/sebastianbergmann/phpunit/) - Unit-tester for PHP
- [Codeception](http://codeception.com/) - PHP testing framework (We are only using this for acceptance testning)
- [Selenium](http://seleniumhq.org) - Browser automation


## License
ODOT is open-sourced software licensed under the MIT License.
