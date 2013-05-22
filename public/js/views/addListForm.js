/*=============================
=            Views            =
=============================*/

// View to handle the "add list" input form
App.Views.AddListForm = Backbone.View.extend({
  el: $('form.add-list'),

  events: {
    "submit" : "addNewList"
  },

  addNewList: function(e)                                                   // Called when user submit the form
  {
    e.preventDefault();
    var inputField = $(this.el).find('input');
    var enteredText = inputField.val().trim();
    var newList     = new App.Models.List({title: enteredText});

    if (newList.isValid())
    {
      newList.save().then(function() {
        inputField.val('');                                                 // Clear input field
        app.listsView.collection.add(newList);                              // Add new list to collection
      });
    }
    else
    {
      app.alert('Please, insert a valid title', 'alert');
    }
  }

});
