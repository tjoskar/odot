/*
GET /lists => all lists
GET /list/:id => en lista and alla items
POST/DELETE /list:id => skapar/tarbort lista
 
POST /item/id => skapar item
DELETE /item/id => tarbort item
*/

/**
    TODO:
    - Move out Models, Views, Controller.. to separate files
    - Move out the template for item view
**/



/*=====================================================
=            Initialisation of Applecation            =
=====================================================*/
var App = {
  Models: {},
  Collections: {},
  Views: {},
  Router: {},
  ListsView: {}
};

var vent = _.extend({}, Backbone.Events);


/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.List = Backbone.Model.extend({
  defaults: {
    title: '',
    owner: '',
    order: 0
  },

  urlRoot: '/list',

  validate: function(arg) {
    if (!arg.title) {
      return 'Invalid title';
    }
  },

  getItems: function() {
    return this.get('items');
  }
});

App.Collections.List = Backbone.Collection.extend({
  model: App.Models.List,
  url: '/lists'
});

App.Models.Item = Backbone.Model.extend({
  defaults: {
    title: ''
  }
});

App.Collections.Item = Backbone.Collection.extend({
  model: App.Models.Item
});


/*=============================
=            Views            =
=============================*/

App.Views.List = Backbone.View.extend({
  tagName: 'li',
  className: 'list',
  template: _.template("<%= title %>"),

  render: function() {
    console.log('List render()');
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  //Add event to capture click on a list (<li>)
  events : {
    "click" : "listClicked"
  },

  listClicked: function(event) {
    
    var listUrl = this.model.urlRoot + '/' + this.model.id;
    appRouter.navigate(listUrl, {trigger: true});
    
    
    var list = new App.Models.List( {id: this.model.id} );
    list.fetch().then(function() {

      var itemCollection = new App.Collections.Item();
      var items = list.getItems();
      for( var key in items )
      {
        itemCollection.add( items[key] );
      }
      var itemsView = new App.Views.Items({ collection: itemCollection });
      //appRouter.navigate('/list/' + modelId, true);
      itemsView.showAllItems();
    });
    
    //console.log(list.fetch());
  }
});

App.Views.Lists = Backbone.View.extend({
  tagName: 'ul',

  initialize: function() {
    vent.on('lists:show', this.showAllLists, this);
    //vent.on('list:show', this.showList, this);
  },

  render: function() {
    this.$el.empty();
    this.collection.each(function(list) {
      var listView = new App.Views.List({ model: list });
      this.$el.append( listView.render().$el );
    }, this);
    return this;
  },

  showAllLists: function() {
    $("#lists-holder").append( this.render().el );
  }
});

App.Views.SubItem = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#subItem-template').html()),

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  }
});

App.Views.SubItems = Backbone.View.extend({
  tagName: 'ul',

  render: function() {
    this.collection.each(function(subItem) {
      var subItemView = new App.Views.SubItem({ model: subItem });
      this.$el.append( subItemView.render().$el );
    }, this);

    return this;
  }
});

App.Views.Item = Backbone.View.extend({
  tagName: 'li',
  template: _.template($('#item-template').html()),

  clicks: 0,
  DELAY: 200,
  timer: null,
  subItemsCollection: null,
  subItemsView: null,

  initialize: function(){
    var subItems = this.model.get('sub_items');
    this.subItemsCollection = new App.Collections.Item();
    for(var key in subItems)
    {
      var subItemModel = new App.Models.Item(subItems[key]);
      this.subItemsCollection.add(subItemModel);
    }
    this.subItemsView = new App.Views.SubItems({ collection: this.subItemsCollection });
  },

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    this.$el.find('.sub-items').html( this.subItemsView.render().el );
    this.$input = this.$el.find('input');
    return this;
  },

  events : {
    'click h3' : 'itemClick',
    'click .icon-cog' : 'showItemSettings'
  },

  itemClick: function() {
    this.clicks++;

    var that = this;

    if (this.clicks == 1)
    {
      this.timer = setTimeout(function() {
        that.showSubitems(true);
        console.log('Singel');
        that.clicks = 0;
      }, this.DELAY);
    }
    else
    {
      clearTimeout(this.timer);
      this.clicks = 0;
      this.edit();
      console.log('Double2');
    }
  },

  edit: function() {
      this.$input.removeClass('hide');
      this.$el.find('h3, p').hide();
      this.$input.focus();
      this.showSubitems(false);
  },

  showSubitems: function(togle) {
    $(this.el).find('.item-settings').slideUp("slow");
    if (togle)
      $(this.el).find('.sub-items').slideToggle("slow");
    else
      $(this.el).find('.sub-items').slideDown("slow");
  },

  hideSubitems: function() {
    $(this.el).find('.item-settings').slideUp("slow");
    $(this.el).find('.sub-items').slideUp("slow");
  },

  showItemSettings: function() {
    $(this.el).find('.sub-items').slideUp("slow");
    $(this.el).find('.item-settings').slideToggle("slow");
  }
});

App.Views.Items = Backbone.View.extend({
  tagName: 'ul',

  render: function() {
    //console.log(this.collection);
    this.collection.each(function(item) {
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

//View to handle the "add list" input form
App.Views.AddListForm = Backbone.View.extend({
  el: $('form.add-list'),

  events: {
    "submit" : "addNewList"
  },

  addNewList: function(event) {
    event.preventDefault();
    var inputField = $(this.el).find('input');
    var enteredText = inputField.val().trim();
    var newList = new App.Models.List({title: enteredText});
    
    if (newList.isValid()) {
      App.ListsView.collection.add(newList); //Add new list to collection
      newList.save().then(function() {
        //newList.id;
        App.ListsView.showAllLists(); //Re-render lists
        inputField.val(''); //Clear input field
      });
    }
  },

  initialize: function() {
    //console.log("initialize addListForm");
  }
});


/*===============================
=            Routers            =
===============================*/

App.Router = Backbone.Router.extend({
  routes: {
    '': 'index',
    'list/:id': 'list',
    'lists': 'lists'
  },

  index: function() {
    appRouter.navigate("/lists", true);
  },

  list: function(id) {
    id = (typeof id !== 'undefined') ? id : 0;

    if (id > 0)
      vent.trigger('list:show', id);
    else
      alert('404');
  },

  lists: function() {
    App.lists = new App.Collections.List();
    App.lists.fetch().then(function() {
      App.ListsView = new App.Views.Lists({ collection: App.lists });
      App.ListsView.showAllLists();
    });
    //vent.trigger('lists:show');
  }
});

var appRouter = new App.Router();
Backbone.history.start();
new App.Views.AddListForm();
