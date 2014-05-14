<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 4/24/14
 * Time: 8:29 PM
 */
require_once './../../includes/initialize.php';
require_once('../../templates/php/session_test.php');
if (!$session->is_logged_in()) {
    redirect_to("./../../views/public/loginPage.php");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $screens = Screenshots::find_by_id($id);
    $screens->delete();
    redirect_to("./../../views/public/index.php");
}