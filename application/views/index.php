<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<?php echo HTML::style('css/master.css'); ?>

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

            <form class="add-task">
                <input class="add-task" placeholder="Add task...">
                <button class="flat add-task-button">Add task</button>
            </form>

            <div id="items-holder"></div>

        </div>
    </div>

     <script type="text/template" id="item-template">
        <div class="head-item">
            <h3> <lable><%= title %></lable> </h3>
            <input class="hide" value="<%= title %>">
            <div class="item-button-holder"> <i class="icon-time"></i> <i class="icon-trash"></i> </div>
        </div>
        <% if( !_.isEmpty(sub_items) ) { %>
            <div class="sub-items">

            </div>
        <% } %>
        <div class="add-subItems">

        </div>
        <div class="item-settings">

        </div>
    </script>

    <script type="text/template" id="subItem-template">
        <p><%= title %></p>
        <input class="hide" value="<%= title %>">
    </script>

<?php echo HTML::script('js/libs/underscore.js') ?>
<?php echo HTML::script('js/libs/jquery-1.9.1.js') ?>
<?php echo HTML::script('js/libs/backbone.js') ?>

<?php echo HTML::script('js/app.js') ?>
<?php echo HTML::script('js/models/list.js') ?>
<?php echo HTML::script('js/models/item.js') ?>
<?php echo HTML::script('js/views/lists.js') ?>
<?php echo HTML::script('js/views/addListForm.js') ?>
<?php echo HTML::script('js/views/list.js') ?>
<?php echo HTML::script('js/views/items.js') ?>
<?php echo HTML::script('js/views/item.js') ?>
<?php echo HTML::script('js/views/subitems.js') ?>
<?php echo HTML::script('js/views/subitem.js') ?>
<?php echo HTML::script('js/views/addSubItemForm.js') ?>
<?php echo HTML::script('js/routes.js') ?>
<?php echo HTML::script('js/home.js') ?>

</body>
</html>