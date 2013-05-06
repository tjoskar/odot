/*=============================
=            Views            =
=============================*/

App.Views.Lists = Backbone.View.extend({
  tagName: 'ul',

  initialize: function() {
    // Wait for the call
    vent.on('lists:show', this.showAllLists, this);
  },

  render: function() {
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

  showAllLists: function() {
    $("#lists-holder").append( this.render().el );
  }
});