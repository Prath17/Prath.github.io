<?php
    session_start();

    if(!isset($_GET['uid']) || !isset($_SESSION['creditAmount']))    // check if destination user and credit to be transferred are both set
    {
        header('Location: transferCredit.php');
        exit;
    }
    //if sourceUser has not been set, then creditAmount is also not set. So no need to check again.
    
    $sourceID = $_SESSION['sourceUser'];
    $credit = $_SESSION['creditAmount'];
    $destinationID = $_GET['uid'];
    
    //check if uid is not same as sourceID
    if($sourceID == $destinationID)
    {
        header('Location: transferCredit.php?sameUser');
        exit;
    }

    require 'php/connection.php';

    $sql = "SELECT * FROM USERS WHERE UserID = ?;";
    $stmt = mysqli_stmt_init($conn);

    if(mysqli_stmt_prepare($stmt, $sql))
    {
        mysqli_stmt_bind_param($stmt, "i", $sourceID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $sourceRow = $result->fetch_assoc();        //retrieve source user details

        mysqli_stmt_bind_param($stmt, "i", $destinationID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);        

        if($result->num_rows == 0)
        {
            //destinationID is wrong (sourceID can never be wrong, because we already check it in showOneUser.php)
            header('Location: transferCredit.php?destinationNotFound');
            exit;
        }

        $destinationRow = $result->fetch_assoc();        //retrieve destination user details  
        $_SESSION['destUser'] = $destinationID;          //store destinationID in the session
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
        <h1 class="text-center py-3">Confirm Details</h1>

        <h3 class="py-3">Source User Details</h3>

        <table class="table table-hover">
            <thead>
                <th scope="col">User ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Credit</th>
                <th scope="col">Country</th>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $sourceRow['UserID'] ?></td>
                    <td><?php echo $sourceRow['Name'] ?></td>
                    <td><?php echo $sourceRow['Email'] ?></td>
                    <td><?php echo $sourceRow['Credit'] ?></td>
                    <td><?php echo $sourceRow['Country'] ?></td>
                </tr>
            </tbody>
        </table>

        <h3 class="py-3">Destination User Details</h3>

        <table class="table table-hover">
            <thead>
                <th scope="col">User ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Credit</th>
                <th scope="col">Country</th>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $destinationRow['UserID'] ?></td>
                    <td><?php echo $destinationRow['Name'] ?></td>
                    <td><?php echo $destinationRow['Email'] ?></td>
                    <td><?php echo $destinationRow['Credit'] ?></td>
                    <td><?php echo $destinationRow['Country'] ?></td>
                </tr>
            </tbody>
        </table>

        <p class="lead py-3">Amount to be transferred: <?php echo $credit?></p>

        <div class="row justify-content-around">
            <a href="transferCredit.php" class="btn btn-danger">Go Back</a>
            <a href="transfer.php" class="btn btn-success">Confirm</a>
        </div>        
    </div>
    
    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>