<?php    
    require 'php/connection.php';

    $sql = "SELECT * FROM TRANSACTIONS;";
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

        <?php
            if($result->num_rows == 0)
            {
        ?>
                <h2 class="text-center py-3">No transactions occurred so far.</h2>
        <?php
            }
            else
            {
        ?>    

                <h1 class="text-center py-4">View All Transactions</h1>       
                <table class="table table-hover">
                    <thead>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Source User ID</th>
                        <th scope="col">Destination User ID</th>
                        <th scope="col">Amount Transferred</th>
                    </thead>
                    <tbody>
                        <?php
                            while($row = $result->fetch_assoc())
                            {
                                echo "<tr>";
                                    echo "<td>" . $row["TransactionID"] . "</td> 
                                        <td>" . $row["SourceUser"] . "</td>
                                        <td>" . $row["DestinationUser"] . "</td>
                                        <td>" . $row["AmountTransferred"] . "</td";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>    

        <?php
            }
        ?>

        <div class="row justify-content-center py-3">
            <a href="/" class="btn btn-danger">Go Back</a>    
        </div>
        
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>    