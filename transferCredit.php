<?php
session_start();

if(!isset($_SESSION['sourceUser']))
{
    header('Location: showUsers.php');
    exit;
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
        <h1 class="text-center py-4">Transfer Credit</h1>

        <form action="showDestinationUsers.php" method="POST">
            <div class="form-group">
                <label for="enterAmount">Enter the amount to be transferred: </label>
                <input type="number" id="enterAmount" class="form-control" name="amount" min="1" required>

                <div class="row py-3 justify-content-around">
                    <a href="showUsers.php" class="btn btn-danger">Go Back</a>                    
                    <input type="submit" class="btn btn-success">
                </div>                
            </div>            
        </form>

        <?php
            if(isset($_GET['creditError']))
            {
        ?>
        <p class="text-danger text-center">The credit entered exceeds the user's credit! Please try a lower value.</p>
        <?php
            }
        ?>

        <?php
            if(isset($_GET['sameUser']))
            {
        ?>
        <p class="text-danger text-center">You have selected both the source & destination user as the same. Please try again!</p>
        <?php
            }
        ?>

        <?php
            if(isset($_GET['destinationNotFound']))
            {
        ?>
        <p class="text-danger text-center">Destination user not found. Please try again!</p>
        <?php
            }
        ?>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>             
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>