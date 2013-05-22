/*=============================
=            Views            =
=============================*/

App.Views.UserInfo = Backbone.View.extend({
    el: $('#user-info'),

    events: {
        "click #settings" : "clickSettings",
        "click #logout" : "clickLogout"
    },

    clickLogout: function(event) {
        $.ajax({
            url: 'auth/logout',
            type: 'get',
            dataType: 'json',
            success: function(data) {
                if (data.result == 'Success') {
                    window.location = '/'; //Reload index page
                } else {
                    alert('Logout failed'); //Alert on fail
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Logout failed (hard)');
            }
        });
    },

    clickSettings: function(event) {
        console.log('Settings clicked');
    }
});
