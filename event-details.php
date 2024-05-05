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
                    $statement_check = $connection->prepare("SELECT COUNT(id) AS naa FROM tbluserevents WHERE eventID=? AND userID=?");
                    $statement_check->bind_param("ii", $_GET['eventID'], $_SESSION['userID']);
                    $statement_check->execute();
                    $res = $statement_check->get_result()->fetch_column();
                    
                    if (!$res){
                        echo ' 
                            <a class="wala" href="includes/joinEvent.php?eventID='.$e['eventID'].'&userID='.$_SESSION['userID'].'">
                                Join Event!
                            </a>      
                        ';
                    } else {
                        echo ' 
                            <a class="naa">
                                Already Joined Event
                            </a>      
                        ';
                    }
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