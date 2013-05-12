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

  // sync: function(method, model, options)
  // {
  //   d(method);
  //   if(method === 'create')
  //   {
  //     if (conn)
  //     {
  //       var data = {'method': 'createList', 'args': model};
  //       conn.send(JSON.stringify(data));
  //       return true;
  //     }
  //     else
  //     {
  //       return Backbone.sync(method, model, options);
  //     }
  //   }
  //   else
  //   {
  //     return Backbone.sync(method, model, options);
  //   }

  // }
});

App.Collections.List = Backbone.Collection.extend({
  model: App.Models.List,
  url: '/list',

  comparator: function(model) {
    return model.get('order');
  }
});