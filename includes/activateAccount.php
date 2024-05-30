<?php
    include '../connect.php';

    $sql_updateStatus = $connection->prepare("UPDATE tblaccount SET isDelete=0 WHERE accountID=?");
    $sql_updateStatus->bind_param("i", $_GET['accountID']);
    $sql_updateStatus->execute();

    $query1 = "SELECT isAdmin from tbladminstatus WHERE accountID=?";
    $statement1 = $connection->prepare($query1);
    $statement1->bind_param("s", $account_row['accountID']);
    $statement1->execute();
    $res1 = $statement1->get_result();
    $isExist = $res1->fetch_array();

    if ($isExist['isAdmin']){
        $query_admin = "SELECT adminID FROM tbladminaccount WHERE accountID=?";
        $statement_admin = $connection->prepare($query_admin);
        $statement_admin->bind_param("s", $_GET['accountID']);
        $statement_admin->execute();
        $res_admin = $statement_admin->get_result();
        $admin_row = $res_admin->fetch_array();

        $_SESSION['isAdmin'] = true;
        $_SESSION['adminID'] = $admin_row['adminID'];
        $_SESSION['username']=$_GET['username'];
    } else {
        $query_user = "SELECT userID FROM tbluseraccount WHERE accountID=?";
        $statement_user = $connection->prepare($query_user);
        $statement_user->bind_param("s", $_GET['accountID']);
        $statement_user->execute();
        $res_user = $statement_user->get_result();
        $user_row = $res_user->fetch_array();
            
        $_SESSION['isAdmin']=false;
        $_SESSION['userID']=$user_row['userID'];
        $_SESSION['username']=$_GET['username'];
    }
    // $_SESSION['isAdmin']=$isExist['isAdm'];
    // $_SESSION['userID']=$user_row['userID'];
    // $_SESSION['username']=$account_row['username'];

    // header("location: ../report-link.php");
    header("location: ../index.php");

?>