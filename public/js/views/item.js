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
    'click h3' : 'itemClick',
    'click .icon-cog' : 'showDeleteConfirm',
    'blur input' : 'blur'
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
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    this.renderSubItems();
    this.addSubItemView.render();
    return this;
  },

  renderSubItems: function() {
    var subItemHTML = this.$el.find('.sub-items');
    subItemHTML.append( this.subItemsView.render().el );
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
      this.$inputs.first().focus();      // Set cursor at the first input feld
      this.showSubitems(false);          // Show subitems
  },

  stopEdit: function() {
      this.$el.find('h3, p').show();
      this.$inputs.addClass('hide');
      this.renderSubItems();
  },

  showSubitems: function(togle) {
    if (togle)
      $(this.el).find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function() {
    $(this.el).find('.sub-items').slideUp("slow");
  },

  showDeleteConfirm: function() {
    console.log('showDeleteConfirm');
  }
});
