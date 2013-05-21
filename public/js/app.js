/*=====================================================
=            Initialisation of Application            =
=====================================================*/

var App = {
  Models: {},
  Collections: {},
  Views: {},
  Router: {}
};

var app = {
  router: {},
  listsView: null,
  itemsView: null,
  conn: false,

  saveLastViewedListId: function (listId)
  {
    localStorage.lastViewedListId = listId;
  },

  alert: function(msg, type, timeout)
  {
    //var t = timeout || 3000;
    var model = new App.Models.Alert({msg: msg, type: type, timeout: timeout});
    new App.Views.Alert({model: model});
  }
};
