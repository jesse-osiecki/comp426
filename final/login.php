<!-- login form
-->
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
