/*============================================
=            List Moel/Collection            =
============================================*/

App.Models.List = Backbone.Model.extend({
  defaults: {
    title: '',
    user_id: '',
    order: 0
  },

  urlRoot: '/list',

  validate: function(arg)
  {
    if (!arg.title)
    {
      return 'Invalid title';
    }
  },

  getItems: function()
  {
    return this.get('items');
  }
});

// Lists collection
App.Collections.List = Backbone.Collection.extend({
  model: App.Models.List,
  url: '/list',

  comparator: function(model) {
    return model.get('order');
  }
});