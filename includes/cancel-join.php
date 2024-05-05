<?php
    include '../connect.php';

    $statement_remove = $connection->prepare("DELETE FROM tbluserevents WHERE userID=? AND eventID=?");
    $statement_remove->bind_param("ii", $_SESSION['userID'], $_GET['eventID']);
    $statement_remove->execute();

    header("location: ../profile.php");
?>