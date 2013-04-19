App = Ember.Application.create({});

App.Store = DS.Store.extend({
  revision: 12,
  adapter: DS.RESTAdapter.extend({
    url: 'http://odot.dev/'
  })
});

App.Router.map(function() {
  
	this.resource('lists', function() {
    this.resource('list', { path: ':lists_id' });
    });
  //this.route("list", {path:"/list"});
});

App.IndexRoute = Ember.Route.extend({
  redirect: function() {
    this.transitionTo('lists');
  }
});

App.ListsRoute = Ember.Route.extend({
  model: function() {
    return App.List.find();
  }
});

App.ListRoute = Ember.Route.extend({
  model: function() {
    return App.Task.find();
  }
});

App.List = DS.Model.extend({
  title: DS.attr('string'),
  owner: DS.attr('string')
  //id: DS.attr('id')
});

App.Task = DS.Model.extend({
  title: DS.attr('string')
});
