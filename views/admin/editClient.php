<?php
require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}

        $id=null;
    // Submit form
    if (isset($_POST['submit'])) {
        $client = new Client();
        if (isset($_POST['id'])) {
            $client->id = trim($_POST['id']);
        }
        $client->client_name = trim($_POST['client_name']);
        $client->activecollab_id = trim($_POST['activecollab_id']);
        $client->client_location = trim($_POST['client_location']);
        $client->client_code = trim($_POST['client_code']);
        $client->phone_number = trim($_POST['phone_number']);
        $client->address = trim($_POST['address']);
        $client->website = trim($_POST['website']);
        $client->user_id = trim($_POST['user_id']);
        $client->fax_number = trim($_POST['fax_number']);

        if ($client->save()) {
            $message = "The Client was saved successfully. ";
            redirect_to('./../../views/admin/clientsLists.php');

        } else {
            // Failed
            $message = "There was an error that prevented the client from being saved.";
            redirect_to('./../../views/admin/clientsLists.php');

        }
    } else { // display form for update
        if (empty($_GET['id'])) {
            $session->message("No Client ID was provided.");
            redirect_to('./../../views/admin/clientsLists.php');

        }
        $id = $_GET['id'];

        $client = Client::find_by_id($id);
        if (!$client) {
            $session->message("The client could not be located.");
            redirect_to('./../../views/admin/clientsLists.php');

        }
    }
    ?>
<div class="container">

    <?php
    if($_SESSION['role'] == 'admin'){
        include './../../templates/php/masthead.php';
    }else{
        include './../../templates/php/masthead_client.php';
    }
    ?>

    <form action="../../views/admin/editClient.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>

        <h3>Edit Client</h3>

        <div style="width:450px;">
            <div class="row-fluid">
                <div class="span12">
                    <div class="span8">

                        <table class="table table-striped table-hover ">
                            <tbody>
                            <tr>
                                <td><label style="width:60px;">Client Name:</label></td>
                                <td><input type="text" name="client_name" readonly="readonly"
                                     value="<?php echo $client->client_name; ?>"  style="width: 300px;height:30px"/>
                                </td>
                            </tr>
                            <tr>
                               <!-- <td><label>ActiveCollab Id:</label></td>-->
                                <td><input type="hidden" name="activecollab_id" readonly="readonly"
                                    value="<?php echo $client->activecollab_id; ?>"  style="width: 300px;height:30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Client Location:</label></td>
                                <td><input type="text" name="client_location"
                                           value="<?php echo $client->client_location; ?>" style="width: 300px;height:30px"/>
                                </td>
                            </tr>
                            <tr>
                               <!-- <td><label>Client Code:</label></td>-->
                                <td><input type="hidden" name="client_code"
                                           value="<?php echo $client->client_code; ?>"  style="width: 300px;height: 30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Phone Number:</label></td>
                                <td><input type="text" name="phone_number"
                                           value="<?php echo $client->phone_number; ?>"  style="width: 300px;height:30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Address:</label></td>
                                <td><input type="text" name="address"
                                           value="<?php echo $client->address; ?>"  style="width: 300px;height: 30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Website:</label></td>
                                <td><input type="text" name="website"
                                           value="<?php echo $client->website; ?>"  style="width: 300px;height:30px"/>
                                </td>
                            </tr>
                            <tr>
                                <td><label>User Id:</label></td>
                                <td>

                                    <?php
                                    $users = User::find_all();
                                    if ($users != null) {
                                        echo '<select name="user_id">';
                                        foreach ($users as $user) {
                                            if ($user->id == $client->user_id){
                                              echo '<option value="' . $user->id . '" selected>' . $user->username . '</option>' . '</br>';
                                            } else{
                                              echo '<option value="' . $user->id . '">' . $user->username . '</option>' . '</br>';
                                            }
                                        }
                                        echo '</select>';
                                    }
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td><label>Fax Number:</label></td>
                                <td><input type="text" name="fax_number"
                                           value="<?php echo $client->fax_number; ?>"  style="width: 300px;height: 30px"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">

            <input class="btn btn-primary" type="submit" name="submit" value="Save Changes"/>
    </form>


</div>
<?php
include './../../templates/php/footer.php';
?>
