<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<?php echo HTML::style('css/login.css'); ?>

<!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
    
<div class="odotlogin" id="odotlogin">
    <div class="logo">ODOT</div>
    <div id="login-holder"></div>
</div>

<?php echo HTML::script('js/libs/underscore.js') ?>
<?php echo HTML::script('js/libs/jquery-1.9.1.js') ?>
<?php echo HTML::script('js/libs/backbone.js') ?>

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
        <button class="flat-button" id="facebook-button">Login with Facebook</button>
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
            url: 'home/login',
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
            url: 'home/register',
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

</script>


</body>
</html>