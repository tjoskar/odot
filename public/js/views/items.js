/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  initialize: function () {
    // When a model is add to the collection, add the model to this view as well
    this.collection.on("add", this.addItem, this);
    //this.collection.on("remove", this.removeItem, this);
    vent.on('item:uncompleted', this.addItem, this);
  },

  render: function() {
    this.$el.empty();
    this.collection.each(function(item) {
      var itemView = new App.Views.Item({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    // Lets make it sortable
    this.makeItemSortable();

    return this;
  },

  makeItemSortable: function() {
    var that = this;
    this.$el.sortable().bind('sortupdate', function() {
      var items = that.$el.find('h3');
      $.each(items, function(i) {
        var id = $(items[i]).data();
        var model = that.collection.get(id);
        model.set('order', i);
        model.save();
      });
    });
  },

  // Add a item to the view
  addItem: function(item) {
    var itemView = new App.Views.Item({ model: item });
    this.$el.append( itemView.render().$el );

    // Lets make it sortable
    this.$el.sortable();
  },

  // removeItem: function(item) {
  //   d('removeItem');
  //   item.destroy();
  // },

  // Show them all
  showAllItems: function() {
    $("#items-holder").html( this.render().el );
  }

});