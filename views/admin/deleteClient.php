<?php
require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
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

        <?php

        // Submit form
        if (isset($_POST['submit'])) {
            $client = new Client();
            if (isset($_POST['id'])) {
                $client->id = trim($_POST['id']);
            }

            if ($client->delete()) {
                redirect_to('clientsLists.php');
            } else {
                // Failed
                $message = "There was an error that prevented the client from being saved.";
            }
        } else { // display form for update
            if (empty($_GET['id'])) {
                $session->message("No Client ID was provided.");
                redirect_to('clientsLists.php');
            }
            $id = $_GET['id'];
            $client = Client::find_by_id($id);
            if (!$client) {
                $session->message("The client could not be located.");
                redirect_to('clientsLists.php');
            }
        }
        ?>

        <form action="deleteClient.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>

            <h3>Delete Client</h3>

            <div style="width:450px;">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="span8">

                            <table>

                                <tr>
                                    <td><label style="width:60px;">Client Name:</label></td>
                                    <td><input type="text" name="client_name"  readonly="readonly"
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
                                    <td><input type="text" name="client_location" readonly="readonly"
                                               value="<?php echo $client->client_location; ?>" style="width: 300px;height:30px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <!--<td><label>Client Code:</label></td>-->
                                    <td><input type="hidden" name="client_code" readonly="readonly"
                                               value="<?php echo $client->client_code; ?>"  style="width: 300px;height: 30px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Phone Number:</label></td>
                                    <td><input type="text" name="phone_number" readonly="readonly"
                                               value="<?php echo $client->phone_number; ?>"  style="width: 300px;height:30px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Address:</label></td>
                                    <td><input type="text" name="address" readonly="readonly"
                                               value="<?php echo $client->address; ?>"  style="width: 300px;height: 30px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Website:</label></td>
                                    <td><input type="text" name="website" readonly="readonly"
                                               value="<?php echo $client->website; ?>"  style="width: 300px;height:30px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    $username ="";
                                    $users = User::find_all();
                                    if ($users != null) {
                                        foreach ($users as $user) {
                                            if ($user->id == $client->user_id){
                                                $username = $user->username;
                                            }
                                        }
                                    }
                                    ?>
                                    <td><label>User Id:</label></td>
                                    <td><input type="text" name="user_id" readonly="readonly"
                                               value="<?php echo $username; ?>"  style="width: 300px;height: 30px" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Fax Number:</label></td>
                                    <td><input type="text" name="fax_number" readonly="readonly"
                                               value="<?php echo $client->fax_number; ?>"  style="width: 300px;height: 30px"/>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a  class="btn" href="../../views/admin/clientsLists.php">Back</a>
                <input class="btn btn-primary" type="submit" name="submit" value="Delete Client"/>
        </form>

    </div>

<?php include './../../templates/php/footer.php'; ?>
<?php include './../../templates/html/footer.php'; ?>