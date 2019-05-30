<?php
    session_start();
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
        <h1 class="text-center py-3">
            Welcome
        </h1>

        <div class="row text-center">
            <div class="col-md-6 py-3">
                <a class="btn btn-info" href="showUsers.php">Transfer Credit</a>
            </div>
            <div class="col-md-6 py-3">
                <a class="btn btn-info" href="showTransactions.php">Show All Transactions</a>    
            </div>
            
        </div>

        <?php
            if(isset($_SESSION['success']))
            {                
        ?>
                <h2 class="text-success text-center py-5">Transaction completed successfully!</h2>
        <?php
            }
        ?>
        <?php
            if(isset($_SESSION['error']))
            {                
        ?>
                <h2 class="text-danger text-center py-5">Transaction was unsuccessful. Please try again!</h2>
        <?php
            }
            session_destroy();
        ?>
    </div>
    

    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>