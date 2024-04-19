<?php
    include ('../connect.php');
    $sql="DELETE FROM tbluseraccount WHERE userID='".$_GET['userID']."'";
    mysqli_query($connection,$sql);
    header("location: ../index.php");
?>