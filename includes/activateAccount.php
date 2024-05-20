<?php
    include '../connect.php';

    $sql_updateStatus = $connection->prepare("UPDATE tblaccount SET isDelete=0 WHERE accountID=?");
    $sql_updateStatus->bind_param("i", $_GET['accountID']);
    $sql_updateStatus->execute();

    header("location: ../report-link.php");
?>