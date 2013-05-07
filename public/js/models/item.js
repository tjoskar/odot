/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.Item = Backbone.Model.extend({
  defaults: {
    title: '',
    completed: 0,
    order: 0
  },

  urlRoot: '/item',

  validate: function(arg)
  {
    if (!arg.title)
    {
      return 'Invalid title';
    }
  },

  toogleCompleted: function() {
    var setCompleted = (this.get('completed') == 1) ? 0 : 1;
    this.set('completed', setCompleted);
  },

  getSubItems: function()
  {
    if (this.get('sub_items'))
    {
      return this.get('sub_items');
    }
    else
    {
      this.set('sub_items', {});
      return this.get('sub_items');
    }
  }
});

App.Collections.Item = Backbone.Collection.extend({
  model: App.Models.Item,

  comparator: function(model) {
    return model.get('order');
  }
});