/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.SubItem = Backbone.Model.extend({
  defaults: {
    title: '',
    completed: 0
  },

  urlRoot: '/subitem',

  validate: function(arg) {
    if (!arg.title) {
      return 'Invalid title';
    }
  },

  toogleCompleted: function() {
    var setCompleted = (this.get('completed') == 1) ? 0 : 1;
    this.set('completed', setCompleted);
  }
});

App.Collections.SubItem = Backbone.Collection.extend({
  model: App.Models.SubItem
});