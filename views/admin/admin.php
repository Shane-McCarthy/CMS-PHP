<?php
require_once './../../templates/html/head.html';
require_once('./../../includes/initialize.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../loginPage.php");
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

    <form class="form-horizontal" action="./../../views/admin/newfunex.php" method="post">
        <input type="hidden" name="method" value="addNewExperiment"/>

        <fieldset>
            <legend>Add New Experiment</legend>

            <div class="form-group">

                                    <label class="col-lg-2 control-label">Select Page: </label>
                <div class="col-lg-10">
                                    <select class="form-control" id="select" name="page">
                                        <?php $pages = Pages::find_by_client_id($session->client_id);
                                            if($pages){
                                        foreach ($pages as $page) {
                                            echo "<option value='" . $page->page . "'>" . $page->page . "</option>";
                                        }
                                            }else{
                                                echo "<option value=''>No pages to display. Please update database</option>";
                                            }
                                        ?>

                                    </select>
                                 </div>
                               </div>

            <div class="form-group">
            <label class="col-lg-2 control-label">FunEx Number:</label>
                <div class="col-lg-10">

            <select class="form-control" id="select" name="funex_no">
                                        <?php $exp_no = ExperimentNumber::find_by_client_id($session->client_id);
                                            if($exp_no){
                                        foreach ($exp_no as $page) {
                                            echo "<option value='" . $page->funex_no . "'>" . $page->funex_no . "</option>";
                                        }
                                            }else{
                                                echo "<option value=''>No Experiments to display. Please update database</option>";
                                            }
                                        ?>

                                    </select>
                                        </div>
                                    </div>
        <div class="form-group">
<label class="col-lg-2 control-label">Number of Variations:</label>
<div class="col-lg-10">
                                <input type="text" class="form-control" name="variations_count" value=""/>
    </div>
    </div>
    <div class="form-group">
    <label class="col-lg-2 control-label">Traffic Volume:</label>
        <div class="col-lg-10">
                                <input type="text" class="form-control" name="traffic_volume" value=""/>
</div>
</div>
        <div class="form-group">
<label class="col-lg-2 control-label">Targetting:</label>
                                <div class="col-lg-10">
                               <input type="text" class="form-control" name="targetting" value=""/>
                            </div>
                       </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Conversion Objective:</label>
            <div class="col-lg-10">

                            <textarea  class="form-control"rows="6" cols="40" name="conversion_obj"></textarea>
                        </div>
                        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Description</label>
            <div class="col-lg-10">

            <textarea class="form-control" rows="6" cols="40" name="description"></textarea>
                        </div>
                    </div>

        <div class="modal-footer">



            <input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
        </div>
    </form>

</div>
</div>
<?php include './../../templates/html/footer.php'; ?>