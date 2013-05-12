<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<?php echo Html::style('css/master.css'); ?>

<!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
    <div id="odotapp" class="container">
        <div id="alert-box-holder">
        </div>

        <!-- User Info -->
        <div id="user-info">
            <div id="user-avatar">
                <?php 
                    $facebook_id = Auth::user()->facebook_id;
                    if ( !is_null($facebook_id) ) {
                        echo '<img src="https://graph.facebook.com/'. $facebook_id .'/picture">';
                    } else {
                        echo '<i class="icon-user" style="font-size: 50px"></i>';
                    }
                    ?>
            </div>
            <div id="user-menu">
            <ul>
                <li><div id="visible-name">
                    <?php 
                        if ( !is_null(Auth::user()->visible_name) ) {
                            echo Auth::user()->visible_name;
                        } else {
                            echo Auth::user()->username;
                        }
                    ?>
                </div></li>
                <li>
                    <button class="flat user-button" id="settings"><i class="icon-cog"></i> Settings</button>
                    <button class="flat user-button" id="logout"><i class="icon-signout"></i> Logout</button>
                </li>
            </ul>
            </div>
        </div>

        <div class="logo">ODOT</div>
        <div class="left-list">

            <div id="lists-holder"></div>

            <form class="add-list">
                <input class="add-list" placeholder="Add list...">
            </form>

        </div>

        <div class="main-container">

            <form class="add-item">
                <input class="add-item" placeholder="Add item...">
                <button class="flat add-item-button">Add item</button>
            </form>

            <div id="items-holder"></div>

            <div id="completed-items-holder"></div>

        </div>
    </div>

     <script type="text/template" id="item-template">
        <div class="head-item">
            <div class="item-checkbox-holder"> <i class="icon-check-empty"></i> <i class="icon-check hide"></i> </div>
            <h3 data-id="<%= id %>"><%= title %></h3>
            <input class="hide itemEdit" value="<%= title %>" data-id="<%= id %>">
            <div class="item-button-holder hide"> <i class="icon-time"></i> <i class="icon-trash"></i> </div>
        </div>
        <% if( !_.isUndefined(sub_items) ) %>
        <%  if ( !_.isEmpty(sub_items) ) %>
        <%    { %>
                <div class="sub-items">

                </div>
        <%    } %>
        <div class="add-subItems">

        </div>
        <div class="item-settings">

        </div>
    </script>

    <script type="text/template" id="subItem-template">
        <div class="subitem-checkbox-holder">
            <i class="icon-check-empty <% if (completed == 1) { %> hide <% } %>"></i>
            <i class="icon-check <% if (completed == 0) { %> hide <% } %>"></i>
        </div>
        <p <% if (completed == 1) { %> class="completed-item" <% } %> >
            <%= title %>
        </p>
        <input class="hide subItemEdit" value="<%= title %>" data-id="<%= id %>">
        <div class="subitem-button-holder hide"> <i class="icon-trash"></i> </div>
    </script>

    <script type="text/template" id="completed-item-template">
        <div class="head-item">
            <div class="item-checkbox-holder"> <i class="icon-check-empty hide"></i> <i class="icon-check"></i> </div>
            <h3 class="completed-item"><%= title %></h3>
        </div>
    </script>

<script>
var user_id = <?php echo Auth::user()->id; ?>
</script>

<?php echo Html::script('js/libs/underscore.js') ?>
<?php echo Html::script('js/libs/jquery-1.9.1.js') ?>
<?php echo Html::script('js/libs/backbone.js') ?>

<?php echo Html::script('js/libs/jquery.sortable.js') ?>

<?php echo Html::script('js/app.js') ?>

<?php echo Html::script('js/models/list.js') ?>
<?php echo Html::script('js/models/item.js') ?>
<?php echo Html::script('js/models/subitem.js') ?>

<?php echo Html::script('js/models/alert.js') ?>

<?php echo Html::script('js/views/lists.js') ?>
<?php echo Html::script('js/views/list.js') ?>
<?php echo Html::script('js/views/items.js') ?>
<?php echo Html::script('js/views/item.js') ?>
<?php echo Html::script('js/views/subitems.js') ?>
<?php echo Html::script('js/views/subitem.js') ?>
<?php echo Html::script('js/views/completedItems.js') ?>
<?php echo Html::script('js/views/completedItem.js') ?>

<?php echo Html::script('js/views/addListForm.js') ?>
<?php echo Html::script('js/views/addItemForm.js') ?>
<?php echo Html::script('js/views/addSubItemForm.js') ?>

<?php echo Html::script('js/views/alert.js') ?>
<?php echo Html::script('js/views/userInfo.js') ?>

<?php echo Html::script('js/routes.js') ?>
<?php echo Html::script('js/home.js') ?>

</body>
</html>