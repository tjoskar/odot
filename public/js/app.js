/*
GET /lists => all lists
GET /list/:id => en lista and alla items
POST/DELETE /list:id => skapar/tarbort lista
 
POST /item/id => skapar item
DELETE /item/id => tarbort item
*/

/**
    TODO: finish it.
**/



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
  listCollection: {},

  saveLastViewedListId: function (listId) {
    localStorage.lastViewedListId = listId;
  }
};

var vent = _.extend({}, Backbone.Events);

var d = function(msg) {
  console.log(msg);
};
