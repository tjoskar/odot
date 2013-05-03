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
  }
};

var vent = _.extend({}, Backbone.Events);

var d = function(msg) {
  console.log(msg);
};
