<?php
    include 'connect.php';
?>

<link rel="stylesheet" type="text/css" href="css/event-detail-styles.css">

<body>
    <?php
        require_once 'includes/header.php';

        $statement_getEvent = $connection->prepare("SELECT * FROM tblevents WHERE eventID=?");
        $statement_getEvent->bind_param("i", $_GET['eventID']);
        $statement_getEvent->execute();
        $e = $statement_getEvent->get_result()->fetch_assoc();
    ?>
    <div class="main">
        
        <div class="content">
            
            <div class="ticket-nawng">
                <img src="images/events/<?=$e['image'];?>">
                <div class="event-name">
                    <?=$e['eventName'];?>
                </div>
            </div>
            
            <div class="ticket-nawng">
                <div class="details">
                    <div><?= date('d M', strtotime($e['date']));?></div>
                    <div><?= date('Y', strtotime($e['date']));?></div>
                    <div>
                        - <?= date('h:i A', strtotime($e['time'])); ?> -
                    </div>
                </div>

                <div class="details">
                    <div>
                        <img src="images/free-location-icon-2952-thumb.png" alt="">
                    </div>
                    <div>
                        <?=$e['venue'];?>
                    </div>
                </div>
                
                <div class="details">
                    <img src="images/barcode-scanning-solutions-for-dynamics-nav-dynamics-19.png" alt="">
                        <?=$e['eventType'];?>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="more-details">
                <h3>
                    ABOUT THE EVENT
                </h3>
                <p>
                    <?=$e['description'];?>
                </p>
            </div>
            <div class="more-details">
                <?php
                    if (!$_SESSION['isAdmin']) {
                        $statement_check = $connection->prepare("SELECT COUNT(id) AS naa FROM tbluserevents WHERE eventID=? AND userID=?");
                        $statement_check->bind_param("ii", $_GET['eventID'], $_SESSION['userID']);
                        $statement_check->execute();
                        $res = $statement_check->get_result();
                        $row = $res->fetch_assoc();

                        if ($row['naa'] == 0) {
                            echo ' 
                                <a class="wala" href="includes/joinEvent.php?eventID='.$_GET['eventID'].'&userID='.$_SESSION['userID'].'">
                                    Join Event!
                                </a>      
                            ';
                        } else {
                            echo ' 
                                <a class="naa" href="includes/cancel-join.php?eventID='.$_GET['eventID'].'&userID='.$_SESSION['userID'].'">
                                    Cancel Join Event
                                </a>      
                            ';
                        }
                    } 
                    
                    $statement_joins = $connection->prepare("SELECT tblaccount.username AS username, COUNT(tbluserevents.id) AS joiners 
                                                            FROM tblaccount 
                                                            INNER JOIN tbluseraccount ON tblaccount.accountID = tbluseraccount.accountID 
                                                            INNER JOIN tbluserevents ON tbluserevents.userID = tbluseraccount.userID 
                                                            WHERE tbluserevents.eventID = ? 
                                                            GROUP BY tblaccount.username");
                    $statement_joins->bind_param("i", $_GET['eventID']);
                    $statement_joins->execute();
                    $result_joins = $statement_joins->get_result();

                    $joiners = [];
                    while ($joiner = $result_joins->fetch_assoc()) {
                        $joiners[] = $joiner['username'];
                    }
                    
                    $joinerCount = count($joiners);
                    
                    echo '<h3>Join: ' . $joinerCount . '</h3>';
                    
                    // Display list of joiners
                    echo '<div class="joiners">';
                    foreach ($joiners as $username) {
                        echo '<p>' . $username . '</p>';
                    }
                    echo '</div>';
                ?>
            </div>

        </div>
    
    </div>
    
    <?php
        require_once 'includes/footer.php';
    ?>
</body>

<!-- <script>
    let image = document.getElementById('image');
    let height = "Height: " + image.clientHeight;
    let width = "Width: " + image.clientWidth;
    console.log(height);
    console.log(width);
</script> -->