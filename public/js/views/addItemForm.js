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
    vent.on('item:createFromForm', this.addItemFromForm, this);
    vent.on('item:create', this.addItem, this);
    //vent.on('item:delete', this.deleteItem, this);
    //vent.on('item:update', this.updateItem, this);
  },

  addNewItem: function(e) {
    e.preventDefault();
    this.inputField = this.$el.find('input');
    var title       = this.inputField.val().trim();
    this.newItem    = new App.Models.Item({title: title, list_id: getLastVisitedListId()});

    if (this.newItem.isValid())
    {
      this.newItem.save();
    }
    else
    {
      app.alert('An error occurred', 'alert');
    }
  },

  addItemFromForm: function(args) {
    this.inputField.val('');                    // Clear input field
    this.newItem.set(args);
    app.itemsView.collection.add(this.newItem); // Add new item to collection
  },

  addItem: function(model) {
    var currentListId = getLastVisitedListId();
    if (model.list_id === currentListId)
    {
      var newItem = new App.Models.Item(model);
      app.itemsView.collection.add(newItem);
    }
    else
    {
      app.alert('New item is added');
    }
  }

  // deleteItem: function(model)
  // {
  //   var currentListId = getLastVisitedListId();
  //   if (model.list_id === currentListId)
  //   {
  //     app.itemsView.collection.remove(model);
  //   }
  //   else
  //   {
  //     app.alert('A item has been removed');
  //   }
  // },

  // updateItem: function(model)
  // {
  //   d('updateItem');
  //   var currentListId = getLastVisitedListId();
  //   if (model.list_id === currentListId)
  //   {
  //     var item = app.itemsView.collection.get(model.id);
  //     item.set(model);
  //   }
  //   else
  //   {
  //     app.alert('A item has been removed');
  //   }
  // }

});