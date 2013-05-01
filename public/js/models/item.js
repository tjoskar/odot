/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.Item = Backbone.Model.extend({
  defaults: {
    title: ''
  },

  urlRoot: '/item',

  validate: function(arg) {
    if (!arg.title) {
      return 'Invalid title';
    }
  }
});

App.Collections.Item = Backbone.Collection.extend({
  model: App.Models.Item
});