App = Ember.Application.create({});


/*
* STORE 
*/
App.Store = DS.Store.extend({
  revision: 12,
  adapter: DS.RESTAdapter.extend({
    url: 'http://odot.dev'
  })
});


/*
*  Routers
*/
// App.Router.reopen({
//  location: 'history'
// });

App.Router.map(function() {
  this.resource('lists', function() {
    this.resource('list', { path: ':list_id' });
  });
});

App.IndexRoute = Ember.Route.extend({
  redirect: function() {
    this.transitionTo('lists');
  }
});

App.ListsRoute = Ember.Route.extend({
  model: function() {
    var lists = App.List.find();
    console.log(lists);
    return lists;
  }
});

/*
App.ListRoute = Ember.Route.extend({
  model: function(arg) {
    console.log('App.ListRoute.model 1');
    return App.Item.find(arg.list_id);
  }
});
*/


/*
*  Models
*/
App.List = DS.Model.extend({
  title: DS.attr('string'),
  owner: DS.attr('string'),
  items: DS.hasMany('App.Item')
});

App.Item = DS.Model.extend({
  title: DS.attr('string'),
  list: DS.belongsTo('App.List')
});

// Code from: http://jsfiddle.net/cteegarden/TULVH/5/
App.ListTest = Ember.Object.extend({});
App.ListTest.reopenClass({
  find: function(id) {
    var arr = [
      ['10','hej10'],
      ['16','hej16']
    ];
    var obj = {
        0: {
          'id': '10',
          'title': 'hej10'
        },
        1: {
          'id' : '16',
          'title' : 'hej16'
        }};
    //return arr; // Inga problem att iterera över en array
    return App.Item.find(id);
  }
});

App.ListRoute = Ember.Route.extend({
  model: function(params) {
    console.log('ListRoute.model');
    return {id: params.list_id};
  },
  setupController: function(controller, model) {
    console.log('Get items for list: ' + model.id);
    var lists = App.List.find();
    var list = lists.objectAt(model.id-1); // 'lists' is an array so we can only use model.id iff lists.id starts at 0 och is continuous
    var list_model = list.get('items');
    window.oskar = list_model;
    //var list_model = App.List.find(); //App.ListTest.find(model.id);
    console.log(list_model);
    controller.set("content", list_model);
  }
});

/*

Kommentar:
Jag tror att ovanstående approach är fel.
Just nu hämtas alla listor, sedan anroppas /items/id där id är list id. 
Jag tror snanare att adressen /lists/id skall anroppas som ger tillbaka
en lista med items (tasks). 

Så responsen blir något i stil med:

/lists
{
  lists: [
    {
      id: 1,
      title: 'First list'
    },
    {
      id: 2,
      title: 'Second list'
    },
    ...
  ]
} 

/lists/2
{
  list: [
    {
      id: 2,
      title: 'Second list',
      items: [
        {
          id: 1,
          titel: 'first',
        },
        {
          id: 2,
          title: 'second'
        },
        ...
      ]
    }
  ]
}


Alt.
Kanske man kan göra enligt att skapa någon relation mellan list och item (http://emberjs.com/guides/models/the-rest-adapter/)

/lists
{
  lists: [
    {
      id: 1,
      title: 'First list'
      item_ids: [1, 2, 3] 
    },
    {
      id: 2,
      title: 'Second list'
      item_ids: [4, 5, 6]
    },
    ...
  ]
} 

/items?ids[]=1&ids[]=2&ids[]=3
{
  items: [
    {
      id: 1,
      title: 'first',
      list_id: 1
    },
    {
      id: 2,
      title: 'first',
      list_id: 1
    },
    {
      id: 3,
      title: 'first',
      list_id: 1
    }
  ]
}



*/
