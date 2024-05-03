<?php
    include ('../connect.php');
    // $sql="SELECT userID FROM tblaccount WHERE accountID='".$_GET['accountID']."'";
    // mysqli_query($connection,$sql);
    $deleteUserAccount = $connection->prepare("DELETE FROM tbluseraccount WHERE accountID=?");
    $deleteUserAccount->bind_param("i", $_GET['accountID']);
    $deleteUserAccount->execute();
    
    $insertTOAdmin = $connection->prepare("INSERT INTO tbladminaccount (accountID) VALUES (?)");
    $insertTOAdmin->bind_param("i", $_GET['accountID']);
    $insertTOAdmin->execute();
    $adminID = $connection->insert_id;
    
    $isAdmin = true;
    $updateStatus = $connection->prepare("UPDATE tbladminstatus SET isAdmin=? WHERE accountID=?");
    $updateStatus->bind_param("ii", $isAdmin, $_GET['accountID']);
    $updateStatus->execute();

    $_SESSION['isAdmin'] = true;
    $_SESSION['adminID'] = $adminID;
    header("location: ../edit-profile.php");
?>