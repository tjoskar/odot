/*=============================
=            Views            =
=============================*/

// View to handle the "add list" input form
App.Views.AddListForm = Backbone.View.extend({
  el: $('form.add-list'),

  events: {
    "submit" : "addNewList"
  },

  addNewList: function(e) {
    e.preventDefault();
    var inputField  = $(this.el).find('input');
    var enteredText = inputField.val().trim();
    var newList     = new App.Models.List({title: enteredText});

    if (newList.isValid())
    {
      /**
          TODO:
          - Istället för att rendera om hela list vyn så borde vi enbart lägga till den nya listan längst ner
      **/
      app.listsView.collection.add(newList); // Add new list to collection
      newList.save().then(function() {
        app.listsView.showAllLists();        // Re-render lists
        inputField.val('');                  // Clear input field
      });
    }
    else
    {
      /**
          TODO:
          - Cerate a warning dialog
      **/
    }
  }

});