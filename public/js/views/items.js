/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  initialize: function () {
    // When a model is add to the collection, add the model to this view as well
    this.collection.on("add", this.addItem, this);
  },

  render: function() {
    this.$el.empty();
    this.collection.each(function(item) {
      var itemView = new App.Views.Item({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    return this;
  },

  // Add a item to the view
  addItem: function(item) {
    var itemView = new App.Views.Item({ model: item });
    this.$el.append( itemView.render().$el );
  },

  // Show them all
  showAllItems: function() {
    $("#items-holder").append( this.render().el );
  }

});