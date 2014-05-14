<?php
include './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once '../../templates/php/session_test.php';

if (!$session->is_logged_in()) {
    redirect_to("loginPage.php");
}
?>

<body>

<div class="container">


    <?php

    if($_SESSION['role'] == "admin"){
        include './../../templates/php/masthead.php';
    }else{
        include './../../templates/php/masthead_client.php';
    }

    ?>

    <!--/.navbar -->
    <!-- Example row of columns -->
    <div class="row-fluid" id="container">
        <div class="span3">
            <div class="accordion" id="accordion1">
                <!--DashBoard-->
                <div class="accordion-group">
                    <div class="accordion-heading" style="text-align: center;line-height: 35px;font-weight:bold;">
                        <a class="accordion-toggle" data-target="main" id="
                    <?php
                        $projectID = null;
                        if (isset($_GET['projectID'])) {
                            $projectID = $_GET['projectID'];
                        }
                        else{$projectID = 587;}
                        echo $projectID;
                        ?>
                    " href="index.php">
                            Dashboard
                        </a>
                    </div>


                </div>

                <!--Experiment Summary-->
                <div class="accordion-group">
                    <div class="accordion-heading" style="text-align: center;line-height: 35px;font-weight:bold;">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapsetwo">
                            Experiments
                        </a>
                    </div>

                    <div id="collapsetwo" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <ul class="nav nav-list" style="padding:0;">
                                <li class="dropdown">
                                    <?php
                                    //include_once './../../views/public/navbar_from_database.php'
                                                                    include_once './../../php/BusinessLogic.php';
                                                                    $projectID = null;
                                                                    if (isset($_GET['projectID'])) {
                                                                        $projectID = $_GET['projectID'];
                                                                    }
                                                                    else{$projectID = 587;}
                                                                    $FE = new BusinessLogic();
                                                                    echo $FE->displayExperimentsByCategory($projectID);

                                    ?>

                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <!--BuildDirect Tasks-->
                <!--            <div class="accordion-group">-->
                <!--                <div class="accordion-heading" style="text-align: center;line-height: 35px;font-weight:bold;">-->
                <!--                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapsefour">-->
                <!--                        BuildDirect Tasks-->
                <!--                    </a>-->
                <!--                </div>-->
                <!--            </div>-->
            </div>
        </div>

        <div class="span9" style="border-left:1px solid #08c;padding:15px 25px;" id="mainContainer">
            <?php

                include './../../views/public/funExTable.php';

            ?>

        </div>
    </div>

    <hr>


</div>

<?php
include './../../templates/php/footer.php';
?>


/**
 * Created by PhpStorm.
 * User: Gui
 * Date: 22/04/14
 * Time: 10:13 PM
 */ 