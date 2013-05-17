App.Views.SharePopup = Backbone.View.extend(
{
    el: $('#popup-container'),
    template: _.template($('#share-list-popup-template').html()),

    events : {
        'submit'    : 'shareWithUser',
    },

    initialize: function(listModel)
    {
        
        this.model = {};
        this.model.listTitle = listModel.get('title');
        this.model.title = '\"' + this.model.listTitle + '\" is currently shared with ';

        this.model.users = [
            'Oskar',
            'Jonas',
            'Johan',
        ];

        //Format the string to contain all users sharing this list
        for (var i in this.model.users) 
        {
            username = this.model.users[i];
            if (i == 0) 
            {
                this.model.title += username;
            } 
            else if (i == this.model.users.length-1 ) 
            {
                this.model.title += ' and ' + username;
            }
            else
            {
                this.model.title += ', ' + username;
            }
        }
        this.model.title += '.';

        //Register a background click event to hide popup
        $('#fullscreen-popup-background').click(function() {
            app.popup.hide();
        });
    },
    show: function() 
    {
        this.$el.empty();
        this.$el.append( this.template( this.model ) );

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
    shareWithUser: function(event) 
    {
        event.preventDefault();
        console.log('Share list with ' + $('input.add-user').val());
    }
});