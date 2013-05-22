/*=============================
=            Views            =
=============================*/

App.Views.Item = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#item-template').html()),

  clicks: 0,
  clickDelay: 200,
  timer: null,
  subItemsCollection: null,
  subItemsView: null,
  addSubItemForm: null,
  datepicker: null,

  events : {
    'click h3'                         : 'itemClick',
    'mouseenter'                       : 'mouseEnter',
    'mouseleave'                       : 'mouseLeave',
    'click .head-item .icon-trash'     : 'deleteItem',
    'click .head-item .icon-time'      : 'setDate',
    'click .head-item .due-date'       : 'setDate',
    'blur input'                       : 'blur',
    'mouseenter .item-checkbox-holder' : 'hoverCheckbox',
    'mouseleave .item-checkbox-holder' : 'hoverCheckbox',
    'click .item-checkbox-holder'      : 'clickCheckbox'
  },

  initialize: function()
  {
    // Create a form to add sub items
    this.addSubItemForm = new App.Views.AddSubItemsForm({ model: {parent: this} });

    // Add sub items
    var subItems = this.model.getSubItems();                                        // Get all sub items from the model
    this.subItemsCollection = new App.Collections.SubItem();                        // Create a collection for the subitems
    for(var key in subItems)                                                        // And loop through them
    {
      var subItemModel = new App.Models.SubItem(subItems[key]);                     // Create a new model
      this.subItemsCollection.add(subItemModel);                                    // And add it to the subitem-collection
    }

    // Create the subitem view
    this.subItemsView = new App.Views.SubItems({ collection: this.subItemsCollection });

    this.model.on("change:title", this.renderItem, this);                           // Listen for "title change". If the title change, re-render it
    this.model.on("remove", this.removeView, this);                                 // If the model disappear, remove the view
    vent.on('item:delete', this.socketDeleteItem, this);                            // Server trigger this event
    vent.on('item:update', this.updateItem, this);                                  // This event is trigged by the server when an item should be updated
  },

  render: function()                                                                // Render the whole object (item, subitem and a form for adding subitems)
  {
    this.renderItem();
    this.renderSubItems();
    this.addSubItemForm.render();
    return this;
  },

  renderItem: function()                                                            // Just render the "head" item
  {
    this.$el.html( this.template( this.model.toJSON() ));

    var dateinput = this.$el.find('.datepicker').pickadate();                       // Add the possibility to add a due date
    this.datepicker = dateinput.pickadate('picker');
    this.datepicker.set('min', true);                                               // The user can not be choose a date in the past
  },

  renderSubItems: function()                                                        // Finaly, render the subitems
  {
    var subItemHTML = this.$el.find('.sub-items');
    subItemHTML.prepend( this.subItemsView.render().el );
  },

  blur: function()                                                                  // The user loses input focus
  {
    this.$inputs = this.$el.find('input');                                          // Get all inputs
    var that     = this;

    setTimeout(function() {                                                         // Wait to see if the user put his cursor in another field
      var focus = false;
      that.$inputs.each(function() {                                                // Loop through the input fields
        if ($(this).is(':focus'))                                                   // And check if any of them is in focus
        {
          focus = true;
          return;
        }
      });

      if (!focus)                                                                   // If the user dont select another field within 50 ms
        that.stopEdit();                                                            // the user are done editing

    }, 50);

  },

  itemClick: function()                                                             // The user clicks at an item
  {
    this.clicks++;
    var that = this;

    if (this.clicks == 1)
    {
      this.timer = setTimeout(function() {                                          // Wait to see if the user only click once
        that.clicks = 0;                                                            // In that case, reset the number of clicks
        that.showSubitems(true);                                                    // And show the subitems
      }, this.clickDelay);
    }
    else
    {
      clearTimeout(this.timer);                                                     // We dont need to wait any more, it is a double click
      this.clicks = 0;                                                              // Reset the number of clicks
      this.startEdit();                                                             // And show the edit-mode
    }
  },

  startEdit: function()                                                             // Start edit mode
  {
      this.$inputs = this.$el.find('input');                                        // Get all inputs
      this.$inputs.removeClass('hide');                                             // Show all inputs
      this.$el.find('h3, p').hide();                                                // Hide the actual text
      this.$el.find('.item-checkbox-holder').hide();                                // Hide all checkboxs
      this.$el.find('.subitem-checkbox-holder').hide();
      this.addSubItemForm.newInput();                                               // Add form for a new subitem
      this.showSubitems(false);                                                     // Show subitems
      this.$inputs.first().focus();                                                 // Set cursor at the first input field
  },

  stopEdit: function()                                                              // Quit edit mode
  {
      this.addSubItemForm.stopEdit();                                               // Tell the child-view that we are done with editing
      this.updateCollection();                                                      // Update the collection with the new data
      this.$el.find('h3, p').show();                                                // Show the actual text again
      this.$el.find('.item-checkbox-holder').show();                                // Show all checkboxs again
      this.$el.find('.subitem-checkbox-holder').show();
      this.$inputs.addClass('hide');                                                // And hide the input field again
      this.renderSubItems();                                                        // Rerender the subitems
  },

  updateCollection: function()                                                      // Update collection
  {
    var input = this.$el.find('input.itemEdit');                                    // Get input field for the "head" item
    var newTitle = input.val().trim();                                              // And the inserted value

    if (newTitle && this.model.get('title') != newTitle)                            // Has the title changed
    {
      this.model.save({title: newTitle});                                           // Okay then, lets save it (local and server db)
    }

    // Update subitem
    var inputs = this.$el.find('input.subItemEdit');                                // Find all subitems input
    var that = this;
    inputs.each(function() {                                                        // And loop through them
      var id       = $(this).data('id');
      var model    = that.subItemsCollection.get(id);
      var newTitle = $(this).val().trim();

      if (newTitle && model.get('title') != newTitle)                               // Has the title change
      {
        model.save({title: newTitle});                                              // In that case, save it (local and in server db)
      }
    });
  },

  showSubitems: function(toggle)                                                    // Allways show subitems if toogle = false
  {                                                                                 // otherwise, toggle appearance
    if (toggle)
      this.$el.find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function()                                                          // Hide subitems
  {
    $(this.el).find('.sub-items').slideUp("slow");
  },

  mouseEnter: function(e)                                                           // Show buttons when the user enter the object
  {
    this.$el.find('.item-button-holder').removeClass('hide');
  },

  mouseLeave: function(e)                                                           // And hide them when the user's cursor is leaving
  {
    this.$el.find('.item-button-holder').addClass('hide');
  },

  hoverCheckbox: function(e)                                                        // Toggel check-box-status when user is hover over it
  {
    $(e.currentTarget).find('.icon-check-empty, .icon-check').toggleClass('hide');
  },

  clickCheckbox: function(e)                                                        // Called when user mark a item as completed
  {
    this.stopListening();                                                           // Stop listeing
    this.model.toogleCompleted();                                                   // Toggel completed-status ie. mark item as completed
    this.model.save();                                                              // Send a send event to the server
    vent.trigger('item:completed', this.model.toJSON());                            // Send event to completedItems.js that will add this item (inc. subitems) to the 'compleated'-list
    this.remove();
    this.model.destroy({reportToServer: false});                                    // Remove this item BUT we can not remove it from the server, therefore we are silent
  },

  socketDeleteItem: function(model)                                                 // Called by the socketserver
  {
    if (model.id == this.model.get('id'))
    {
      this.model.destroy({reportToServer: false});                                  // The client must not send a new destroy call to the webbserver
    }
  },

  deleteItem: function()                                                            // Called when user clicks on trash-icon
  {
    this.model.destroy();
  },

  setDate: function(e)                                                              // The user want to set a due date for the item
  {
    var self = this;
    this.datepicker.on('set', function() {
      self.model.set('due_date', this.get());
      self.model.save();
      self.renderItem();
    });
    this.datepicker.open();
    e.stopPropagation();
  },

  removeView: function()                                                            // Called when the model is removed
  {
    this.remove();
  },

  updateItem: function(model)                                                       // The server says that we should update the item
  {                                                                                 // so, lets do it.
    if (model.id == this.model.get('id'))                                           // Are the server talking about us?
    {
      if (this.model.get('completed') != model.completed)                           // Should we move the item to the completed-list
      {
        this.stopListening();                                                       // Okey, then. Stop listening on event
        vent.trigger('item:completed', model);                                      // Firer of an event to the completed-list
        this.model.destroy({reportToServer: false});                                // Remove the item, but dont tell anyone
        this.remove();                                                              // Remove the view
      }
      else
      {
        this.model.set(model);                                                      // Just update the item
        app.itemsView.collection.sort();                                            // Sort the collection
        app.itemsView.render();                                                     // And render it
      }
    }
  }
});
