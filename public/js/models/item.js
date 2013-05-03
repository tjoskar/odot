/*==========================================
=            Models/Collections            =
==========================================*/

App.Models.Item = Backbone.Model.extend({
  defaults: {
    title: '',
    complete: 0
  },

  urlRoot: '/item',

  validate: function(arg)
  {
    if (!arg.title)
    {
      return 'Invalid title';
    }
  },

  toogleComplete: function() {
    var setComplete = (this.get('complete') == 1) ? 0 : 1;
    this.set('complete', setComplete);
  },

  getSubItems: function()
  {
    if (typeof(this.get('sub_items')) != "undefined")
    {
      return this.get('sub_items');
    }
    else
    {
      return {};
    }
  }
});

App.Collections.Item = Backbone.Collection.extend({
  model: App.Models.Item
});