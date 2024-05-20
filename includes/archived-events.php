<?php
    include("../connect.php");
    // $eventName = $_GET['eventName'];
    // $eventID = $_GET['eventID'];
    // $res = NULL;

    $sql_query = "SELECT eventID, eventName, eventType, date, isDelete FROM tblevents WHERE isDelete = 1";
    try {
        $res = mysqli_query($conn, $sql_query);
    }catch(Exception $e) {
        echo "
            <script>
                console.log('Something went wrong...');
            </script>
        ";
    }
?>
<table  class="table" cellspacing="1" width="75%">
    <?php
        $ctr = 1;
        while ($row = mysqli_fetch_array($res)) {
            $counter = ($row['isDelete'] == 1) ? "text-confirm": "text-danger";
            $archiveStatus = $row["isDelete"] == 1 ?"Archive" : "Archived";
            echo'
            <tr>
                <td>'.$ctr++.'</td>
                <td class = "'.$counter.'">'.$archiveStatus.'</td>
                <td><a href="includes/deleteEvents.php?eventStatus='.$row['eventID'].'&eventName='.$eventName.'&eventID='.$eventID.'" class="btn btn-success">Enable Event</a></td>
            </tr>';
        }
    ?>
</table>