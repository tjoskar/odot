/*=============================
=            Home             =
=    The app starting point   =
=============================*/


// Event handler
var vent = _.extend({}, Backbone.Events);

// Alias for console.log
var d = function(msg) {
  console.log(msg);
};

// Trying to establish a connection to the websocket server
if ("WebSocket" in window)                                                  // Check if the browser has WebSocket support
{
	app.socketConn = new WebSocket('ws://localhost:8080');                    // Establish a connection to the websocket server
	app.socketConn.onopen = function(e)
	{
		console.log("Websocket connection established!");
		var data = {'object': 'user', 'method': 'setUserID', 'args': user_id};
		app.socketConn.send(JSON.stringify(data));                              // Send our user id to the websocket server
	};

	app.socketConn.onmessage = function(e)                                    // You got mail
	{
		var json = JSON.parse(e.data);
		if (_.has(json, 'status') && json.status == 200)                        // Is it good news or bad news
		{
			if (_.has(json, 'fire'))
			{
				if (_.has(json.fire, 'name') && _.has(json.fire, 'args'))
				{
					vent.trigger(json.fire.name, json.fire.args);                    // Fired up an event
				}
				else
				{
					app.alert('Bad message from server', 'alert');
				}
			}
		}
		else if (_.has(json, 'error') && _.has(json.error, 'name') && _.has(json.error, 'args'))
		{
			app.alert(json.error.name + ': ' + json.error.args, 'alert');
		}
		console.log(e.data);                                                  // Log all message for debug
	};
}

// Let's go, yo
app.router = new App.Router();
new App.Views.AddListForm();
new App.Views.AddItemForm();
new App.Views.UserInfo();

// Initialize the popup view
app.popup = new App.Views.SharePopup();

// Fetch all lists
var listCollection = new App.Collections.List();
listCollection.fetch().then(function() {
  app.listsView = new App.Views.Lists({ collection: listCollection });
  app.listsView.showAllLists();

  // Firing up the router
  Backbone.history.start();
});
