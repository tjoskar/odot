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
  popup: null,

  saveLastViewedListId: function (listId)
  {
    localStorage.lastViewedListId = listId;
  },

  removeLastViewedListId: function()
  {
    localStorage.removeItem('lastViewedListId');
  },

  alert: function(msg, type, timeout)
  {
    //var t = timeout || 3000;
    var model = new App.Models.Alert({msg: msg, type: type, timeout: timeout});
    new App.Views.Alert({model: model});
  }
};
