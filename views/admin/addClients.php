<?php
require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}

$message ="";
if (isset($_POST['submit'])) {

    $client_name = trim($_POST['client_name']);
    $activecollab_id = trim($_POST['activecollab_id']);

    //client name & activecollab_id should not be blank
    if ($client_name == "" || $activecollab_id == ""){
        $message .= "Fill up Client name and  Project Id." . '</br>';
    } else{
       $client = Client::find_duplicate($activecollab_id,$client_name);
       if ($client) {
         $message .= "The client already exists." . '</br>';
    }
    }

    if ($message == ""){
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
         redirect_to("clientsLists.php");
        } else {
         // Failed
         $session->message = "There was an error that prevented the client from being saved.";
        }
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



            <div class="col-lg-9">
    <form class="form-horizontal" action="addClients.php" method="POST">

        <fieldset>
            <legend>Add New Client</legend>
            <div class="form-group">

                <label class="col-lg-2 control-label">Client Name: </label>
                <div class="col-lg-10">



                                  <?php
                                   include_once './../../php/api.php';
                                    $model = new ApiCalls();
                                    $category_id = '12574';
                                    $projects = $model->getAllProjects();
                                    if ($projects != null) {
                                        echo "<select class='form-control' id='select' name='company_name'
                                               onchange='changeHiddenInput(this)'>";

                                        foreach ($projects as $project) {
                                            if ($project['category_id'] == $category_id) {
                                                echo '<option data-value="'.$project['name'].'" value="' . $project['id'].'|' .$project['name']. '">' . $project['name'] . '</option>' ;
                                            }
                                        }
                                        echo '</select>';
                                    }
                                    ?>
                                     </div>
                                </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Project Id:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="activecollab_id" value=""/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Client Location:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="client_location" value=""/>
                </div>
            </div>

                            <input type="hidden" name="client_code" value="" />
            <div class="form-group">
                <label class="col-lg-2 control-label">Phone Number:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="phone_number" value=""/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Address:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="address" value=""/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Website:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="website" value=""/>
                </div>
            </div>
                <input type="hidden" name="user_id" value="<?php echo $session->user_id ?>"/>

            <div class="form-group">
                <label class="col-lg-2 control-label">Fax Number:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="fax_number" value=""/>
                </div>
            </div>
            <div class="modal-footer">



                <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
            </div>
    </form>
            </div>
        </div>

        <?php
         if ($message != ""){
           echo '<p style="color: red">' . $message  . '</p>';
         }
        ?>



    <?php
    include './../../templates/php/footer.php';
    ?>




