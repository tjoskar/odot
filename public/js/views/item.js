/*=============================
=            Views            =
=============================*/

App.Views.Item = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#item-template').html()),

  clicks: 0,
  DELAY: 200,
  timer: null,
  subItemsCollection: null,
  subItemsView: null,
  addSubItemView: null,

  events : {
    'click h3'          : 'itemClick',
    'mouseenter'        : 'showIcon',
    'mouseleave'        : 'hideIcon',
    'click .icon-trash' : 'deleteItem',
    'blur input'        : 'blur'
  },

  initialize: function(){
    // Create a form to add sub items
    this.addSubItemView = new App.Views.AddSubItemsForm({ model: {parent: this} });

    // Add sub items
    var subItems = this.model.get('sub_items');                 // Get all sub items from the model
    this.subItemsCollection = new App.Collections.SubItem();    // Create a collection for the sub items
    for(var key in subItems)
    {
      var subItemModel = new App.Models.SubItem(subItems[key]);
      this.subItemsCollection.add(subItemModel);
    }
    this.subItemsView = new App.Views.SubItems({ collection: this.subItemsCollection });
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
    var that = this;
    this.$inputs = this.$el.find('input');
    console.log();

    setTimeout(function() {
      var focus = false;
        that.$inputs.each(function() {
          if ($(this).is(':focus'))
          {
            focus = true;
            return;
          }
        });
        if (!focus)
        {
          that.stopEdit();
        }
      }, 50);
  },

  itemClick: function() {
    this.clicks++;

    var that = this;

    if (this.clicks == 1)
    {
      this.timer = setTimeout(function() {
        that.showSubitems(true);
        that.clicks = 0;
      }, this.DELAY);
    }
    else
    {
      clearTimeout(this.timer);
      this.clicks = 0;
      this.startEdit();
    }
  },

  startEdit: function() {
      this.$inputs = this.$el.find('input');
      this.$inputs.removeClass('hide');  // Show all inputs
      this.$el.find('h3, p').hide();     // Hide the actual text
      this.addSubItemView.newInput();    // Add form for a new subitem
      this.showSubitems(false);          // Show subitems
      this.$inputs.first().focus();      // Set cursor at the first input feld
  },

  stopEdit: function() {
      this.addSubItemView.stopEdit();
      this.updateCollection();
      this.$el.find('h3, p').show();
      this.$inputs.addClass('hide');
      this.renderSubItems();
      window.debug = this.subItemsCollection;
  },

  updateCollection: function() {
    // Update Item
    var input = this.$el.find('input.itemEdit');
    var newTitle = input.val().trim();
    if (newTitle && this.model.get('title') != newTitle)
    {
      console.log('Update title for item');
      this.model.save({title: newTitle});
    }


    // Update subitem
    var inputs = this.$el.find('input.subItemEdit');
    var that = this;
    inputs.each(function() {
      var id       = $(this).data('id');
      var model    = that.subItemsCollection.get(id);
      var newTitle = $(this).val().trim();
      if (newTitle && model.get('title') != newTitle)
      {
        console.log('Update title');
        model.save({title: newTitle});
      }
    });
  },

  showSubitems: function(togle) {
    if (togle)
      this.$el.find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function() {
    $(this.el).find('.sub-items').slideUp("slow");
  },

  showIcon: function() {
    this.$el.find('.item-button-holder').show();
  },

  hideIcon: function() {
    this.$el.find('.item-button-holder').hide();
  },

  deleteItem: function() {
    this.model.destroy();
    this.remove();
  }
});
