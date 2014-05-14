<?php
require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');

?>

        <?php

        if (isset($_GET['id'])) {
            $exp_number = $_GET['id'];
        }

        if (isset($_POST['submit'])) {

            $photo = new Optimizely();

            $photo->caption = $_POST['caption'];
            $photo->filename = $_POST['filename'];
            $photo->optimizely_link = $_POST['optimizely_link'];
            $photo->experiments_id = $_POST['experiments_id'];

            $photo->attach_file($_FILES['file_upload']);
            if ($photo->save()) {
                // Success
                $session->message("Screen Shot was uploaded successfully.");
                redirect_to('./../../views/public/index.php');
            } else {
                // Failure
                $message = join("<br />", $photo->errors);
            }
        }
        $funex = FunEx::find_by_id($exp_number);
        ?>

        <?php echo output_message($message); ?>



<div class="container">
<?php
    if($_SESSION['role'] == 'admin'){
    include './../../templates/php/masthead.php';
    }else{
    include './../../templates/php/masthead_client.php';
    }
?>
    <div class="col-lg-12">

        <div id="screens">
            <div class="bs-docs-section">
                <?php include_once './../../views/public/navbar_from_database.php'; ?>



            <div class="col-lg-9">
                <div class="bs-component" >
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Experiment</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group"><?php

                                echo "<li class='list-group-item'><h4>Docket:" . $funex->funex_no . " </h4></li>";
                                echo "<li class='list-group-item'><h4>Page: " . $funex->page . "</h4></li>";
                                echo "<li class='list-group-item'><h4>Variations: " . $funex->variations_count ." </h4></li>";
                                echo "<li class='list-group-item'><h4>Traffic Volume:" . $funex->traffic_volume . " </h4></li>";
                                echo "<li class='list-group-item'><h4>Targeting: " . $funex->targetting . "</h4></li>";
                                ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
                    <div class="col-lg-9">
                    <form class="form-horizontal" action="opt_screens.php" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="method" value="addNewExperiment"/>
                        <input type="hidden" name="experiments_id" value="<?php
                        echo $funex->id;   ?>"/>


                        <legend>Optimizely Screen Shot Upload</legend>
            <div class="form-group">
                <label  class="col-lg-4 control-label">File Name:</label>
                <div class="col-lg-8">
                <input type="text" class="form-control" name="filename" value=""/>
                </div>
            </div>
            <div class="form-group">
                    <label class="col-lg-4 control-label">Caption:</label>
                <div class="col-lg-8">
                               <input type="text" class="form-control" name="caption" value=""/>
                             </div>
                          </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label">Optimizely Link:</label>
                    <div class="col-lg-8">
                               <input type="text" class="form-control" name="optimizely_link" value=""/>
                                </div>
                              </div>
            <div class="form-group">
                    <label class="col-lg-4 control-label">Upload File:</label>
                <div class="col-lg-8">
                               <input type="file" name="file_upload"/>
                            </div>
                          </div>





                        <div class="col-lg-8">
                <input class="btn btn-primary" type="submit" name="submit" value="Upload Screen Shot"/>
                        </div>


                    </form>
      </div>


