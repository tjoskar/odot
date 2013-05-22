/*=============================
=            Views            =
=============================*/

// View to handle the "add item" input form
App.Views.AddItemForm = Backbone.View.extend({
  el: $('form.add-item'),
  inputField: null,
  newItem: null,

  events: {
    "submit" : "addNewItem"
  },

  initialize: function() {
    vent.on('item:createFromForm', this.addItemFromForm, this);                                 // After an item has been created by the form and been saved in the database, the server responds by this event
    vent.on('item:create', this.addItem, this);                                                 // The server push out a new item
  },

  addNewItem: function(e)                                                                       // User submit the form
  {
    e.preventDefault();
    this.inputField = this.$el.find('input');
    var title       = this.inputField.val().trim();
    this.newItem    = new App.Models.Item({title: title, list_id: getLastVisitedListId()});     // Create a new item

    if (this.newItem.isValid())                                                                 // Check if the new item is valid
    {
      this.newItem.save();                                                                      // And if it is valid, save it
    }
    else
    {
      app.alert('Please, insert a valit titel', 'alert');
    }
  },

  addItemFromForm: function(args)                                                               // Called by the server when a new item has been created by THIS client
  {
    this.inputField.val('');                                                                    // Clear input field
    this.newItem.set(args);                                                                     // Update the item ie. give the item an id
    app.itemsView.collection.add(this.newItem);                                                 // Add new item to collection
  },

  addItem: function(model)                                                                      // Another user has create an item
  {
    var currentListId = getLastVisitedListId();
    if (model.list_id === currentListId)                                                        // Check if the item shuld be added to this list (the list that the user currently are viewing)
    {
      var newItem = new App.Models.Item(model);                                                 // Create the item
      app.itemsView.collection.add(newItem);                                                    // And add it
    }
    else
    {
      listModel = app.listsView.collection.get(model.list_id);
      if (!_.isUndefined(listModel))
      {
        app.alert('New item is added to the list: '+listModel.get('title'));
      }
    }
  }

});
