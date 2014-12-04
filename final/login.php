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
            <form action="login-action.php" method="post" role="form" class="row">
                <fieldset>
                    <div class="col-xs-2">
                        <label for="username">Username: </label>
                        <input type="text" name="username" id="username" value="" class="form-control" placeholder="user"/>
                    </div>
                    <div class="col-xs-2">
                        <label for="password">Password: </label>
                        <input type="password" name="password" id="password" value="" class="form-control" placeholder="user"/>
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
                    <input type="submit" value="Submit" class="btn btn-primary btn-xs"/> <input type="reset" value="Reset" class="btn btn-primary btn-xs"/>
                </div>
            </form>
        </div>
    </body>
</html>
