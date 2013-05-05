/*=============================
=            Views            =
=============================*/

App.Views.Item = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#item-template').html()),

  clicks: 0,
  _clickDelay: 200,
  timer: null,
  subItemsCollection: null,
  subItemsView: null,
  addSubItemView: null,

  events : {
    'click h3'                    : 'itemClick',
    'mouseenter'                  : 'showIcon',
    'mouseleave'                  : 'hideIcon',
    'click .icon-trash'           : 'deleteItem',
    'blur input'                  : 'blur',
    'mouseenter .checkbox-holder' : 'hoverCheckbox',
    'mouseleave .checkbox-holder' : 'hoverCheckbox',
    'click .checkbox-holder'      : 'clickCheckbox'
  },

  initialize: function(){
    // Create a form to add sub items
    this.addSubItemView = new App.Views.AddSubItemsForm({ model: {parent: this} });

    // Add sub items
    var subItems = this.model.getSubItems();                    // Get all sub items from the model
    this.subItemsCollection = new App.Collections.SubItem();    // Create a collection for the sub items
    for(var key in subItems)                                    // Loop through the subitems
    {
      var subItemModel = new App.Models.SubItem(subItems[key]); // Create a new model
      this.subItemsCollection.add(subItemModel);                // And add it to the subitem collection
    }
    // Create the subitem view
    this.subItemsView = new App.Views.SubItems({ collection: this.subItemsCollection });

    // Listen for "title change". If the title change, re-render it
    this.model.on("change:title", this.renderItem, this);
  },

  render: function() {
    this.renderItem();
    this.renderSubItems();
    this.addSubItemView.render();
    return this;
  },

  renderItem: function() {
    this.$el.html( this.template( this.model.toJSON() ));
  },

  renderSubItems: function() {
    var subItemHTML = this.$el.find('.sub-items');
    subItemHTML.prepend( this.subItemsView.render().el );
  },

  blur: function() {
    this.$inputs = this.$el.find('input');     // Get all inputs
    var that     = this;

    setTimeout(function() {                   // Wait to see if the user put his cursor in another field
      var focus = false;
      that.$inputs.each(function() {          // Loop through the input fields
        if ($(this).is(':focus'))             // And check if any of them is in focus
        {
          focus = true;
          return;
        }
      });

      if (!focus)                             // If the user dont select another field within 50 ms
        that.stopEdit();                      // the user are done editing

    }, 50);

  },

  itemClick: function() {
    this.clicks++;
    var that = this;

    if (this.clicks == 1)
    {
      this.timer = setTimeout(function() {    // Wait to see if the user only click once
        that.clicks = 0;                      // Reset the number of clicks
        that.showSubitems(true);              // And show the subitems
      }, this._clickDelay);
    }
    else
    {
      clearTimeout(this.timer);               // We dont need to wait any more, it is a double click
      this.clicks = 0;                        // Reset the number of clicks
      this.startEdit();                       // And show the edit-mode
    }
  },

  startEdit: function() {
      this.$inputs = this.$el.find('input');  // Get all inputs
      this.$inputs.removeClass('hide');       // Show all inputs
      this.$el.find('h3, p').hide();          // Hide the actual text
      this.addSubItemView.newInput();         // Add form for a new subitem
      this.showSubitems(false);               // Show subitems
      this.$inputs.first().focus();           // Set cursor at the first input field
  },

  stopEdit: function() {
      this.addSubItemView.stopEdit();         // Tell the child-view that we are done with editing
      this.updateCollection();                // Update the collection with the new data
      this.$el.find('h3, p').show();          // Show the actual text again
      this.$inputs.addClass('hide');          // And hide the input field again
      this.renderSubItems();                  // Rerender the subitems
      window.debug = this.subItemsCollection;
  },

  updateCollection: function() {
    var input = this.$el.find('input.itemEdit');          // Get input field for the "head" item
    var newTitle = input.val().trim();

    if (newTitle && this.model.get('title') != newTitle)  // Has the input change
    {
      this.model.save({title: newTitle});                 // Lets save it (local and in server db)
    }

    // Update subitem
    var inputs = this.$el.find('input.subItemEdit');      // Find all subitems input
    var that = this;
    inputs.each(function() {                              // And loop through them
      var id       = $(this).data('id');
      var model    = that.subItemsCollection.get(id);
      var newTitle = $(this).val().trim();

      if (newTitle && model.get('title') != newTitle)     // Has the title change
      {
        model.save({title: newTitle});                    // In that case, save it (local and in server db)
      }
    });
  },

  showSubitems: function(toggle) {                        // Show (and hide) the subitems
    if (toggle)
      this.$el.find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function() {                              // Hide the subitems
    $(this.el).find('.sub-items').slideUp("slow");
  },

  showIcon: function() {
    this.$el.find('.item-button-holder').show();
  },

  hideIcon: function() {
    this.$el.find('.item-button-holder').hide();
  },

  hoverCheckbox: function(e) {
    $(e.currentTarget).find('.icon-check-empty, .icon-check').toggleClass('hide');
  },

  clickCheckbox: function(e) {
    this.model.toogleCompleted();
    this.model.save();
    this.remove();
  },

  deleteItem: function() {
    this.model.destroy();
    this.remove();
  }
});
