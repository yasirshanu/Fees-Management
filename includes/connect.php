<?php
    date_default_timezone_set('Asia/Kolkata');
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fees";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        session_start();
    }
?>