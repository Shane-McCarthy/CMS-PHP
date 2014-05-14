<?php
require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}

$message ="";
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $con_pass = $_POST['confirm_password'];
    $username = $_POST['username'];
    // all entries should be filled out
    if ($username == "" || $password == "" || $con_pass ==""){
        $message .= "Fill up all entries." . '</br>';
    }
    // password and confirm pass should match
    if ($password != $con_pass){
        $message .= "Password does not match with Confirm password ." . '</br>';
    }
    //further validate
    if ($message ==""){
        $name = User::find_duplicate($username);
        if ($name) {
            $message .= "Username already exists." . '</br>';
        }
    }
    // no error then save to the database
    if ($message =="") {
        $user = new User();
        $saltstring = "nongesticulatingitalian";
        $password .= $saltstring;
        $encripted = sha1($password);
        $user->username = $_POST['username'];
        $user->salt = $saltstring;

        $comp_and_id =  trim($_POST['company_name']); // split the company name id
        $myArray = explode(',', $comp_and_id);

        $user->company_name = $myArray[0];
        $user->active_collabID = $myArray[1];
        $user->password = $encripted;
        $user->role = "client";

        if ($user->save()) {
            redirect_to('user_list.php');
        } else {
            // Failed
            $message = "There was an error that prevented the user from being saved.";
        }
    }

}

?>
<body>

<div class="container">
    <?php
    if($_SESSION['role'] == 'admin'){
        include './../../templates/php/masthead.php';
    }else{
        include './../../templates/php/masthead_client.php';
    }
    ?>

    <form action="add_user.php" method="POST">
        <input type="hidden" name="role" value="client"/>


        <h3>Add User</h3>

        <div class="modal-body" style="width:660px;">
            <div class="row-fluid">
                <div class="span12">
                    <div class="span8">
                        <h5>User Details</h5>
                        <table class="table table-striped table-hover ">
                            <tbody>
                            <tr>
                                <td>
                                    <label>Client: </label>
                                </td>
                                <td>
                                    <?php

                                    include_once './../../php/api.php';
                                    $model = new ApiCalls();
                                    $category_id = '12574';
                                    $projects = $model->getAllProjects();
                                    if ($projects != null) {

                                        echo '<select name="company_name">';
                                        foreach ($projects as $project) {
                                            if ($project['category_id'] == $category_id) {
                                               /*$project_id = $project['id'];
                                                echo  '<input type="hidden" name="activecollab_id" value="'. $project_id. '"/>';*/
                                                echo '<option value="' . $project['name'] ."," .$project['id'] .  '">' . $project['name'] . '</option>' . '</br>';

                                            }
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Username:</label></td>
                                <td><input type="text" name="username" value=""/></td>
                            </tr>
                            <tr>
                                <td><label>Password:</label></td>
                                <td><input type="password" name="password" value=""/></td>
                            </tr>
                            <tr>
                                <td><label>Confirm Password:</label></td>
                                <td><input type="password" name="confirm_password" value=""/></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <?php
        if ($message != ""){
            echo '<p style="color: red">' . $message  . '</p>';
        }
        ?>
        <div class="modal-footer">
           
            <input class="btn btn-primary" type="submit" name="submit" value="Submit User"/>
        </div>
    </form>

<?php
include './../../templates/php/footer.php';
?>
</div>