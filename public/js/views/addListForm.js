/*=============================
=            Views            =
=============================*/

//View to handle the "add list" input form
App.Views.AddListForm = Backbone.View.extend({
  el: $('form.add-list'),

  events: {
    "submit" : "addNewList"
  },

  addNewList: function(event) {
    event.preventDefault();
    var inputField = $(this.el).find('input');
    var enteredText = inputField.val().trim();
    var newList = new App.Models.List({title: enteredText});
    
    if (newList.isValid()) {
      app.listsView.collection.add(newList); //Add new list to collection
      newList.save().then(function() {
        //newList.id;
        app.listsView.showAllLists(); //Re-render lists
        inputField.val(''); //Clear input field
      });
    }
  },

  initialize: function() {
    //console.log("initialize addListForm");
  }
});