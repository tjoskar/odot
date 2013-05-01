/*=============================
=            Home             =
=    The app starting point   =
=============================*/

app.router = new App.Router();
new App.Views.AddListForm();
new App.Views.AddItemForm();

//Fetch all lists
app.listCollection = new App.Collections.List();
app.listCollection.fetch().then(function() {
  app.listsView = new App.Views.Lists({ collection: app.listCollection });
  app.listsView.showAllLists();

  Backbone.history.start();
  //app.router.navigate('', {trigger: true, replace:true});

});










