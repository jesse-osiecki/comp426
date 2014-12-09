<!-- login form
-->
<html lang="en">
    <meta charset="utf-8">
    <head>
        <title>The Friendly Everyday Email Robot</title>
        <link rel="stylesheet" href="dist/css/bootstrap.css">
        <link rel="stylesheet" href="dist/css/bootstrap-theme.css">
        <link href="feer.css" rel="stylesheet">
        <script src="js/jquery-1.11.1.js"></script>
        <script src="dist/js/bootstrap.js"></script>
        <script src="jumbotron.js"></script>
    </head>
    <body>
        <div class="bg"></div>
        <div class=jumbotron>
            <div class="row">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Login</a></li>
                    <li><a href="https://github.com/stratosmacker/comp426/">Source Code</a></li>
                </ul>
                <h1>The Friendly Everyday Email Robot</h1>
            </div>
            <div class="row">
                <h2> Login: </h2>
                <form action="login-action.php" method="post" role="form" class="row">
                    <fieldset>
                        <div class="col-xs-2">
                            <label for="username">Username: </label>
                            <input type="text" name="username" id="username" value="" class="form-control" placeholder="user"/>
                        </div>
                        <div class="col-xs-2">
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password" value="" class="form-control" />
                        </div>
                        <p>
                        <div class="col-xs-2">
                            <label for="remember">
                                <input type="checkbox" name="remember" id="remember" value="1" class="form-control"/> Remember me
                            </label>
                        </div>
                        </p>
                    </fieldset>
                    <div class="col-xs-2">
                        <input type="submit" value="Submit" class="btn btn-primary btn-xs"/>
                    </div>
                </form>
            </div>
            <div class="row">
                <h2> Create an Account: </h2>
                <form action="create-user-action.php" method="post" role="form" class="row">
                    <fieldset>
                        <div class="col-xs-2">
                            <label for="username">Username: </label>
                            <input type="text" name="username" id="username" value="" class="form-control" placeholder="user"/>
                        </div>
                        <div class="col-xs-2">
                            <label for="nicename">Full Name: </label>
                            <input type="text" name="nicename" id="nicename" value="" class="form-control" placeholder="User U. McManWoman"/>
                        </div>
                        <div class="col-xs-2">
                            <label for="email">Email: </label>
                            <input type="text" name="email" id="email" value="" class="form-control" placeholder="email"/>
                        </div>
                        <div class="col-xs-2">
                            <label for="password">Password: </label>
                            <input type="password" name="password" id="password" value="" class="form-control" />
                        </div>
                        <div class="col-xs-2">
                            <label for="trickquestion">Teacher's last name?: </label>
                            <!-- Slow down the Spam bots, answer is Patel -->
                            <input type="text" name="trickquestion" id="trickquestion" value="" class="form-control" />
                        </div>
                    </fieldset>
                    <div class="col-xs-2">
                        <input type="submit" value="Submit" class="btn btn-primary btn-xs"/>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
