/*===============================
=            Routes             =
===============================*/

App.Router = Backbone.Router.extend({
  routes: {
    '': 'index',
    'list/:id': 'list',
    'lists': 'lists'
  },

  index: function() {

    console.log('Route index');
    //Go to last visited list      
    var lastViewedListId = getLastVisitedListId();
    if (0 < lastViewedListId) {
      var lastViewedList = app.listsView.collection.get(lastViewedListId);
      var lastViewdUrl = lastViewedList.urlRoot + '/' + lastViewedListId;
      app.router.navigate(lastViewdUrl, {trigger: true});
    } else {
      console.log('No previously viewed list id stored');
    }
  },

  list: function(id) {
    console.log('Route list');

    id = (typeof id !== 'undefined') ? id : 0;

    if (id > 0)
      vent.trigger('list:show', id);
    else
      alert('404');
  },

  lists: function() {
    
    //vent.trigger('lists:show');
  }
});

//Gets the id of the last visited list if still exists,
//else returns the first list if no stored list id
//or 0 if no lists
function getLastVisitedListId() {
  //Get local web storage
  if(typeof(Storage) !== "undefined") {
    if (typeof(localStorage.lastViewedListId) !== "undefined") {
      
      console.log('Local storage: Last viewed list id = ' + localStorage.lastViewedListId);
      
      //Return the last visited list id if list still exists
      var lastViewdList = app.listsView.collection.get(localStorage.lastViewedListId);
      if (typeof(lastViewdList) !== "undefined") {
        return localStorage.lastViewedListId;
      }
    } else {
      console.log('Local storage: No last viewed list id');
    }
  } else {
    //Local Web storage not supported
    console.log('Local Web storage not supported');
  }

  //Return the first list if at least one list exists
  if (app.listsView.collection.isEmpty() == false) {
    var firstListModel = app.listsView.collection.models[0];
    return firstListModel.id;
  } else {
    //No lists exist
    return 0;
  }
}