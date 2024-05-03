<?php
    include ('../connect.php');
    $sql="DELETE FROM tblaccount WHERE accountID='".$_GET['accountID']."'";
    mysqli_query($connection,$sql);
    header("location: ../logout.php");
?>