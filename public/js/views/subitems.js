/*=============================
=            Views            =
=============================*/

App.Views.SubItems = Backbone.View.extend({
  tagName: 'ul',

  initialize: function()
  {
    // Wait for the call
    //this.collection.on("add", this.addSubItem, this);
  },

  render: function()
  {
    this.$el.empty();
    this.collection.each(function(subItem) {
      var subItemView = new App.Views.SubItem({ model: subItem });
      this.$el.append( subItemView.render().$el );
    }, this);

    return this;
  },

  addSubItem: function(model)                                            // Add a subitem to the view
  {
    var subItemView = new App.Views.SubItem({ model: model });
    this.$el.append( subItemView.render().$el );
  }
});