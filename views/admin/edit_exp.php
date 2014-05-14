<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 4/12/14
 * Time: 9:35 AM
 */
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}
//1. the current page number
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

//2.  records per page
$per_page = 10;
//3. total record count

$project_id = 587;
                    if (isset($_GET['projectID'])) {
                        $project_id = $_GET['projectID'];
                    }else{
                        if ($_SESSION['role']=="client")
                            $project_id =  $_SESSION['projectID'];
                    }


                    $_SESSION['project_id'] = $project_id; // set another session for database



$total_count = FunEx::count_by_id($project_id);


$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM funex ";
$sql .= "WHERE client_id={$project_id} ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$experiments = FunEx::find_by_sql($sql);

?>



<div class="col-lg-9">
    <div class="panel panel-default">
        <div class="panel-body">
            <h3>Experiments</h3>
        </div>
    </div>
    </div>

<div class="col-lg-12">
    <table class="table table-striped table-hover ">
        <thead>
        <tr><?php
            if($_SESSION['role'] == 'admin'){
            echo "<th>link</th>";
            }?>
            <th>EXP #</th>
            <th>Description</th>
            <th>Page</th>
            <?php
            if($_SESSION['role'] == 'admin'){
            echo "<th>Add Screen Shots</th>";
            echo "<th>Add Optimizely Screen Shots</th>";
            }?>
            <th>View Experiment Details</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($experiments as $exp) {
            echo "<tr>";
            if($_SESSION['role'] == 'admin'){

                echo "<td><a  href='./../../views/admin/update_exp.php?id=" . $exp->id . "'>Update</td>";
            }
            echo "<td>" . $exp->funex_no . "</td>";
            echo "<td>" . $exp->description . "</td>";
            echo "<td>" . $exp->page . "</td>";
            if($_SESSION['role'] == 'admin'){
                echo "<td><a  href='./../../views/admin/screens.php?id=" . $exp->id . "'>Add</td>";
                echo "<td><a  href='./../../views/admin/opt_screens.php?id=" . $exp->id . "'>Add Optimizely Screen Shots</td>";
            }
            echo "<td><a href='./../../views/admin/exp_view.php?id=" . $exp->id . "'>View FunEx " . $exp->funex_no . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>


    </table>
    <?php
    if($_SESSION['role'] == 'admin'){
        echo "<a  type='button' class='btn btn-default' href='./../../views/admin/admin.php'>Add Experiment</a><br>";
    }
    ?>

    <ul class="pagination pagination-lg">
        <?php
        if ($pagination->total_pages() > 1) {

            if ($pagination->has_previous_page()) {
                echo "<li><a  href='./../../views/public/index.php?page='";
                echo $pagination->previous_page();
                echo "'>&laquo; Previous</a></li>";
            }

            for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                if ($i == $page) {
                    echo "<li class='active'><a href='#'>".$i."</a></li> ";
                } else {
                    echo " <li><a  href='./../../views/public/index.php?page={$i}'>{$i}</a></li> ";
                }
            }

            if ($pagination->has_next_page()) {
                echo "<li><a  href='./../../views/public/index.php?page='";
                echo $pagination->next_page();
                echo "'>Next &raquo;</a> </li>";
            }
        }
       ?>
        </ul>