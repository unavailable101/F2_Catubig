<?php
    include '../connect.php';

    $sql_activateEvent = $connection->prepare("UPDATE tblevents SET isDelete=0 WHERE eventID=?");
    $sql_activateEvent->bind_param("i", $_GET['eventID']);
    $sql_activateEvent->execute();

    // header("location: ../report-link.php");
    header("location: ../profile.php");
?>