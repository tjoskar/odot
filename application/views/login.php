<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<?php //echo HTML::style('css/master.css'); ?>

<!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<style>
    .odotauth {
        margin: 0 auto 0 auto;
        width: 960px;
        background-color: #fff;
        min-height: 100px;
        padding: 10px;
        overflow: hidden;

    }
    .logo {
        float: right;
        font-family: 'Snippet', sans-serif;
        font-size: 46px;
        border-bottom: 1px solid #e9ebef;
    }
    
    li {
        list-style: none;
    }
    *:focus {
        outline: none;
    }
    .auth-form {
        margin: 0 auto 0 auto;
        position: relative;
        padding-top: 100px;
        width: 300px;
        overflow: hidden;
    }
    .auth-user, .auth-pass {
        width: 100%;
        height: 30px;
        background: #e9ebef;
        border: 1px solid white;
        padding: 5px 10px 5px 10px;
        font-family: 'Open Sans', sans-serif;
        color: #757575;
        font-size: 16px;
    }
    button.auth-button {
        width: 100%;
        height: 30px;

        -webkit-appearance: none;
        border: 1px solid white;
        display: inline-block;
        background: #6cb7e7;
        color: white;
        cursor: pointer;
        font-size: 12px;
        padding: 5px 10px 5px 10px;
        .ease-transition(0.5s);

        &:hover {
            background-color: rgb(75, 75, 75);
        }
    }
    
</style>

</head>
<body>
    
    <div class="odotauth" id="odotauth">
        <div class="logo">ODOT</div>
        <form class="auth-form">
            <ul>
                <li><input class="auth-user" type="text" placeholder="username"></li>
                <li><input class="auth-pass" type="password" placeholder="password"></li>
                <li><button class="auth-button" type="submit">Login</button></li>
            </ul>
        </form>
    </div>  

<?php echo HTML::script('js/libs/underscore.js') ?>
<?php echo HTML::script('js/libs/jquery-1.9.1.js') ?>
<?php echo HTML::script('js/libs/backbone.js') ?>


<script>
var AuthView = Backbone.View.extend({
    
    el: $(".auth-form"),
    //template: _.template($('#auth-template').html()),
    
    events: {
      "submit" : "login",
    },

    login: function(event) {
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
            url: 'login',
            type: 'post',
            dataType: 'json',
            data: formValues,//$('form.auth-form').serialize(),
            success: function(data) {
                //alert("Logged in"); // <- this would have to be your own way of showing that user is logged in
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert("Login failed");
                //alert(xhr.responseText); // <- same here, your own div, p, span, whatever you wish to use
            }
        });
    },

    initialize: function() {
    },

    render: function() {

    }
  });

  var AuthApp = new AuthView;

</script>


</body>
</html>