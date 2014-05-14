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

$total_count = Client::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM clients ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$clients = Client::find_by_sql($sql);

?>


<div class="container">
<?php
if($_SESSION['role'] == 'admin'){
    include './../../templates/php/masthead.php';
}else{
    include './../../templates/php/masthead_client.php';
}
?>

    <h2>Clients</h2>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Name</th>
<!--            <th>Project Id</th>-->
            <th>Location</th>
<!--            <th>Client Code</th>-->
            <th>Phone Number</th>
            <th>Address</th>
            <th>Website</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($clients as $client) {
            echo "<tr>";

            echo "<td>" . $client->client_name . "</td>";
//            echo "<td>" . $client->activecollab_id . "</td>";
            echo "<td>" . $client->client_location . "</td>";
//            echo "<td>" . $client->client_code . "</td>";
            echo "<td>" . $client->phone_number . "</td>";
            echo "<td>" . $client->address . "</td>";
            echo "<td>" . $client->website . "</td>";


            echo "<td><a  href='./../../views/admin/editClient.php?id=" . $client->id . "'>Update</td>";
            echo "<td><a  href='./../../views/admin/deleteClient.php?id=" . $client->id . "'>Delete</td>";

            echo "</tr>";
        }
        ?>
        </tbody>

        <div id="pagination" style="clear: both;">
            <?php
            if ($pagination->total_pages() > 1) {

                if ($pagination->has_previous_page()) {
                    echo "<a  href=\"../../views/admin/clientsLists.php?page=";
                    echo $pagination->previous_page();
                    echo "\">&laquo; Previous</a> ";
                }

                for ($i = 1; $i <= $pagination->total_pages(); $i++) {
                    if ($i == $page) {
                        echo " <span class=\"selected\">{$i}</span> ";
                    } else {
                        echo " <a  href='../../views/admin/clientsLists.php?page={$i}'>{$i}</a> ";
                    }
                }

                if ($pagination->has_next_page()) {
                    echo " <a  href=\"../../views/admin/clientsLists.php?page=";
                    echo $pagination->next_page();
                    echo "\">Next &raquo;</a> ";
                }

            }

            ?>
    </table>

   <?php echo output_message($message);?>

    <a   type="button" class="btn btn-default" href="../../views/admin/addClients.php" >Add Client</a>

<?php
include './../../templates/php/footer.php';
?>