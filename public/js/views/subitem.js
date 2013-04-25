/*=============================
=            Views            =
=============================*/

App.Views.SubItem = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#subItem-template').html()),

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  }
});