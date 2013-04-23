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
    <div id="odotapp" class="container">
        <div class="logo">ODOT</div>
        <div class="left-list">

            <div id="lists-holder"></div>
            <form class="add-list">
                <input class="add-list" placeholder="Add list...">
            </form>
            
        </div>       

        <div class="main-container">
            <div id="items-holder"></div>
        </div>
    </div>
    </div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php echo HTML::script('js/libs/underscore.js') ?>
<?php echo HTML::script('js/libs/jquery-1.9.1.js') ?>
<?php echo HTML::script('js/libs/backbone.js') ?>
<?php echo HTML::script('js/app.js') ?>

</body>
</html>