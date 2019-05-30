<?php
    session_start();

    if(!isset($_SESSION['destUser']) || !isset($_SESSION['creditAmount']))    // check if destination user and credit to be transferred are both set
    {
        header('Location: transferCredit.php');
        exit;
    }

    require 'php/connection.php';

    //retrieve details from session
    $sourceID = $_SESSION['sourceUser'];
    $destID = $_SESSION['destUser'];
    $amount = $_SESSION['creditAmount'];

    mysqli_autocommit($conn, FALSE);

    $query = "SELECT Credit FROM USERS WHERE UserID = '$sourceID';";
    $result = mysqli_query($conn, $query);

    if(!$result)
    {
        //SQL query failed
        header('Location: index.php?error');
        exit;
    }

    $row = $result->fetch_assoc();
    $availableCredit = $row['Credit'];  

    //we are checking this again (already checked in showDestinationUsers.php) because the value might be updated after the previous read.
    if($availableCredit < $amount)
    {        
        header('Location: transferCredit.php?creditError');
        exit;
    }

    $remainingCredit = $availableCredit - $amount;

    $query = "UPDATE USERS SET Credit='$remainingCredit' WHERE UserID = '$sourceID';";
    $result = mysqli_query($conn, $query);
    
    if(!$result)
    {
        //SQL query failed
        header('Location: index.php?error');
        exit;   
    }

    $query = "UPDATE USERS SET Credit = Credit + '$amount' WHERE UserID = '$destID';";
    $result = mysqli_query($conn, $query);
    
    if(!$result)
    {
        //SQL query failed
        header('Location: index.php?error');
        exit;   
    }

    $query = "INSERT INTO TRANSACTIONS(SourceUser, DestinationUser, AmountTransferred) VALUES('$sourceID', '$destID', '$amount');";
    $result = mysqli_query($conn, $query);

    if(result)
    {
        //all operations successful, therefore commit the changes.
        mysqli_commit($conn);
        $_SESSION['success'] = 1;
        header('Location: index.php');
        exit;
    }
    else
    {
        mysqli_rollback($conn);
        $_SESSION['error'] = 1;
        header('Location: index.php');
        exit;
    }      
?>