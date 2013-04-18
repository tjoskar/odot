<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ODOT:TODO</title>
        <meta name="viewport" content="width=device-width">
        <style>
            *{ 
                margin:0;
                padding:0;
            }
            html,body {
                height: 100%;
                background-color: #333;
            }
            .left-list {
                float: left;
                width: 200px;
                background-color: #195f91;
                height: 100%;
                overflow: hidden;
            }
            .container {
                margin: 50px auto 0 auto;
                width: 800px;
            }
            .main-container {
                float: left;
                background-color: #72ADD4;
                overflow: hidden;
                width: 500px;
            }
            .task-list {
                margin: 0 auto 0 auto;
                border: 1px solid black;
                min-height: 300px;
                background-color: #2972A3;
            }
            li {
                border-left: 1px solid black;
                padding: 10px;
                font-size: 20px;
                color: #eee;
            }
            li:hover {
                background-color: #72ADD4;
                color: green;
                text-align: center;
            }
        </style>
        
    </head>
    <body>
        <div class="container">
            <div class="left-list">
                <ul>
                    <li>FIRST</li>
                    <li>SECOND</li>
                    <li>THIRD</li>
                    <li>FOURTH</li>
                    <li>FIFTH</li>
                </ul>
            </div>
            <div class="main-container">
                <div class="task-list">
                    <p>FIRST</p>
                    <p>SECOND</p>
                    <p>THIRD</p>
                    <p>FOURTH</p>
                    <p>FIFTH</p>
                </div>
            </div>
        </div>
    </body>
</html>
