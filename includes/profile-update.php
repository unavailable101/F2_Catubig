<?php
    include '../connect.php';

    if (isset($_POST['save-changes'])){
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $age = $_POST['age'];
        $email = $_POST['email'];

        $statement_common = $connection->prepare("UPDATE tblaccount SET firstName=?, lastName=?, age=?, email=? WHERE accountID=?");
        $statement_common->bind_param("ssisi", $fname, $lname, $age, $email, $_GET['accountID']);
        $statement_common->execute();
        
        if (isset($_POST['password']) && $_POST['password'] != ''){

            $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $statement_common = $connection->prepare("UPDATE tblaccount SET password=? WHERE accountID=?");
            $statement_common->bind_param("si", $hash_pass, $_GET['accountID']);
            $statement_common->execute();
        }

        header("location: ../profile.php");
    }
?>