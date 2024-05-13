<?php
    include ('../connect.php');
    // $sql="DELETE FROM tblaccount WHERE accountID='".$_GET['accountID']."'";
    // mysqli_query($connection,$sql);
    $delete = true;
    $statement = $connection->prepare("UPDATE tblaccount SET isDelete = ? WHERE accountID=?");
    $statement->bind_param("ii", $delete, $_GET['accountID']);
    $statement->execute();
    header("location: ../logout.php");
?>