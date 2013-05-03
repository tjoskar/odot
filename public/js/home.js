/*=============================
=            Home             =
=    The app starting point   =
=============================*/

app.router = new App.Router();
new App.Views.AddListForm();
new App.Views.AddItemForm();

//Fetch all lists
var listCollection = new App.Collections.List();
listCollection.fetch().then(function() {
  app.listsView = new App.Views.Lists({ collection: listCollection });
  app.listsView.showAllLists();

  // Firing up the router
  Backbone.history.start();
});










