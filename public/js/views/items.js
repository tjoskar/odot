/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  initialize: function ()
  {
    this.collection.on("add", this.addItem, this);                                  // When a model is added to the collection, add the model to this view as well
    vent.on('item:uncompleted', this.uncompletedItem, this);                        // Listen after an item to be uncompleted
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

    this.$el.sortable();                                                            // Lets make it sortable
  },

  uncompletedItem: function(item) {
    var itemModel = new App.Models.Item(item);
    this.collection.add(itemModel);
  },

  showAllItems: function()                                                          // Show them all
  {
    $("#items-holder").html( this.render().el );
  }

});
