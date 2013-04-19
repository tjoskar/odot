App = Ember.Application.create({});

App.Store = DS.Store.extend({
  revision: 12,
  adapter: DS.RESTAdapter.extend({
    url: 'http://odot.dev/'
  })
});

App.Router.map(function() {
<<<<<<< HEAD
  
	this.resource('lists', function() {
    this.resource('list', { path: ':lists_id' });
    });
  //this.route("list", {path:"/list"});
=======
	this.resource('', function() {
		this.resource('tasks', { path: ':lists_id' });
	});
>>>>>>> Create item model
});

App.IndexRoute = Ember.Route.extend({
	model: function() {
		return App.List.find();
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
