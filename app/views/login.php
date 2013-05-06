<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<?php echo Html::style('css/login.css'); ?>

<!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>

<div class="odotlogin" id="odotlogin">
    <div id="fb-root"></div>
    <div class="logo">ODOT</div>
    <div id="login-holder"></div>
</div>

<?php echo Html::script('js/libs/underscore.js') ?>
<?php echo Html::script('js/libs/jquery-1.9.1.js') ?>
<?php echo Html::script('js/libs/backbone.js') ?>

<script type="text/template" id="login-template">
    <form class="auth-form" id="login-form">
        <ul>
            <li><input class="auth-user" type="text" placeholder="username"></li>
            <li><input class="auth-pass" type="password" placeholder="password"></li>
            <li><button class="login-button flat-button" type="submit">Login</button></li>
        </ul>
    </form>

    <div class="reg-or-facebook">
        <button class="flat-button" id="register-button">Register</button>
        <div id="facebook-button">
        <fb:login-button show-faces="false" width="200" max-rows="1" size="large"></fb:login-button>
        </div>
    </div>
</script>

<script type="text/template" id="register-template">
    <form class="auth-form" id="register-form">
        <ul>
            <li><input class="auth-user" type="text" placeholder="username"></li>
            <li><input class="auth-pass" type="password" placeholder="password"></li>
            <li><input class="auth-pass" type="password" placeholder="re-type password"></li>
            <li><button class="flat-button" type="submit">Register</button></li>
        </ul>
    </form>
</script>

<script>
var AuthView = Backbone.View.extend({

    el: $("#odotlogin"),
    loginTemplate: _.template($('#login-template').html()),
    registerTemplate: _.template($('#register-template').html()),

    events: {
      "submit #login-form" : "submitLogin",
      "submit #register-form" : "submitRegister",
      "click #register-button" : "clickRegister",
    },

    submitLogin: function(event) {
        event.preventDefault();

        //$('.alert-error').hide(); // Hide any errors on a new submit
        //var url = '../api/login';
        console.log('Loggin in... ');
        var formValues = {
            username: $('.auth-user').val(),
            password: $('.auth-pass').val()
        };
        console.log(formValues);

        $.ajax({
            url: 'auth/login',
            type: 'post',
            dataType: 'json',
            data: formValues,//$('form.auth-form').serialize(),
            success: function(data) {
                if (data.result == 'Success') {
                    window.location = '/'; //Reload index page
                } else {
                    alert('Login failed'); //Alert on fail
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Login failed (hard)');
            }
        });
    },

    clickRegister: function(event) {
        this.renderRegister();
    },

    submitRegister: function(event) {
        event.preventDefault();

        var passwords = $('.auth-pass');
        var p0 = $(passwords[0]).val();
        var p1 = $(passwords[1]).val();
        var user = $('.auth-user').val();

        if (_.isEmpty(user)) {
            alert('No username');
            return;
        }

        if (_.isEmpty(p0) || _.isEmpty(p1) || p0 !== p1) {
            alert('Passwords don\'t match');
            return;
        }

        var formValues = {
            username: user,
            password: p0
        };
        console.log(formValues);

        $.ajax({
            url: 'auth/register',
            type: 'post',
            dataType: 'json',
            data: formValues,
            success: function(data) {
                if (data.result == 'Success') {
                    window.location = '/'; //Reload index page
                } else {
                    alert('Registration failed'); //Alert on fail
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log('Registration failed (hard)');
            }
        });
    },

    facebookLoginSucceeded: function(res) {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
            window.debug = response;
            console.log('Good to see you, ' + response.name + '.');
        });
    },

    initialize: function() {
        this.renderLogin();
    },

    renderLogin: function() {
        $("#login-holder").empty();
        $("#login-holder").append( this.loginTemplate() );
    },
    renderRegister: function() {
        $("#login-holder").empty();
        $("#login-holder").append( this.registerTemplate() );
    }
});

var AuthApp = new AuthView;

// Additional JS functions here
window.fbAsyncInit = function() {
    FB.init({
        appId      : '531139020265166', // App ID
        channelUrl : '//www.odot.dev/channel.html', // Channel File
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
    });

    // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
    // for any auth related change, such as login, logout or session refresh. This means that
    // whenever someone who was previously logged out tries to log in again, the correct case below 
    // will be handled. 
    FB.Event.subscribe('auth.authResponseChange', function(response) {
        // Here we specify what we do with the response anytime this event occurs. 
        if (response.status === 'connected') {
            // The response object is returned with a status field that lets the app know the current
            // login status of the person. In this case, we're handling the situation where they 
            // have logged in to the app.
            //testAPI();
            AuthApp.facebookLoginSucceeded();
        } else if (response.status === 'not_authorized') {
            // In this case, the person is logged into Facebook, but not into the app, so we call
            // FB.login() to prompt them to do so. 
            // In real-life usage, you wouldn't want to immediately prompt someone to login 
            // like this, for two reasons:
            // (1) JavaScript created popup windows are blocked by most browsers unless they 
            // result from direct user interaction (such as a mouse click)
            // (2) it is a bad experience to be continually prompted to login upon page load.
            FB.login();
        } else {

            // In this case, the person is not logged into Facebook, so we call the login() 
            // function to prompt them to do so. Note that at this stage there is no indication
            // of whether they are logged into the app. If they aren't then they'll see the Login
            // dialog right after they log in to Facebook. 
            // The same caveats as above apply to the FB.login() call here.
            FB.login();
        }
    });
};

// Load the SDK asynchronously
(function(d){
    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    //js.src = "//connect.facebook.net/en_US/all.js";
    js.src = "//connect.facebook.net/en_US/all/debug.js";
    ref.parentNode.insertBefore(js, ref);
}(document));


</script>


</body>
</html>