<?php

require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}
?>



<?php
if (empty($_GET['id'])) {
    $session->message("No Experiment ID was provided.");
    redirect_to('./../../views/public/index.php');
}
$id = $_GET['id'];
$experiment = FunEx::find_by_id($id);
if (!$experiment) {
    $session->message("The experiment could not be located.");
    redirect_to('./../../views/public/index.php');
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
    <form class="form-horizontal" action="./../../views/admin/newfunex.php" method="post">
        <input type="hidden" name="method" value="addNewExperiment"/>
        <input type="hidden" name="id" value="<?php echo $id ?>"/>


        <fieldset>
            <legend>
                        <h5>Update Experiment <?php echo $experiment->funex_no ?></h5></legend>

            <div class="form-group">
                                    <label class="col-lg-2 control-label">Select Page: </label>
                <div class="col-lg-10">
                                    <select class="form-control" id="select" name="page">
                                        <?php $pages = Pages::find_all();

                                        foreach ($pages as $page) {
                                            echo "<option value='" . $page->page . "'>" . $page->page . "</option>";
                                        }
                                        ?>

                                    </select>
                </div>
            </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">FunEx Number: </label>
                        <div class="col-lg-10">
                               <select  class="form-control" id="select" name="funex_no">
                                        <?php $exp_no = ExperimentNumber::find_all();

                                        foreach ($exp_no as $page) {
                                            echo "<option value='" . $page->funex_no . "'>" . $page->funex_no . "</option>";
                                        }
                                        ?>

                                    </select>
                        </div>
                    </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Number of Variations:</label>
                <div class="col-lg-10">

                               <input type="text" class="form-control" name="variations_count" value=""/></td></div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Traffic Volume:</label>
                <div class="col-lg-10">

                               <input type="text" class="form-control" name="traffic_volume" value=""/></div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Targeting:</label>
                <div class="col-lg-10">

                                <input type="text" class="form-control" name="targetting" value=""/></div>
            </div>


            <div class="form-group">
                <label class="col-lg-2 control-label">Conversion Objective:</label>
                <div class="col-lg-10">

                            <textarea class="form-control" rows="6" cols="40" name="conversion_obj"></textarea>
                        </div>
                        </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Description</label>
                                <div class="col-lg-10">


                            <textarea class="form-control" rows="6" cols="40" name="description"></textarea>
                        </div>
                    </div>
                </div>

        <div class="modal-footer">


            <input class="btn btn-primary" type="submit" name="submit" value="Submit Exp"/>
        </div>
    </form>
</div>
<?php
include './../../templates/php/footer.php';
?>