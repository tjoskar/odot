/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  initialize: function () {
    // When a model is add to the collection, add the model to this view as well
    this.collection.on("add", this.addItem, this);
    vent.on('item:uncompleted', this.addItem, this);
  },

  render: function() {
    this.$el.empty();
    this.collection.each(function(item) {
      var itemView = new App.Views.Item({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    // Lets make it sortable
    var that = this;
    this.$el.on(
      function()
      {
        $(this).sortable().bind('sortupdate', function() {
          var items = that.$el.find('h3');
          $.each(items, function(i) {
            var id = $(items[i]).data();
            var model = that.collection.get(id);
            model.set('order', i);
            model.save();
          });
        });
      }
    );

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