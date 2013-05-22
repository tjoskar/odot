/*=============================
=            Views            =
=============================*/

//View to handle "add sub items"
App.Views.AddSubItemsForm = Backbone.View.extend({
  events: {
    'keypress': 'keypress'                                                    // Triggerd every time the user press a key
  },

  input: null,
  parent: null,
  newSubitem: null,

  initialize: function()
  {
    this.parent = this.model.parent;                                          // "Stay connected to our parents"

    vent.on('subItem:createFromForm', this.createFromForm, this);             // After a subitem has been created by the form and been saved in the database, the server responds by this event
    vent.on('subItem:create', this.addItem, this);                            // The server push out a new subitem
  },

  render: function()
  {
    this.parent.$el.find('.sub-items').append( this.el );
  },

  keypress: function(e)
  {
    if (e.keyCode == 13 || e.keyCode == 9)                                    // If the user press 'enter', save the subitem and create a new input
    {
      var title       = this.input.val();
      this.newSubitem = new App.Models.SubItem({
        title: title,
        list_id: getLastVisitedListId(),
        item_id: this.parent.model.id
      });

      if (this.newSubitem.isValid())
      {
        this.newSubitem.save();
        this.newInput();                                                    // Generate a new input field
      }
      else
      {
        app.alert('Please, insert a valid title', 'alert');
      }
    }
  },

  stopEdit: function()
  {
    this.$el.empty();                                                       // Empty the view, ie. remove all input fields for this item
  },

  newInput: function()                                                      // Create a new input
  {
    this.input = $('<input class="add-sub-item" placeholder="Add subitem...">');
    this.$el.append(this.input);
    this.input.focus();
  },

  createFromForm: function(args)                                            // Called by the server when a new subitem has been created by this client
  {
    if (args.item_id == this.parent.model.get('id'))                        // Check if the new subitem should be added to our family (our parent is an item that contain subitems)?
    {
      this.newSubitem.set(args);                                            // Update the new subitem ie. give the subitem an id
      this.parent.subItemsCollection.add(this.newSubitem);                  // Add it to the collection so we can render it
    }
  },

  addItem: function(model)                                                  // Another user has create an subitem
  {
    if (model.item_id == this.parent.model.get('id'))                       // Check if the new subitem should be added our family? (our parent is an item that contain subitems)
    {
      var newSubItem = new App.Models.SubItem(model);                       // Create a new subitem
      this.parent.subItemsCollection.add(newSubItem);                       // Add it to the collection
      this.parent.subItemsView.render();                                    // And re-Render the subitems
    }
  }
});
