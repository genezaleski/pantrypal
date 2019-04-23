<?php
    //uses spaghetti code to store session variables

    session_start();

    //removes existing fields
    //unset($_SESSION['firstName']);
    //unset($_SESSION['lastName']);

    //fills session variable with useful profile information
    $_SESSION['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] = $_POST['lastName'];


    ?>
