<?php

require_once './../../templates/html/head.html';
require_once('./../../includes/initialize.php');
if (!$session->is_logged_in()) {
    redirect_to("loginPage.php");
}
?>
<body>

<div class="container">
    <?php include './../../templates/php/masthead.php';

    $session->logout();
    ?>
    <div class="container">
    <h2>Thank you, you are now logged out</h2>

    <a class="btn btn-info" href="loginPage.php">Login</a>
    </div>

    <?php
    include './../../templates/php/footer.php';
    ?>
</div>