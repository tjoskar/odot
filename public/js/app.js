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
  socketConn: false,
  popup: null,

  saveLastViewedListId: function (listId)
  {
    //Store the list id of the last visited list, to get back where left off later
    localStorage.lastViewedListId = listId;
  },

  removeLastViewedListId: function()
  {
    //Clear the last visited list id
    localStorage.removeItem('lastViewedListId');
  },

  alert: function(msg, type, timeout)
  {
    //Alert for showing popup-like alerts
    var model = new App.Models.Alert({msg: msg, type: type, timeout: timeout});
    new App.Views.Alert({model: model});
  }
};
