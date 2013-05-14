/*===============================
=            Routes             =
===============================*/

App.Router = Backbone.Router.extend({
  routes: {
    '': 'index',
    'list/:id': 'list',
    'lists': 'lists'
  },

  index: function()
  {
    //Go to last visited list
    var lastViewedListId = getLastVisitedListId();

    if (0 < lastViewedListId)
    {
      var lastViewedList = app.listsView.collection.get(lastViewedListId);
      var lastViewdUrl = lastViewedList.urlRoot + '/' + lastViewedListId;
      app.router.navigate(lastViewdUrl, {trigger: true});
    }
    else // No previously viewed list id stored
    {
      //alert('No previously viewed list id stored');
      console.log('No previously viewed list id stored');
    }
  },

  list: function(id)
  {
    id = (typeof id !== 'undefined') ? id : 0;

    if (id > 0)
      vent.trigger('list:show', id);
    else
      alert('404');
  }

});

// Gets the id of the last visited list if still exists,
// else returns the first list if no stored list id
// or 0 if no lists
function getLastVisitedListId()
{
  // Get local web storage
  if(typeof(Storage) !== "undefined")
  {
    if (typeof(localStorage.lastViewedListId) !== "undefined")
    {
      // Return the last visited list id if list still exists
      var lastViewdList = app.listsView.collection.get(localStorage.lastViewedListId);
      if (typeof(lastViewdList) !== "undefined")
      {
        return localStorage.lastViewedListId;
      }
    }
    else
    {
      console.log('Local storage: No last viewed list id');
    }
  }
  else
  {
    // Local Web storage not supported
    console.log('Local Web storage not supported');
  }

  // Return the first list if at least one list exists
  if (app.listsView.collection.isEmpty() === false)
  {
    var firstListModel = app.listsView.collection.models[0];
    return firstListModel.id;
  }

  // No lists exist
  return 0;
}
