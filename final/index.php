<?php
include_once 'auth-class.php';
$admin = new userauth();
$admin->_authenticate();
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <head>
        <title>The Friendly Everyday Email Robot</title>
        <link rel="stylesheet" href="dist/css/bootstrap.css">
        <link rel="stylesheet" href="dist/css/bootstrap-theme.css">
        <link href="feer.css" rel="stylesheet">
        <script src="js/jquery-1.11.1.js"></script>
        <script src="dist/js/bootstrap.js"></script>
        <script src="feer.js"></script>
    </head>

    <body>
        <div class="bg"></div>
        <div class=jumbotron>
            <div id="textboxes" class="row">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="https://github.com/stratosmacker/comp426/">Source Code</a></li>
                </ul>
                <h1>The Friendly Everyday Email Robot</h1>
                <p class="lead">Welcome <?php echo userauth->get_nicename($_SESSION['user_login']); ?> </p>
                <input type="button" onclick="javascript:window.location.href='logout.php'" value="logout" class="btn btn-primary btn-sm"/>
            </div>
            <!-- Start main html
            -->
            <div id="textboxes" class="row">
                <form role="form" class="">
                    <div class="col-xs-2">
                        <label>From:</label> 
                        <input name="from_field" type="email" class="form-control" placeholder="Enter email"/>
                    </div>
                    <div class=col-xs-2>
                        <label>To:</label>
                        <input name="to_field" type="email" class="form-control" placeholder="Enter email"/>
                    </div>
                    <div class=col-xs-2>
                        <label>CC:</label>
                        <input name="cc_field" type="email" class="form-control" placeholder="Enter email"/>
                    </div>
                    <div class="col-xs-5">
                        <label for="date-0">When?</label>
                        <input type="date" name="date" class="form-control" id="date-0">
                    </div>
                </form>
            </div>
            <div class="row main">
                <form role="form" class="">
                    <div class=form-group>
                        <label class="col-lg-10" for="body">Message:</label>
                        <div class="col-lg-10">
                            <textarea class="form-control col-lg-10" id="body" placeholder="Enter Message"  name=""></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row main">
                <button id="submit" name="send_button" type="submit" class="btn btn-primary btn-lg">Send to Queue</button>
            </div>
        </div>
    </body>
</html>
