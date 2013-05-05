# ODOT

## Functional specification:

Our project proposal is to make an to-do list. The purpose of the site is to allow a user to keep track of and manage to-do items.
The site should allow the user to do the following
- Creating to-do lists.
- Creating to-do items inside a to-do list.
- Sort and assign color to to-do items and lists.
- Grouping to-do items, i.e. adding sub-items to to-do items.
- User accounts using i.e. Facebook/OpenID/Custom.
- Sharing to-do lists with other users.
- Add email-notifications/reminders for items at a specific time and date.
- Offline access, changes are synced when online again.

## Technological specification:

We are going to use Laravel4 as server framework and Backbone (and Jquery) on the client side. The communication between server and client will be done using web sockets in JSON format. We are going to try to use web sockets instead of polling and in other cases if there can be a benefit over ajax. Authentication will probably be done with an integrated authentication system provided with laravel and we aim to add Facebook/OpenID authentication as an option. We will also try to make the site well suited for a handheld device such as an smartphone or tablet. We aim to use a testing framework to set up a suit of automated tests to be used along the development to allow for fast and basic functionality verification, i.e. using Codeception or Selenium.

## License
ODOT is open-sourced software licensed under the MIT License.
