/*=============================
=            Views            =
=============================*/

App.Views.List = Backbone.View.extend({
  tagName: 'li',
  className: 'list',
  template: _.template("<p data-id='<%= id %>'><%= title %></p>"),

  initialize: function() {
    vent.on('list:show', this.showList, this);
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  // Add event to capture click on a list (<li>)
  events : {
    "click" : "listClicked"
  },

  listClicked: function(e) {
    // Router user to a single list
    var listUrl = this.model.urlRoot + '/' + this.model.id;
    app.router.navigate(listUrl, {trigger: true});
  },

  showList: function(listId) {
    // When the user clicks on a list, all list-view instance will get this function call
    if (listId == this.model.id)                              // Check if the call was ment for this instance
    {
      var list = new App.Models.List( {id: listId} );
      list.fetch().then(function() {

        var itemCollection     = new App.Collections.Item();
        var compItemCollection = new App.Collections.Item();
        var items = list.getItems();

        for( var key in items )
        {
          if (items[key].completed == '0')        // Uncompleted item
          {
            itemCollection.add( items[key] );
          }
          else
          {
            compItemCollection.add( items[key] );
          }
        }

        app.itemsView = new App.Views.Items({ collection: itemCollection });
        compItemsView = new App.Views.CompletedItems({ collection: compItemCollection });

        app.itemsView.showAllItems();
        compItemsView.showAllItems();
      });

      //Store the view id
      app.saveLastViewedListId(this.model.id);
    }
  }
});