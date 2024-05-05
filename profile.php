<?php
    include 'connect.php';
?>

<link rel="stylesheet" type="text/css" href="css/profile-styles.css">

<body>
    <?php
        require_once 'includes/header.php';
    ?>

    <div class="main">
    <!-- begin main  -->
        <div class="profile">

            <div class="pfp-container">

                <div class="pfp">
                <!-- start pfp -->
                    <div class="pfp-pic">
                        <img class="pic" src="images/FB_IMG_1595646904455.jpg">
                        <div class="pfp-border">
                            <img class="border" src="images/border.png">
                        </div>
                    </div>
                <!-- end pfp -->
                </div>
                <a href="edit-profile.php">
                    <div class="edit">
                        <img src="images/circle_edit_icon_212071.png">
                    </div>
                </a>

            </div>
            
            <div class="user-info">
                <?php
                    if ($_SESSION['isAdmin']){
                        $query = "SELECT firstName, lastName, username FROM tblaccount, tbladminaccount WHERE adminID=? AND tblaccount.accountID=tbladminaccount.accountID";
                        $statement = $connection->prepare($query);
                        $statement->bind_param("s", $_SESSION['adminID']);
                        $statement->execute();
                        $res = $statement->get_result();
                    } else {
                        $query = "SELECT firstName, lastName, username FROM tblaccount, tbluseraccount WHERE userID=? AND tblaccount.accountID=tbluseraccount.accountID";
                        $statement = $connection->prepare($query);
                        $statement->bind_param("s", $_SESSION['userID']);
                        $statement->execute();
                        $res = $statement->get_result();
                    }
                    $currUser = $res->fetch_array();
                    echo '
                        <div class="name">
                            '.$currUser['firstName'].' '.$currUser['lastName'].'
                        </div>
                        <div class="username">
                            '.$currUser['username'].'
                        </div>
                    ';
                ?>
            </div>

        </div>
        <div class="more-info">
                <div class="content">
                    <div class="inner-bar">
                        <div class="active" id="overview-tab">Overview</div>
                        <?php
                            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true){
                                echo '
                                    <div id="events-tab">Events</div>
                                ';
                            } else {
                                echo '
                                    <div id="events-tab">Joined Events</div>
                                ';
                            }
                        ?>
                        <script src="js/profile.js"></script>
                    </div>
                    <div class="overview">
                        <hr>
                        <div class="literal-overview">
                            <div class="most-event">
                                <?php
                                    if ($_SESSION['isAdmin']){
                                        echo '
                                            <span>
                                                Way Uyab Event
                                            </span>
                                            <span>
                                                Most Joined Event
                                            </span>
                                        ';
                                    } else {
                                        $statement_duolNa = $connection->prepare("SELECT eventName FROM tblevents INNER JOIN tbluserevents ON tblevents.eventID=tbluserevents.eventID AND tbluserevents.userID=? AND tblevents.date >= CURDATE() ORDER BY tblevents.date ASC, tblevents.time LIMIT 1");
                                        $statement_duolNa->bind_param("i", $_SESSION['userID']);
                                        $statement_duolNa->execute();
                                        $alarm = $statement_duolNa->get_result()->fetch_column();
                                        echo '
                                            <span>
                                                '.$alarm.'
                                            </span>
                                            <span>
                                                Next Upcoming Event
                                            </span>
                                        ';
                                    }
                                ?>
                            </div>
                            <div class="total-events">
                                <?php
                                    if ($_SESSION['isAdmin']){
                                        $statement_getTotalCreate = $connection->prepare("SELECT COUNT(eventID) AS TotalCreate FROM tblevents WHERE adminID=?");
                                        $statement_getTotalCreate->bind_param("i", $_SESSION['adminID']);
                                        $statement_getTotalCreate->execute();
                                        $total_create = $statement_getTotalCreate->get_result()->fetch_column();

                                        echo '
                                            <span>
                                                '.$total_create.'
                                            </span>
                                            <span>
                                                Total Events
                                            </span>
                                        ';
                                    } else {
                                        $statement_totalJoin = $connection->prepare("SELECT COUNT(id) AS TotalJoin FROM tbluserevents WHERE userID=?");
                                        $statement_totalJoin->bind_param("i", $_SESSION['userID']);
                                        $statement_totalJoin->execute();
                                        $total_join = $statement_totalJoin->get_result()->fetch_column();

                                        echo '
                                            <span>
                                                '.$total_join.'
                                            </span>
                                            <span>
                                                Total Joined Events
                                            </span>
                                        ';
                                    }
                                ?>
                            
                            </div>
                        </div>
                        <hr>
                        <?php
                            if ($_SESSION['isAdmin']){
                                echo '
                                    <span id="top-events">
                                        TOP EVENTS
                                    </span>
                                ';
                            } else {
                                echo '
                                    <span id="upcoming-events">
                                        UPCOMING EVENTS
                                    </span>
                                ';
                            }
                        ?>
                        <div class="list-top-events">
                            
                            <?php
                                if ($_SESSION['isAdmin']){
                                    $statement_topevents = $connection->prepare("SELECT tblevents.eventID, eventName, eventType, image, COUNT(tbluserevents.eventID) AS total_join 
                                                                                    FROM tblevents, tbluserevents
                                                                                    WHERE tblevents.adminID=? AND tblevents.date >= CURDATE() AND tbluserevents.eventID=tblevents.eventID
                                                                                    GROUP BY tbluserevents.eventID
                                                                                    ORDER BY COUNT(tbluserevents.eventID) DESC
                                                                                    ");
                                    $statement_topevents->bind_param("i", $_SESSION['adminID']);
                                    $statement_topevents->execute();
                                    $res_topevents = $statement_topevents->get_result();

                                    for ($i = 1; $i<=3 && $te = $res_topevents->fetch_assoc(); $i++){
                                        echo '    
                                            <a href="event-details.php?eventID='.$te['eventID'].'">                                        
                                                <div class="event-content">
                                                    <div class="count">
                                                        <div>
                                                            <div>#'.$i.'</div>
                                                            <div>'.$te['total_join'].' Joined</div>
                                                        </div>
                                                    </div>

                                                    <div class="event-pic">
                                                        <img src="images/events/'.$te['image'].'">
                                                        <div class="event-name">
                                                            <div>'.$te['eventName'].'</div>
                                                            <div>'.$te['eventType'].'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        ';
                                    }

                                } else {
                                    $statement_upcoming_events = $connection->prepare("SELECT tblevents.eventID, eventName, eventType, date, time, image FROM tblevents INNER JOIN tbluserevents ON tblevents.eventID=tbluserevents.eventID AND tbluserevents.userID=? AND tblevents.date >= CURDATE() ORDER BY tblevents.date ASC, tblevents.time ASC");
                                    $statement_upcoming_events->bind_param("i", $_SESSION['userID']);
                                    $statement_upcoming_events->execute();
                                    $res_upEvents = $statement_upcoming_events->get_result();

                                    while( $ue = $res_upEvents->fetch_assoc() ){
                                        echo '    
                                            <a href="event-details.php?eventID='.$ue['eventID'].'">
                                                <div class="event-content">
                                                    <div class="date-time">
                                                        <div>
                                                            <div>'.date('d M', strtotime($ue['date'])).'</font></div>
                                                            <div>'.date('h:i A', strtotime($ue['time'])).'</div>
                                                        </div>
                                                    </div>

                                                    <div class="event-pic">
                                                        <img src="images/events/'.$ue['image'].'">
                                                        <div class="event-name">
                                                            <div>'.$ue['eventName'].'</div>
                                                            <div>'.$ue['eventType'].'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                                
                                        ';
                                    }
                                }
                            ?>

                        </div>
                    </div>
                    <div class="admin-events">
                    <div class="list-top-events">
                        <?php
                            if ($_SESSION['isAdmin']){
                                $statement_adminEvents = $connection->prepare("SELECT eventID, eventName, eventType, image FROM tblevents WHERE adminID=? ORDER BY eventID DESC");
                                $statement_adminEvents->bind_param("i", $_SESSION['adminID']);
                                $statement_adminEvents->execute();
                                $res_adminEvents = $statement_adminEvents->get_result();

                                while($e = $res_adminEvents->fetch_assoc()){
                                    echo '
                                    
                                    <div class="event-content">
                                        
                                        <div class="event-pic">
                                            <a href="event-details.php?eventID='.$e['eventID'].'">
                                                <img src="images/events/'.$e['image'].'">
                                                    <div class="event-name">
                                                    <div>'.$e['eventName'].'</div>
                                                    <div>'.$e['eventType'].'</div>
                                                </div>    
                                            </a>
                                        </div>
                                        
                                        <div class="delete-update">
                                            <div>
                                                <a href="includes/deleteEvents.php?eventID='.$e['eventID'].'">
                                                    DELETE
                                                </a>
                                                <a href="edit-event.php?eventID='.$e['eventID'].'">
                                                    UPDATE
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            // <?php endwhile; 
                            } else {
                                $statement_userEvents = $connection->prepare("SELECT tblevents.eventID, eventName, eventType, image FROM tblevents INNER JOIN tbluserevents ON tblevents.eventID = tbluserevents.eventID AND tbluserevents.userID=? ORDER BY tblevents.date DESC, tblevents.time DESC");
                                $statement_userEvents->bind_param("i", $_SESSION['userID']);
                                $statement_userEvents->execute();
                                $res_userEvents = $statement_userEvents->get_result();

                                while($u = $res_userEvents->fetch_assoc()){
                                    echo ' 
                                        <div class="event-pic">
                                            <img src="images/events/'.$u['image'].'">
                                        
                                            <div class="event-name">
                                                <div>'.$u['eventName'].'</div>
                                                <div>'.$u['eventType'].'</div>
                                            </div>
                                        </div>
                                    ';
                                }
                            }
                        ?>
                    </div>
                    </div>
                </div>
        </div>

    <!-- end main -->
    </div>

    <?php
        require_once 'includes/footer.php';
    ?>
</body>