App.Views.SharePopup = Backbone.View.extend(
{
    el: $('#popup-container'),
    template: _.template($('#share-list-popup-template').html()),

    events : {
        'submit'        : 'shareWithUserClick',
    },

    initialize: function()
    {
        this.undelegateEvents();

        // Register websocket callbacks
        vent.on('sharePopup:usersSharingList', this.usersSharingList, this);
        vent.on('sharePopup:listSharedWithUser', this.listSharedWithUser, this);

        // Register a background click event to hide popup
        var self = this;
        $('#fullscreen-popup-background').click(function() {
            self.hide();
        });
    },

    show: function(listModel)
    {
        this.model = {};
        this.model.listTitle = listModel.get('title');
        this.model.listId = listModel.get('id');
        
        this.getUsersSharingThisList();

        $('#odotapp').addClass('blur');
        $('#fullscreen-popup-background').removeClass('hide');
        $('#fullscreen-popup').removeClass('hide');
    },

    hide: function()
    {
        $('#odotapp').removeClass('blur');
        $('#fullscreen-popup-background').addClass('hide');
        $('#fullscreen-popup').addClass('hide');
    },

    getUsersSharingThisList: function()
    {
        // Find which users already sharing this list
        var args = {
            listId: this.model.listId
        };

        var data = {'object': 'user', 'method': 'getUsersSharingListId', 'args': args};
        app.socketConn.send(JSON.stringify(data));
        console.log('getUsersSharingThisList');
    },

    usersSharingList: function(response)
    {
        console.log('usersSharingList');

        // Set the popup description
        this.model.description = '\"' + this.model.listTitle + '\" is currently ';

        this.model.users = response;

        if (this.model.users != null && this.model.users.length > 0)
        {
            // Format the string to contain all users sharing this list
            this.model.description += 'shared with ';

            for (var i in this.model.users)
            {
                username = this.model.users[i];
                if (i == 0)
                {
                    this.model.description += username;
                }
                else if (i == this.model.users.length-1 )
                {
                    this.model.description += ' and ' + username;
                }
                else
                {
                    this.model.description += ', ' + username;
                }
            }
            this.model.description += '.';
        } 
        else
        {
            this.model.description += 'not shared with anyone.';
        }

        //Update the view
        this.$el.empty();
        this.$el.append( this.template( this.model ) );
    },

    shareWithUserClick: function(event)
    {
        event.preventDefault();

        var args = {
            username: $('input.add-user').val(),
            listId: this.model.listId
        };

        var data = {'object': 'user', 'method': 'shareListWithUser', 'args': args};
        app.socketConn.send(JSON.stringify(data));
    },

    listSharedWithUser: function(response)
    {
        

        if (response != '')
        {
            app.alert('List \"' + this.model.listTitle + '\" is now shared with ' + response, 'success');
            $('input.add-user').empty();
            this.getUsersSharingThisList();
        }
        else
        {
            app.alert('Cannot share list with user', 'alert');
        }
    }
});


