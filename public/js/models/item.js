/*=============================================
=            Item Model/Collection            =
=============================================*/

App.Models.Item = Backbone.Model.extend({
  defaults: {
    title: '',
    completed: 0,
    order: 0,
    due_date: ''
  },

  urlRoot: '/item',

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
  },

  sync: function(method, model, options)                                        // Overwrite sync if we have a websocket connection
  {
    if (method === 'create' || method === 'delete' || method === 'update')      // Only overwrite if there is a create, delete or update method
    {
      if (!_.isUndefined(options.reportToServer) && options.reportToServer === false)
      {
        return true;
      }

      var msg = {'method': method+'Item', 'args': model};                     // Create a custom message
      if (app.socketConn)
      {
        app.socketConn.send(JSON.stringify(msg));                             // And of we go
        return true;
      }
    }

    return Backbone.sync(method, model, options);                               // Use backbones ordinary sync
  }
});

// Items collection
App.Collections.Item = Backbone.Collection.extend({
  model: App.Models.Item,

  initialize: function()
  {
    var self = this;
  },

  comparator: function(model)                                                   // Sort item after 'order'-property
  {
    return model.get('order');
  }
});
