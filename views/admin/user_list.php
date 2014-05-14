<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 4/12/14
 * Time: 9:35 AM
 */
require_once './../../templates/html/head.html';
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

$total_count = User::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM users ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$users = User::find_by_sql($sql);

?>


<div class="container">
<?php
if($_SESSION['role'] == 'admin'){
    include './../../templates/php/masthead.php';
}else{
    include './../../templates/php/masthead_client.php';
}
?>

    <h2>Users</h2>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>User Name</th>
            <th>Company Name</th>
            <th>Role</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($users as $user) {
            echo "<tr>";

            echo "<td>" . $user->username . "</td>";
            echo "<td>" . $user->company_name . "</td>";
            echo "<td>" . $user->role . "</td>";


            echo "<td><a  href='./../../views/admin/edit_user.php?id=" . $user->id . "'>Update Password</td>";
            echo "<td><a ' href='./../../views/admin/delete_user.php?id=" . $user->id . "'>Delete</td>";

            echo "</tr>";
        }
        ?>
        </tbody>

        <div id="pagination" style="clear: both;">
            <?php
            if ($pagination->total_pages() > 1) {

                if ($pagination->has_previous_page()) {
                    echo "<a   href=\'./../../views/admin/user_list.php?page='".$pagination->previous_page()."'";
                    echo "\">&laquo; Previous</a> ";
                }

                for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo " <span class=\"selected\">{$i}</span> ";
                    } else {
                        echo " <a   href='./../../views/admin/user_list.php?page={$i}'>{$i}</a> ";
                    }
                }

                if ($pagination->has_next_page()) {
                    echo " <a  href='./../../views/admin/user_list.php?page='";
                    echo $pagination->next_page();
                    echo "\>Next &raquo;</a> ";
                }

            }

            ?>
    </table>

<?php echo output_message($message);?>

    <a class="btn btn-primary" href="../../views/admin/add_user.php" >Add User</a>

<?php
include './../../templates/php/footer.php';
?>