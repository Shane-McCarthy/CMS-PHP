<?php include '../../templates/html/head.html';
require_once('../../includes/initialize.php');
?>
<body class="container" style="background: #035376;">
<?php
require_once('../../templates/php/session_test.php');
if (isset($_POST['submit'])) { // Form has been submitted.

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $saltstring = "nongesticulatingitalian";
    $password .= $saltstring;
    $password = sha1($password);

    // Check database to see if username/password exist.
    $found_user = User::authenticate($username, $password);

    if ($found_user) {
        $session->login($found_user);
        //log_action('Login', "{$found_user->username} Logged in. ");
        $_SESSION['role']=$found_user->role;
        $_SESSION['projectID']=$found_user->active_collabID;
        $_SESSION['username'] = $found_user->username;
        redirect_to("index.php");
    } else {
        // username/password combo was not found in the database
        $message = "Username/password combination incorrect.";
    }

} else { // Form has not been submitted.
    $username = "";
    $password = "";
    $message = "";
}
?>

<div style="background: #58c; margin:10% 30% 10% 30%;text-align:center;">
    <form class="form-inline" action="loginPage.php" method="post">
        <fieldset>
            <legend><img src="../../img/logo.png""/></legend>
            <div class="control-group">
                <label class="control-label">Name</label>

                <div class="controls">

                    <input type="text" name="username" maxlength="30"
                           value="<?php echo htmlentities($username); ?>" class="input-medium"/>
                </div>
                <label class="control-label">Password</label>

                <div class="controls">
                    <input type="password" name="password" maxlength="30"
                           value="<?php echo htmlentities($password); ?>" class="input-medium"/>
                </div>
            </div>
            <button class="btn btn-success" type="submit" name="submit" value="Login">Login</button>
            <div>
                <h6 class="text-danger"><?php echo $message; ?></h6>
            </div>
            <div>
                <h5>user : widerfunnel</h5>
                <h5>pass: central</h5>
            </div>
        </fieldset>
    </form>
</div>


<?php include '../../templates/html/footer.php'; ?>
