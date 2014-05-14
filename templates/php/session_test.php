<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 4/8/14
 * Time: 3:30 PM
 */
$strong_id_to_test = session_id() .
    $_SERVER['HTTP_USER_AGENT'] .
    $_SERVER['REMOTE_ADDR'] .
    "totalperspectivevortex";

if (isset($_SESSION['strong_id'])) {
    if ($strong_id_to_test == $_SESSION['strong_id']) {

    } else {
        session_destroy();

        header("Location: loginPage.php");
        die();
    }
}
