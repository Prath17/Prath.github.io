<?php
session_start();

if(!isset($_POST['amount']))                //not checking for sourceUser because transferCredit checks it and doesn't redirect here
{
    header('Location: transferCredit.php');
    exit;
}

require 'php/connection.php';

$uid = $_SESSION['sourceUser'];

$sql = "SELECT Credit FROM USERS WHERE UserID = ?;";
$stmt = mysqli_stmt_init($conn);

if(mysqli_stmt_prepare($stmt, $sql))
{
    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result->fetch_assoc();

    $actualCredit = $row['Credit'];

    $inputCredit = $_POST['amount'];

    $remainingCredit = $actualCredit - $inputCredit;
    if($remainingCredit < 0)
    {
        //This gives the user an error message if he enters a credit greater than the credit that is stored in the database.
        header('Location: transferCredit.php?creditError');
        exit;
    }
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
        <h1 class="text-center py-4">View Destination Users</h1>

        <h2 class="pb-3">Please select the user: </h2>

        <table class="table table-hover">
            <thead>
                <th scope="col">User ID</th>
                <th scope="col">Name</th>
                <th scope="col">Select</th>
            </thead>
            <tbody>
                <?php
                   $sql = "SELECT * FROM USERS WHERE UserID != ?;";
                   $stmt2 = mysqli_stmt_init($conn);
           
                   if(mysqli_stmt_prepare($stmt2, $sql))
                   {
                       mysqli_stmt_bind_param($stmt2, "i", $uid);
                       mysqli_stmt_execute($stmt2);
                       $result = mysqli_stmt_get_result($stmt2);

                       $_SESSION['creditAmount'] = $inputCredit;
           
                       while($row = $result->fetch_assoc())
                       {
                           echo "<tr>";
                               echo "<td>" . $row["UserID"] . "</td> 
                                   <td>" . $row["Name"] . '</td>
                                   <td> <a href="confirmDetails.php?uid=' . $row["UserID"] . '">Select</a>';
                           echo "</tr>";
                       }
                   }
                   else
                   {
                        die("SQL query failed!");
                   }
                ?>
            </tbody>
        </table>    

        <div class="row justify-content-center py-3">
            <a href="transferCredit.php" class="btn btn-danger">Go Back</a>    
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>