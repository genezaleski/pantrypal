<?php
    //uses spaghetti code to store session variables

    session_start();

    //removes existing fields
    //unset($_SESSION['name']);
    //unset($_SESSION['image']);

    //fills session variable with useful profile information
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['image'] = $_POST['imageUrl'];

    ?>
