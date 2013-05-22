[ODOT]
==================================================

Functional specification:
--------------------------------------

Our project proposal is to make an to-do list. The purpose of the site is to allow a user to keep track of and manage to-do items.
The site should allow the user to do the following
- Creating to-do lists.
- Creating to-do items inside a to-do list.
- Sort <span stype="text-decoration:line-through">and assign color to</span> to-do items and lists.
- Grouping to-do items, i.e. adding sub-items to to-do items.
- User accounts using i.e. Facebook/OpenID/Custom.
- Sharing to-do lists with other users.
- <span stype="text-decoration:line-through">Add email-notifications/reminders for items at a specific time and date.</span>
- <span stype="text-decoration:line-through">Offline access, changes are synced when online again.</span>

Technological specification
--------------------------------------

We are using Laravel4 as server framework and Backbone on the client side. The communication between server and client is done using web sockets in JSON format. We are using web sockets instead of polling and in other cases there it is a benefit over ajax. Authentication is made with an integrated authentication system provided with laravel and we are using Facebooks SDK authentication as an option. We are using phpunit and Codeception (Selenium) for unit- and acceptance testning.

## Software
- Laravel4
- Ratchet
- Backbone
- Bower
- Grunt
- Composer
- PHPunit
- Codeception

## License
ODOT is open-sourced software licensed under the MIT License.
