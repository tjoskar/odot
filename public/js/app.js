var App = {
  Models: {},
  Collections: {},
  Views: {},
  Router: {}
};

var vent = _.extend({}, Backbone.Events);

App.Models.List = Backbone.Model.extend({
  defaults: {
    title: 'No title'
  },

  urlRoot: '/list',

  validate: function(arg) {
    if (!arg.title) {
      return 'ERROR';
    }
  },

  getTitle: function() {
    return 'title: ' + this.get('title');
  }
});

App.Collections.List = Backbone.Collection.extend({
  model: App.Models.List,
  url: '/lists'
});

App.Views.List = Backbone.View.extend({
  tagName: 'li',
  className: 'list',
  template: _.template("<%= title %>"),

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  },

  //Add event to capture click on a list (<li>)
  events : {
    "click" : "listClicked"
  },
  listClicked: function(event) {
    var listId = this.model.id;
    var list = new App.Models.List( {id: listId} );
    list.fetch();
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
    //console.log(this.collection);
    this.collection.each(function(list) {
      var listView = new App.Views.List({ model: list });
      this.$el.append( listView.render().$el );
    }, this);
    return this;
  },

  showAllLists: function() {
    $("#lists-holder").append( this.render().el );
  },

  showList: function(id) {

    var list = this.collection.get(id);
    console.log(list);
    var listView = new App.Views.List({ model: list });
    $(document.body).append( listView.render().el );
  }
});

//View to handle the "add list" input form
App.Views.AddListForm = Backbone.View.extend({
  el: $('#add-list-holder'),
  events: {
    "submit .add-list" : "addNewList"
  },
  addNewList: function(event) {
    event.preventDefault();
    console.log("HEJ");
  },
  initialize: function() {
    console.log("initialize addListForm");
  }
});

App.Router = Backbone.Router.extend({
  routes: {
    '': 'index',
    'list/:id': 'list',
    'lists': 'lists'
  },
  index: function() {
    //$(document.body).append('index');
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
    var lists = new App.Collections.List();
    lists.fetch().then(function() {
      var listsView = new App.Views.Lists({ collection: lists });
      listsView.showAllLists();
    });
    //vent.trigger('lists:show');
  }
});

var appRouter = new App.Router();
Backbone.history.start();
new App.Views.AddListForm();
