<?php
    include '../connect.php';

    $userID = $_GET['userID'];
    $eventID = $_GET['eventID'];

    $statement_tojoin = $connection->prepare("INSERT INTO tbluserevents(userID, eventID) VALUES (?,?)");    
    $statement_tojoin->bind_param("ii", $userID, $eventID);
    $statement_tojoin->execute();

    header("location: ../events.php");
?>