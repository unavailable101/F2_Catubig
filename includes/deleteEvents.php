<?php
    include ('../connect.php');
    $sql="DELETE FROM tblevents WHERE eventID='".$_GET['eventID']."'";
    mysqli_query($connection,$sql);
    header("location: ../index.php");
?>