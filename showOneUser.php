<?php    
    session_start();

    require 'php/connection.php';
  
    $uid = isset($_GET['uid']) ? $_GET['uid'] : 0 ;     //if uid is not sent, assume its 0 (no user in the USERS table have primary key as 0)

    $sql = "SELECT * FROM USERS WHERE UserID = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(mysqli_stmt_prepare($stmt, $sql))
    {
        mysqli_stmt_bind_param($stmt, "i", $uid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    else
    {
        die("SQL query failed!");
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credit Management</title>

    <link rel="stylesheet" href="css/bootstrap.css">    
    
</head>
<body>
    <div class="container">
        <?php

            if($result->num_rows == 0)
            {
                header('Location: showUsers.php?noUser');
                exit;
            }
            else
            {                
        ?>

        <h1 class="text-center py-4">User Details</h1>
        <table class="table table-hover">
            <thead>
                <th scope="col">User ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Credit</th>
                <th scope="col">Country</th>
            </thead>
            <tbody>
                <?php
                    $row = $result->fetch_assoc();
                    $_SESSION["sourceUser"] = $row["UserID"];           //storing the UserID of the sourceUser in the session, so that it can be later used.
                    echo "<tr>";
                    echo "<td>" . $row["UserID"] . "</td>" . 
                            "<td>" . $row["Name"] . "</td>" .
                            "<td>" . $row["Email"] . "</td>" .
                            "<td>" . $row["Credit"] . "</td>" .
                            "<td>" . $row["Country"] . "</td>";
                    echo "</tr>";
                ?>
            </tbody>
        </table>

        <div class="row justify-content-around py-3">
            <a href="showUsers.php" class="btn btn-danger">Go Back</a>
            <a href="transferCredit.php" class="btn btn-success">Confirm</a>
        </div>

        <?php
            }
        ?>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>