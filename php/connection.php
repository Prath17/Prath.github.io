<?php
    $servername = "sql12.freemysqlhosting.net:3306";
    $username = "sql12273971";
    $password = "WmvdKtzswM";
    $db = "sql12273971";

    $conn = new mysqli($servername, $username, $password, $db);

    if($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
?>