<?php

require_once './../../templates/html/head.html';
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
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
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $funex = FunEx::find_by_id($id);
        $screen = Screenshots::find_by_exp($funex->id);
        $optimizely = Optimizely::find_by_exp($funex->id);
    }

    ?>

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

            <div class="col-lg-12">
            <div class="bs-component" >
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Optimizely Links</h3>
                    </div>
                    <div class="panel-body">
                <ul class="list-group">
            <?php foreach($optimizely as $optimizelys){
        echo "<li class='list-group-item'><a href='".$optimizelys->optimizely_link."'>".$optimizelys->optimizely_link."</a></li>";
            }
            ?>
    </ul>

    </div>
    </div>
    </div>

        <div class="col-lg-12">

    <?php
        echo " <div class='bs-docs-section'> <div class='row' ><div class='bs-component' id='screens-img'><div class= 'col-lg-9' >";
      foreach($screen as $screens){
          echo "<a href='screen_description.php?id=".$screens->id."'><div class= 'span3' > <div class='panel panel-info'>
                <div class='panel-heading'>".$screens->filename."</div>
                <div class='panel-body'>".$screens->caption."</div>";

                echo" <div class='panel-body'>";
            echo " <img src='./../../views/public/images/". $screens->filename."'width='100' /></div>";
             echo" <div class='panel-body'><a href='delete_image.php?id=".$screens->id."'>Delete this Screen Shot</a></div></div></div></a>";
       }
    echo "</div></div></div></div>";
    ?>




</div>
</div>
</div>
</div>
</div>
</div>

<?php
include './../../templates/php/footer.php';
?>