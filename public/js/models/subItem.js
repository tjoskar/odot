/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.SubItem = Backbone.Model.extend({
  defaults: {
    title: ''
  },

  urlRoot: '/subitem',

  validate: function(arg) {
    if (!arg.title) {
      return 'Invalid title';
    }
  }
});

App.Collections.SubItem = Backbone.Collection.extend({
  model: App.Models.SubItem
});