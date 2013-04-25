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

  initialize: function(){
    var subItems = this.model.get('sub_items');
    this.subItemsCollection = new App.Collections.Item();
    for(var key in subItems)
    {
      var subItemModel = new App.Models.Item(subItems[key]);
      this.subItemsCollection.add(subItemModel);
    }
    this.subItemsView = new App.Views.SubItems({ collection: this.subItemsCollection });
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    this.$el.find('.sub-items').html( this.subItemsView.render().el );
    this.$input = this.$el.find('input');
    return this;
  },

  events : {
    'click h3' : 'itemClick',
    'click .icon-cog' : 'showItemSettings'
  },

  itemClick: function() {
    this.clicks++;

    var that = this;

    if (this.clicks == 1)
    {
      this.timer = setTimeout(function() {
        that.showSubitems(true);
        console.log('Singel');
        that.clicks = 0;
      }, this.DELAY);
    }
    else
    {
      clearTimeout(this.timer);
      this.clicks = 0;
      this.edit();
      console.log('Double2');
    }
  },

  edit: function() {
      this.$input.removeClass('hide');
      this.$el.find('h3, p').hide();
      this.$input.focus();
      this.showSubitems(false);
  },

  showSubitems: function(togle) {
    $(this.el).find('.item-settings').slideUp("slow");
    if (togle)
      $(this.el).find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function() {
    $(this.el).find('.item-settings').slideUp("slow");
    $(this.el).find('.sub-items').slideUp("slow");
  },

  showItemSettings: function() {
    $(this.el).find('.sub-items').slideUp("slow");
    $(this.el).find('.item-settings').slideToggle("slow");
  }
});