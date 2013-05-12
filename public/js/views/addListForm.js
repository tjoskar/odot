/*=============================
=            Views            =
=============================*/

// View to handle the "add list" input form
App.Views.AddListForm = Backbone.View.extend({
  el: $('form.add-list'),
  inputField: null,
  newList: null,

  events: {
    "submit" : "addNewList"
  },

  initialize: function() {
    vent.on('list:createFromForm', this.addListFromForm, this);
    vent.on('list:create', this.addList, this);
  },

  addNewList: function(e) {
    e.preventDefault();
    this.inputField = $(this.el).find('input');
    var enteredText = this.inputField.val().trim();
    this.newList    = new App.Models.List({title: enteredText});

    if (this.newList.isValid())
    {
      var then = this;
      this.newList.save().then(function() {
        then.addListFromForm();
      });
    }
    else
    {
      /**
          TODO:
          - Cerate a warning dialog
      **/
    }
  },

  addListFromForm: function(args) {
    this.inputField.val('');                    // Clear input field
    this.newList.set(args);
    app.listsView.collection.add(this.newList); // Add new list to collection
  },

  addList: function(model) {
    d(model);
    var newList = new App.Models.List(model);
    app.listsView.collection.add(newList);
  }

});