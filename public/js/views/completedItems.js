/*=============================
=            Views            =
=============================*/

App.Views.CompletedItems = Backbone.View.extend({
  tagName: 'ul',

  initialize: function ()
  {
    vent.on('item:completed', this.addItem, this);                    // An item has markt as completed in items.js
    //vent.on('item:update', this.updateItem, this);                    // This event is trigged by the websocket-server when an item should be updated
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

  // addItem: function(item)                                             // Add an item to the view
  // {
  //   var itemModel = new App.Models.Item(item);
  //   var itemView = new App.Views.CompletedItem({ model: itemModel });
  //   this.$el.append( itemView.render().$el );
  // },

  addItem: function(item)                                                           // Add a new item to the view
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

  // updateItem: function(model)
  // {
  //   item = this.collection.get(model.id);
  //   if (!_.isUndefined(item))
  //   {
  //     if (item.get('completed') != model.completed)
  //     {
  //       var cp = item.clone();
  //       cp.set(model);
  //       vent.trigger('item:uncompleted', cp);                       // Send an event to items.js
  //       item.destroy({reportToServer: false});                        // The item should only be removed from this view, not from the server DB
  //     }
  //   }
  // },

  showAllItems: function()                                            // Show them all
  {
    $("#completed-items-holder").html( this.render().el );
  }

});
