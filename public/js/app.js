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

  validate: function(arg) {
    if (!arg.title) {
      return 'ERROR';
    }
  },

  getTitle: function() {
    return 'title: ' + this.get('title');
  }
});

App.Views.List = Backbone.View.extend({
  tagName: 'li',
  className: 'list',
  template: _.template("<%= title %>"),

  render: function() {
    this.$el.html( this.template( this.model.toJSON() ));
    return this;
  }
});

App.Views.Lists = Backbone.View.extend({
  tagName: 'ul',

  initialize: function() {
    vent.on('lists:show', this.showAllLists, this);
    vent.on('list:show', this.showList, this);
  },

  render: function() {
    this.collection.each(function(list) {
      var listView = new App.Views.List({ model: list });
      this.$el.append( listView.render().$el );
    }, this);

    return this;
  },

  showAllLists: function() {
    $("#list-holder").append( this.render().el );
  },

  showList: function(id) {
    var list = this.collection.get(id);
    console.log(list);
    var listView = new App.Views.List({ model: list });

    $(document.body).append( listView.render().el );
  }
});

App.Collections.List = Backbone.Collection.extend({
  model: App.Models.List,
  url: '/lists'
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
