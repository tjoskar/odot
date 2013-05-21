/*=============================
=            Views            =
=============================*/

App.Views.Lists = Backbone.View.extend({
  tagName: 'ul',

  initialize: function()
  {
    // Wait for the call
    this.collection.on("add", this.addList, this);
    d('lyssna efter addListFromServer');
    vent.on('list:add', this.addListFromServer, this);
  },

  render: function()
  {
    d('render');
    this.$el.empty();
    this.collection.each(function(list) {
      var listView = new App.Views.List({ model: list });
      this.$el.append( listView.render().$el );
    }, this);

    // Lets make it sortable
    var that = this;
    this.$el.sortable().bind('sortupdate', function() {
      var lists = that.$el.find('p');
      $.each(lists, function(i) {
        var id = $(lists[i]).data('id');
        var model = that.collection.get(id);
        model.set('order', i);
        model.save();
      });
    });

    return this;
  },

  // Add a list to the view
  addList: function(model)
  {
    var listView = new App.Views.List({ model: model });
    this.$el.append( listView.render().$el );

    // Lets make it sortable
    this.$el.sortable();
  },

  addListFromServer: function(model)
  {
    var listModel = new App.Models.List(model);
    this.collection.add(listModel);
  },

  showAllLists: function()
  {
    $("#lists-holder").append( this.render().el );
  }
});
