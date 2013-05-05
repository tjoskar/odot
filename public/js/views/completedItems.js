/*=============================
=            Views            =
=============================*/

App.Views.CompletedItems = Backbone.View.extend({
  tagName: 'ul',

  initialize: function () {
    vent.on('item:completed', this.addItem, this);
  },

  render: function() {
    this.$el.empty();
    this.collection.each(function(item) {
      var itemView = new App.Views.CompletedItem({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    return this;
  },

  // Add a item to the view
  addItem: function(item) {
    var itemView = new App.Views.CompletedItem({ model: item });
    this.$el.append( itemView.render().$el );
  },

  // Show them all
  showAllItems: function() {
    $("#completed-items-holder").append( this.render().el );
  }

});