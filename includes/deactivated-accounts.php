<?php
    include("../connect.php");
    $username = $_GET['username'];
    $accountID = $_GET['accountID'];
    $res = NULL;

    $sql_query = "SELECT accountID, username, isDelete FROM tblaccount WHERE accountID != '.$username.' && isDelete = 1";
    try {
        $res = mysqli_query($conn, $sql_query);
    }catch(Exception $e) {
        echo "Something went wrong...";
    }

    $ctr = 1;
    while ($row = mysqli_fetch_array($res)) {
        $counter = ($row['isDeleted'] == 1) ? "text-confirm": "text-danger";
        $activeStatus = $row["isDeleted"] == 1 ?"Archive" : "Archived";
        echo'
        <tr>
            <td>'.$ctr++.'</td>
            <td class = "'.$counter.'">'.$activeStatus.'</td>
            <td><a href="includes/deleteAccount.php?isDeleted='.$row['accountID'].'&username='.$username.'&accountID='.$accountID.'" class="btn btn-success">Activate User</a></td>
        </tr>';
    }
?>