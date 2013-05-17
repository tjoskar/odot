/*=============================
=            Views            =
=============================*/

App.Views.List = Backbone.View.extend({
  tagName: 'li',
  className: 'list',
  template: _.template($('#list-template').html()),

  initialize: function() {
    vent.on('list:show', this.showList, this);

    /*
    if ( this.model.id == 34 )
    {
      app.popup = new App.Views.SharePopup(this.model);
      app.popup.show();
    }
  */
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  // Add event to capture click on a list (<li>)
  events : {
    'click'             : 'clickList',
    'mouseenter'        : 'mouseEnter',
    'mouseleave'        : 'mouseLeave',
    'click .icon-group' : 'clickShare',
    'click .icon-trash' : 'clickDelete',
  },

  clickList: function(e) {
    // Router user to a single list
    var listUrl = this.model.urlRoot + '/' + this.model.id;
    app.router.navigate(listUrl, {trigger: true});
  },
  mouseEnter: function(e) {
    this.$el.find('.list-button-holder').removeClass('hide');
  },
  mouseLeave: function(e) {
    this.$el.find('.list-button-holder').addClass('hide');
  },
  clickShare: function(e) {
    app.popup = new App.Views.SharePopup(this.model);
    app.popup.show();
  },
  clickDelete: function(e) {
    
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
          if (items[key].completed == '0')                    // Uncompleted item
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

      this.$el.addClass('active');
    }
    else 
    {
      this.$el.removeClass('active');
    }
  }
});



