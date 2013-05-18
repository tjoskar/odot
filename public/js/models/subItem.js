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
    if (!arg.title)
    {
      return 'Invalid title';
    }
  },

  toogleCompleted: function()
  {
    var setCompleted = (this.get('completed') == 1) ? 0 : 1;
    this.set('completed', setCompleted);
  },

  sync: function(method, model, options)
  {
    if (method === 'create' || method === 'delete' || method === 'update')
    {
      var msg = {'method': method+'SubItem', 'args': model};
      if (app.socketConn)
      {
        app.socketConn.send(JSON.stringify(msg));
        return true;
      }
    }

    return Backbone.sync(method, model, options);
  }
});

App.Collections.SubItem = Backbone.Collection.extend({
  model: App.Models.SubItem
});
