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

  initialize: function(){
    this.addSubItemView = new App.Views.AddSubItemsForm({ model: {parentEl: this.$el} });      // Create a form to add sub items

    var subItems = this.model.get('sub_items');                 // Get all sub items from the model
    this.subItemsCollection = new App.Collections.Item();       // Create a collection for the sub items
    for(var key in subItems)
    {
      var subItemModel = new App.Models.Item(subItems[key]);
      this.subItemsCollection.add(subItemModel);
    }
    this.subItemsView = new App.Views.SubItems({ collection: this.subItemsCollection });
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    this.$el.find('.sub-items').prepend( this.subItemsView.render().el );
    this.addSubItemView.render();
    this.$input = this.$el.find('input');
    return this;
  },

  events : {
    'click h3' : 'itemClick',
    'click .icon-cog' : 'showDeleteConfirm',
    'blur input' : 'blur'
  },

  blur: function() {
    var that = this;
    this.$input = this.$el.find('input');

    setTimeout(function() {
      var focus = false;
        that.$input.each(function() {
          if ($(this).is(':focus'))
          {
            focus = true;
            return;
          }
        });
        if (!focus)
        {
          that.$el.find('h3, p').show();
          that.$input.addClass('hide');
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
      this.edit();
    }
  },

  edit: function() {
      this.$input = this.$el.find('input');
      this.$input.removeClass('hide');  // Show all inputs
      this.$el.find('h3, p').hide();    // Hide the actual text
      this.$input.first().focus();      // Set cursor at the first input feld
      this.showSubitems(false);         // Show subitems
  },

  showSubitems: function(togle) {
    if (togle)
      $(this.el).find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function() {
    $(this.el).find('.item-settings').slideUp("slow");
    $(this.el).find('.sub-items').slideUp("slow");
  },

  showDeleteConfirm: function() {
    console.log('showDeleteConfirm');
  }
});