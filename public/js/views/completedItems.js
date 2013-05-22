/*=============================
=            Views            =
=============================*/

App.Views.CompletedItems = Backbone.View.extend({
  tagName: 'ul',

  initialize: function ()
  {
    vent.on('item:completed', this.addItem, this);                    // An item has markt as completed in items.js
  },

  render: function()
  {
    this.$el.empty();
    this.collection.each(function(item) {
      var itemView = new App.Views.CompletedItem({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    return this;
  },

  addItem: function(item)                                             // Add a new item to the view
  {
    var itemModel = new App.Models.Item(item);
    var collection_length = this.collection.length;
    this.collection.add(itemModel);

    if (collection_length != this.collection.length)
    {
      var itemView = new App.Views.CompletedItem({ model: itemModel });
      this.$el.append( itemView.render().$el );
    }
  },

  showAllItems: function()                                            // Show them all
  {
    $("#completed-items-holder").html( this.render().el );
  }

});
