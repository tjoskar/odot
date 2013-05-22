/*================================================
=            Subitem Model/Collection            =
================================================*/

App.Models.SubItem = Backbone.Model.extend({
  defaults: {
    title: '',
    completed: 0
  },

  urlRoot: '/subitem',

  validate: function(arg)
  {
    if (!arg.title)                                                             // Simpel check to see if 'title' has a value
    {
      return 'Invalid title';
    }
  },

  toogleCompleted: function()
  {
    var setCompleted = (this.get('completed') == 1) ? 0 : 1;
    this.set('completed', setCompleted);
  },

  sync: function(method, model, options)                                        // Overwrite sync if we have a websocket connection
  {
    if (method === 'create' || method === 'delete' || method === 'update')      // Only overwrite if there is a create, delete or update method
    {
      var msg = {'object': 'subItem', 'method': method, 'args': model};         // Create a custom message
      if (app.socketConn)
      {
        app.socketConn.send(JSON.stringify(msg));                               // And of we go
        return true;
      }
    }

    return Backbone.sync(method, model, options);                               // Use backbones ordinary sync
  }
});

App.Collections.SubItem = Backbone.Collection.extend({
  model: App.Models.SubItem
});
