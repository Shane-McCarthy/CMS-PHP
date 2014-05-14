<?php
require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}
?>


<div class="container">
<?php

if($_SESSION['role'] == 'admin'){
    include './../../templates/php/masthead.php';
}else{
    include './../../templates/php/masthead_client.php';
}
 // Submit form
    $message ="";
    if (isset($_POST['submit'])) {
        $user = new User();
        if (isset($_POST['id'])) {
            $id = trim($_POST['id']);
            $user->id = trim($_POST['id']);
        }
        $password = $_POST['password'];
        $con_pass = $_POST['confirm_password'];

        if ($password == "" || $con_pass == ""){
          $message .= "Fill out password and confirm password." . '</br>';
        }
        if ($password != $con_pass){
          $message .= "Password does not match with confirm password." . '</br>';
        }
        if ($message =="") {
           $saltstring = "nongesticulatingitalian";
           $password .= $saltstring;
           $encripted = sha1($password);
           $user->username = $_POST['username'];
           $user->salt = $saltstring;
           $user->company_name = $_POST['company_name'];
           $user->password = $encripted;
           $user->role =  $_POST['role'];
           $user->active_collabID =  $_POST['active_collabID'];

           if ($user->save()) {
               redirect_to('user_list.php');
           } else {
               // Failed
             $message = "There was an error that prevented the user from being saved.";
           }
        }else {

            $user = User::find_by_id($id);
            if (!$user) {
                $session->message("The user could not be located.");
                redirect_to('user_list.php');
            }
        }

    } else { // display form for update
        if (empty($_GET['id'])) {
            $session->message("No User ID was provided.");
            redirect_to('user_list.php');
        }
        $id = $_GET['id'];
        $user = User::find_by_id($id);
        if (!$user) {
            $session->message("The user could not be located.");
            redirect_to('user_list.php');
        }
    }
?>


    <form class="form-horizontal" action="edit_user.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <input type="hidden" name="role" value="<?php echo $user->role; ?>"/>
        <input type="hidden" name="active_collabID" value="<?php echo $user->active_collabID; ?>"/>
        <legend>Edit User</legend>

        <div class="form-group">
            <label class="col-lg-2 control-label">User Name:</label>
              <div class="col-lg-10">
                                <input  type="text"class="form-control"  readonly="readonly" name="username" value="<?php echo $user->username; ?>" >
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Company Name:</label>
              <div class="col-lg-10">
                                <input  type="text" class="form-control"  readonly="readonly" name="company_name" value="<?php echo $user->company_name; ?>" >
              </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Password:</label>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="password" value=""/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label">Confirm Password:</label>
            <div class="col-lg-10">
                <input type="password" class="form-control" name="confirm_password" value=""/>
            </div>
        </div>



        <?php
        if ($message != ""){
            echo '<p style="color: red">' . $message  . '</p>';
        }
        ?>
        <div class="modal-footer">
            <input class="btn btn-primary" type="submit" name="submit" value="Confirm Password Change"/>
    </form>
    <?php
    include './../../templates/php/footer.php';
    ?>
</div>


