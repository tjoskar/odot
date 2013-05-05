/*=============================
=            Views            =
=============================*/

App.Views.CompletedItem = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#completed-item-template').html()),

  events : {
    'mouseenter .item-checkbox-holder' : 'hoverCheckbox',
    'mouseleave .item-checkbox-holder' : 'hoverCheckbox',
    'click .item-checkbox-holder'      : 'clickCheckbox'
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  hoverCheckbox: function(e) {
    $(e.currentTarget).find('.icon-check-empty, .icon-check').toggleClass('hide');
  },

  clickCheckbox: function(e) {
    this.model.toogleCompleted();
    this.model.save();
    vent.trigger('item:uncompleted', this.model);
    this.remove();
  }
});
