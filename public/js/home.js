/*=============================
=            Home             =
=    The app starting point   =
=============================*/


// Global functions
var vent = _.extend({}, Backbone.Events);

var d = function(msg) {
  console.log(msg);
};

// Let's go, yo
app.router = new App.Router();
new App.Views.AddListForm();
new App.Views.AddItemForm();

new App.Views.UserInfo();

// Fetch all lists
var listCollection = new App.Collections.List();
listCollection.fetch().then(function() {
  app.listsView = new App.Views.Lists({ collection: listCollection });
  app.listsView.showAllLists();

  // Firing up the router
  Backbone.history.start();
});


