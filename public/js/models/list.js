/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.List = Backbone.Model.extend({
  defaults: {
    title: '',
    user_id: '',
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
  url: '/list'
});