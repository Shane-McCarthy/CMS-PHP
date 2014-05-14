<?php

require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $screen = Screenshots::find_by_id($id);
    $funex = FunEx::find_by_id($screen->experiments_id);
    $optimizely = Optimizely::find_by_exp($funex->id);
}
?>

    <link href="./../../css/styles.css" rel="stylesheet" media="screen">

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
            </div>
            <div class="bs-docs-section">
            <div class="row" id='screens-img'>
            <div class="col-lg-12">

                <?php
                echo "<div class='bs-component' id='screens-img'>";

                    echo "<div class= 'col-lg-12' > <div class='panel panel-info'>
                <div class='panel-heading'>".$screen->filename."</div>
                <div class='panel-body'>".$screen->caption."</div>
                                <div class='panel-body'>".$screen->hypotheses."</div>
                                <div class='panel-body'>".$screen->lift_points."</div>
                                <div class='panel-body'>".$screen->samples."</div>
                                <div class='panel-body'>".$screen->confidence."</div>

                <div class='well'><a href='".$screen->report_link."'>".$screen->report_link."</a></div>
                <div class='panel-body'>";
                    echo " <img src='./../../views/public/images/". $screen->filename."'width='600' /></div></div></div>";

                echo "</div></div></div></div>";
                ?>





            </div>
            </div>
        </div>
    </div>
    </div>

<?php
include './../../templates/php/footer.php';
?>