<?php
require_once './../../templates/html/head.html';
require_once('./../../includes/initialize.php');

$message ="";
if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $con_pass = $_POST['confirm_password'];
    if ($password == $con_pass) {
        $user = new User();
        $saltstring = "nongesticulatingitalian";
        $password .= $saltstring;
        $encripted = sha1($password);
        $user->username = $_POST['username'];
        $user->salt = $saltstring;
        $user->company_name = $_POST['company_name'];
        $user->password = $encripted;
        $user->role = "client";

    }
    if ($user->save()) {
        redirect_to('user_list.php');
    } else {
        // Failed
        $message = "There was an error that prevented the user from being saved.";
    }
}


?>
<body>

<div class="container">
    <?php include './../../templates/php/masthead.php'; ?>

    <form action="add_user.php" method="POST">
        <input type="hidden" name="role" value="client"/>


        <h3>Add User</h3>

        <div class="modal-body" style="width:660px;">
            <div class="row-fluid">
                <div class="span12">
                    <div class="span8">
                        <h5>User Details</h5>
                        <table>
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
                                                echo '<option value="' . $project['name'] . '">' . $project['name'] . '</option>' . '</br>';

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

                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn" href="user_list.php">Back</a>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit User"/>
        </div>
    </form>

</div>
<?php include './../../templates/html/footer.php'; ?>