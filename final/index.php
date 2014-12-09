<?php
include_once 'auth-class.php';
$userauth = new userauth();
$userauth->_authenticate();
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
        <script src="jumbotron.js"></script>
        <!-- THIS SCRIPT IS SPECIFIC TO THE MAIN PAGE
        -->
        <script src="feer.js" type="application/javascript"></script>
    </head>

    <body>
        <div class="bg"></div>
        <div class=jumbotron>
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="https://github.com/stratosmacker/comp426/">Source Code</a></li>
                </ul>
            </div>
            <h1>The Friendly Everyday Email Robot</h1>
            <div class="row">
                <div class="col-xs-2">
                    <p class="lead">Welcome <?php echo $userauth->get_nicename($_SESSION['user_login']); ?> </p>
                </div>
                <div class="col-xs-2">
                    <input type="button" onclick="javascript:window.location.href='logout.php'" value="logout" class="btn btn-primary btn-sm"/>
                </div>
            </div>
            <!-- Start main html
            -->

            <div>
                <form role="form" class="" id="restform">
                    <div id="params">
                        <div class="row">
                            <div class="col-xs-2">
                                <label>From:</label> 
                                <input name="from" type="email" class="form-control pval" placeholder="Enter email"/>
                            </div>
                            <div class=col-xs-2>
                                <label>To:</label>
                                <input name="to" type="email" class="form-control pval" placeholder="Enter email"/>
                            </div>
                            <div class=col-xs-2>
                                <label>CC:</label>
                                <input name="cc" type="email" class="form-control pval" placeholder="Enter email"/>
                            </div>
                            <div class="col-xs-2">
                                <label for="date-0">When?</label>
                                <input type="date" name="date" class="form-control pval" id="date-0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-2">
                                <textarea class="form-control col-lg-10 pval" id="body" placeholder="Enter Message"  name="message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <button id="submit" name="send_button" type="submit" class="btn btn-primary btn-md">Send to Queue</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-xs-2">
                    <label>Email ID:</label> 
                </div>
                <div class="col-xs-2">
                    <input id="postid" type="text" class="form-control pval" placeholder="Enter id if updating"/>
                </div>
            </div>

            <h2>Other Email Functions</h2>


            <div class="row">
                <div class="col-xs-2">
                    <label>Email ID:</label> 
                    <input id="getid" type="text" class="form-control pval" placeholder="Enter id"/>
                </div>

                <form role="form" class="" id="deleteform">
                    <div class="col-xs-2">
                        <button id="delete" name="delete_button" type="submit" class="btn btn-primary btn-xs">Delete by id</button>
                    </div>
                </form>

                <form role="form" class="" id="listform"> 
                    <div class="col-xs-2">
                        <button id="listids" name="list_button" type="submit" class="btn btn-primary btn-xs">List all ID's</button>
                    </div>
                </form>

                <form role="form" class="" id="getform"> 
                    <div class="col-xs-2">
                        <button id="getbyid" name="id_button" type="submit" class="btn btn-primary btn-xs">Get Email by ID</button>
                    </div>
                </form>
            </div>

            <div id="results">
            <div>Return Status: <span id="returnstatus"></span></div>
            <div>Return Text:
                <div id="returntext"></div>
            </div>
            </div>

        </div>
    </body>
</html>
