<?php
    //uses spaghetti code to store session variables

    session_start();

    //removes existing fields
    //unset($_SESSION['email']);
    //unset($_SESSION['token']);

    //fills session variable with useful profile information
    $_SESSION['email'] = $_POST['user'];
    $_SESSION['token'] = $_POST['id'];

    ?>
