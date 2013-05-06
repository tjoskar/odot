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
  listsView: {},
  itemsView: null,

  saveLastViewedListId: function (listId) {
    localStorage.lastViewedListId = listId;
  },

  alert: function(msg, type)
  {
    var model = new App.Models.Alert({msg: msg, type: type});
    new App.Views.Alert(model);
  }
};
