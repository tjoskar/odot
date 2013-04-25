/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.Item = Backbone.Model.extend({
  defaults: {
    title: ''
  }
});

App.Collections.Item = Backbone.Collection.extend({
  model: App.Models.Item
});