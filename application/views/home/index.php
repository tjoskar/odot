<!DOCTYPE html>
<html lang="en">
<head>
<title>ODOT</title>
<link href='http://fonts.googleapis.com/css?family=Snippet|Cagliostro' rel='stylesheet' type='text/css'>
<style>
    * {
        margin: 0;
        padding: 0;
        color: rgb(75, 75, 75);
    }
    body {
        background-color: #f6f5f5;
    }
    li {
        list-style-type: none;
    }
    *:focus {
        outline: none;
    }

    /* Text */
    h2 {
        font-family: 'Snippet', sans-serif;
        font-size: 20px;
    }

    /* Container */
    .container {
        margin: 0 auto 0 auto;
        width: 960px;
        background-color: #fff;
        min-height: 100px;
        padding: 10px;
        overflow: hidden;
    }
    .loggo {
        float: right;
        font-family: 'Snippet', sans-serif;
        font-size: 46px;
        border-bottom: 1px solid #d2d1d2;
    }
    .main-container {
        margin: 70px 0 30px 200px;
        padding-left: 10px;
        border-left: 1px solid #d2d1d2;
    }

    /* Left list */
    .left-list {
        float: left;
        width: 200px;
        margin-top: 70px;
        border-right: 1px solid #d2d1d2;
    }
    .left-list li {
        padding: 5px;
        font-family: 'Cagliostro', sans-serif;
        font-size: 16px;
        -webkit-transition: all 0.2s ease-out;
        -moz-transition: all 0.2s ease-out;
        -ms-transition: all 0.2s ease-out;
        -o-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
    }
    .left-list li:hover, .left-list li.active {
        background-color: #6cb7e7;
        color: #fff;
    }

    /* Task list */
    .main-container ul {
        padding-top: 20px;
    }
    .main-container li {
        padding: 10px;
        font-family: Arial, Helvetica, sans-serif;
        -webkit-transition: all 0.2s ease-out;
        -moz-transition: all 0.2s ease-out;
        -ms-transition: all 0.2s ease-out;
        -o-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
        float: left;
        width: 350px;
    }
    .main-container li:hover {
        background-color: #6cb7e7 !important;
        color: #fff;
    }
    .main-container li:nth-child(even) {
        background-color: #e9ebef;
    }
    
    /* Form */
    form.add-task {
        position: relative;
        left: 185px;
    }
    input.add-task {
        width: 300px;
        height: 30px;
        background: #e9ebef;
        border: none;
        padding: 5px 10px 5px 10px;
        font-family: 'Open Sans', sans-serif;
        color: rgb(117, 117, 117);
        font-size: 16px;
    }
    button.flat {
        -webkit-appearance: none;
        border: none;
        display: inline-block;
        background: #6cb7e7;
        color: white;
        cursor: pointer;
        font-size: 12px;
        padding: 5px 10px 5px 10px;
        -webkit-transition: all 0.5s ease-out;
        -moz-transition: all 0.5s ease-out;
        -ms-transition: all 0.5s ease-out;
        -o-transition: all 0.5s ease-out;
        transition: all 0.5s ease-out;
    }
    button.flat:hover {
        background-color: rgb(75, 75, 75);
    }
    .add-task-button {
        height: 40px;
    }
    input.add-list {
        width: 180px;
        height: 20px;
        background: #e9ebef;
        border: none;
        padding: 5px 10px 5px 10px;
        font-family: 'Cagliostro', sans-serif;
        color: rgb(117, 117, 117);
        font-size: 16px;
    }
    a {
        text-decoration: none;
    }
        
</style>

<!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<script type="text/x-handlebars" id="lists">
    <div class="container">
        <div class="loggo">ODOT</div>
        <div class="left-list">
            <ul>
            {{#if model.content}}
                {{#each list in model}}
                    <li> {{#linkTo 'list' list}} {{list.title}} {{/linkTo}} </li>
                {{/each}}
            {{else}}
                <li> :( </li>
            {{/if}}
            <ul>
            <form class="add-list">
                <input class="add-list" placeholder="Add list...">
            </form>
        </div>
        <div class="main-container">
            {{outlet}}
        </div>
    </div>
</script>

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
<?php echo HTML::script('js/libs/jquery-1.9.1.js') ?>
<?php echo HTML::script('js/libs/handlebars-1.0.0-rc.3.js') ?>
<?php echo HTML::script('js/libs/ember-1.0.0-rc.2.js') ?>
<?php echo HTML::script('js/libs/ember-data.js') ?>
<?php echo HTML::script('js/app.js') ?>

</body>
</html>