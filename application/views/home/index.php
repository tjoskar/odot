<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<?php echo HTML::style('css/style.css'); ?>

<!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
    <div class="container">
        <div class="loggo">ODOT</div>
        <div class="left-list">
            <div id="list-holder"></div>
            <form class="add-list">
                <input class="add-list" placeholder="Add list...">
            </form>
        </div>
        <div class="main-container">
            
        </div>
    </div>

<script type="text/x-handlebars" id="lists/index">
    <h2>Please, select a list to the left</h2>
</script>

<script type="text/x-handlebars" id="list">

        {{#each model}}
            <li> {{id}} - {{title}} </li>
        {{/each}}
    
        <li> :( </li>
</script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php echo HTML::script('js/libs/underscore.js') ?>
<?php echo HTML::script('js/libs/jquery-1.9.1.js') ?>
<?php echo HTML::script('js/libs/backbone.js') ?>

<?php echo HTML::script('js/app.js') ?>

</body>
</html>