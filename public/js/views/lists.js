/*=============================
=            Views            =
=============================*/

App.Views.Lists = Backbone.View.extend({
  tagName: 'ul',

  initialize: function() {
    // Wait for the call
    vent.on('lists:show', this.showAllLists, this);
  },

  render: function() {
    this.$el.empty();
    this.collection.each(function(list) {
      var listView = new App.Views.List({ model: list });
      this.$el.append( listView.render().$el );
    }, this);
    return this;
  },

  showAllLists: function() {
    $("#lists-holder").append( this.render().el );
  }
});