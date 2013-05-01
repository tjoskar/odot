/*=============================
=            Views            =
=============================*/

App.Views.SubItem = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#subItem-template').html()),

  initialize: function () {
    this.model.on("change:title", this.render, this);
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  }
});