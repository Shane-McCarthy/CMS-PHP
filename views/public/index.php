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
if($_SESSION['role'] == 'admin'){
   include './../../templates/php/masthead.php';
}else{
    include './../../templates/php/masthead_client.php';
}
?>

<!--/.navbar -->
<!-- Example row of columns -->

                                <?php
                                include_once './../../views/public/navbar_from_database.php'
//                                include_once './../../php/BusinessLogic.php';
//                                $projectID = null;
//                                if (isset($_GET['projectID'])) {
//                                    $projectID = $_GET['projectID'];
//                                }
//                                else{$projectID = 587;}
//                                $FE = new BusinessLogic();
//                                echo $FE->displayExperimentsByCategory($projectID);
                                ?>




<!--        --><?php
                    include './../../views/admin/edit_exp.php';
            //include './../../views/public/funExTable.php';

//        ?>



</div>

<?php
//include './../../templates/php/footer.php';
?>
</body>

