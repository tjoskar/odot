/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  initialize: function () {
    this.collection.on("add", this.addItem, this);
  },

  render: function() {
    var listid = this.collection.listID;
    this.collection.each(function(item) {
      item.listID = listid;
      var itemView = new App.Views.Item({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    return this;
  },

  addItem: function(item) {
    var itemView = new App.Views.Item({ model: item });
    this.$el.append( itemView.render().$el );
  },

  showAllItems: function() {
    $("#items-holder").empty(); //Empty the item list
    $("#items-holder").append( this.render().el );
  }

});