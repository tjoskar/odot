/*=============================
=            Views            =
=============================*/

App.Views.List = Backbone.View.extend({
  tagName: 'li',
  className: 'list',
  template: _.template("<%= title %>"),

  initialize: function() {
    vent.on('list:show', this.showList, this);
  },

  render: function() {
    //console.log('List render()');
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  //Add event to capture click on a list (<li>)
  events : {
    "click" : "listClicked"
  },

  listClicked: function(event) {
    var listUrl = this.model.urlRoot + '/' + this.model.id;
    app.router.navigate(listUrl, {trigger: true});
  },

  showList: function(listId) {
    if (listId == this.model.id)
    {
      var list = new App.Models.List( {id: listId} );
      list.fetch().then(function() {

        var itemCollection = new App.Collections.Item();
        var items = list.getItems();
        for( var key in items )
        {
          itemCollection.add( items[key] );
        }
        itemCollection.listID = listId;
        var itemsView = new App.Views.Items({ collection: itemCollection });
        itemsView.showAllItems();
      });

      //Store the view id
      app.saveLastViewedListId(this.model.id);
    }
  }
});