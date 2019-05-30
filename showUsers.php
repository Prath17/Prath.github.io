<?php    
    require 'php/connection.php';

    $sql = "SELECT * FROM USERS;";
    $result = $conn->query($sql);
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
        <h1 class="text-center py-4">View All Users</h1>

        <h2 class="pb-3">Please select the user: </h2>

        <table class="table table-hover">
            <thead>
                <th scope="col">User ID</th>
                <th scope="col">Name</th>
                <th scope="col">Select</th>
            </thead>
            <tbody>
                <?php
                    while($row = $result->fetch_assoc())
                    {
                        echo "<tr>";
                            echo "<td>" . $row["UserID"] . "</td> 
                                <td>" . $row["Name"] . '</td>
                                <td> <a href="showOneUser.php?uid=' . $row["UserID"] . '">Select</a>';
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>    

        <div class="row justify-content-center py-3">
            <a href="/" class="btn btn-danger">Go Back</a>    
        </div>

        <?php
            if(isset($_GET['noUser']))
            {
        ?>         
                <p class="text-danger text-center">No such user available. Please select again!</p>         
        <?php                       
            }
        ?>
        
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>    