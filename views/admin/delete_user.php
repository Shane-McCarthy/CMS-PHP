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
    if (isset($_POST['submit'])) {
        $user = new User();
        if (isset($_POST['id'])) {
            $user->id = trim($_POST['id']);
        }

        if ($user->delete()) {
            redirect_to("user_list.php");
        } else {
            // Failed
            $message = "There was an error that prevented the client from being saved.";
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

    <form action="delete_user.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>

        <h3>Please confirm User Delete</h3>

        <div style="width:450px;">
            <div class="row-fluid">
                <div class="span12">
                    <div class="span8">

                        <table>

                            <tr>
                                <td><label style="width:100px;">User Name:</label></td>
                                <td><input type="text" readonly="readonly" name="username"
                                           value="<?php echo $user->username; ?>"  style="width: 300px;height:30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label style="width:100px;">Company Name:</label></td>
                                <td><input type="text" readonly="readonly" name="companyname"
                                           value="<?php echo $user->company_name; ?>"  style="width: 300px;height:30px"/>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn" href="./../../views/admin/user_list.php">Back</a>
            <input class="btn btn-primary" type="submit" name="submit" value="Confirm Delete"/>
    </form>
    <?php
    include './../../templates/php/footer.php';
    ?>
</div>


