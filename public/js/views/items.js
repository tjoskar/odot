/*=============================
=            Views            =
=============================*/

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  render: function() {
    var listid = this.collection.listID;
    this.collection.each(function(item) {
      item.listID = listid;
      var itemView = new App.Views.Item({ model: item });
      this.$el.append( itemView.render().$el );
    }, this);

    return this;
  },

  showAllItems: function() {
    $("#items-holder").empty(); //Empty the item list
    $("#items-holder").append( this.render().el );
  }

});