<?php
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()||$_SESSION['role'] != 'client') {
    redirect_to("./../../views/public/loginPage.php");
}
//1. the current page number
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

//2.  records per page
$per_page = 10;
//3. total record count

$total_count = FunEx::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM funex ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$experiments = FunEx::find_by_sql($sql);

?>
<body>

<div class="col-lg-9">
    <h2>Experiments</h2>

    <table class="table table-striped table-hover ">
        <thead>
        <tr>
            <th>EXP #</th>
            <th>Description</th>
            <th>Page</th>
            <th>View Experiment Details</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($experiments as $exp) {
            echo "<tr>";
            echo "<td>" . $exp->funex_no . "</td>";
            echo "<td>" . $exp->description . "</td>";
            echo "<td>" . $exp->page . "</td>";
            echo "<td><a data-target='container' href='./../../views/admin/exp_view.php?id=" . $exp->id . "'>View FunEx " . $exp->funex_no . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>

        <div id="pagination" style="clear: both;">
            <?php
            if ($pagination->total_pages() > 1) {

                if ($pagination->has_previous_page()) {
                    echo "<a href=\"./../../views/admin/edit_exp.php?page=";
                    echo $pagination->previous_page();
                    echo "\">&laquo; Previous</a> ";
                }

                for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo " <span class=\"selected\">{$i}</span> ";
                    } else {
                        echo " <a data-target='container' href='./../../views/admin/edit_exp.php?page={$i}\'>{$i}</a> ";
                    }
                }

                if ($pagination->has_next_page()) {
                    echo "<a data-target='container' href=\"./../../views/admin/edit_exp.php?page=";
                    echo $pagination->next_page();
                    echo "\">Next &raquo;</a> ";
                }
            }
            ?>
    </table>



<?php
