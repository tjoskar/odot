/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  initialize: function ()
  {
    this.collection.on("add", this.addItem, this);                                  // When a model is added to the collection, add the model to this view as well
    //this.collection.on("remove", this.removeItem, this);
    vent.on('item:uncompleted', this.uncompletedItem, this);                                // Listen after an item to be uncompleted
    //vent.on('item:update', this.updateItem, this);                                  // This event is trigged by the websocket-server when an item should be updated
  },

  render: function()
  {
    this.$el.empty();
    this.collection.each(function(item) {
      var itemView = new App.Views.Item({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    // Lets make it sortable
    this.makeItemSortable();

    return this;
  },

  makeItemSortable: function()
  {
    var that = this;
    this.$el.sortable().bind('sortupdate', function() {                             // This anonymous function will run when the drop an item
      var items = that.$el.find('h3');
      $.each(items, function(i) {                                                   // Loop through all items and save them
        var id = $(items[i]).data();
        var model = that.collection.get(id);
        if (model.get('order') != i)
        {
          model.set('order', i);
          model.save();
        }
      });
    });
  },

  addItem: function(item)                                                           // Add a new item to the view
  {
    var itemView = new App.Views.Item({ model: item });
    this.$el.append( itemView.render().$el );

    // Lets make it sortable
    this.$el.sortable();
  },

  uncompletedItem: function(item) {
    var itemModel = new App.Models.Item(item);
    this.collection.add(itemModel);
  },

  // updateItem: function(model)                                                       // Called by the server
  // {
  //   item = this.collection.get(model.id);                                           // Check if we own the item to be updated
  //   if (!_.isUndefined(item))
  //   {
  //     if (item.get('completed') != model.completed)                                 // Has it been marked as completed?
  //     {
  //       var cp = item.clone();
  //       cp.set(model);                                                            // Update the item
  //       vent.trigger('item:completed', cp);                                       // Tell complettedItems.js that the item now is completed
  //       item.destroy({reportToServer: false});                                      // Remove the item, and do it quiet
  //     }
  //     else
  //     {
  //       item.set(model);                                                            // We keep the item but we update it, sort the collection and re-Render the list
  //       this.collection.sort();
  //       this.render();
  //     }
  //   }
  // },

  showAllItems: function()                                                          // Show them all
  {
    $("#items-holder").html( this.render().el );
  }

});
