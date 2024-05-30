<?php
	include 'connect.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/events-styles.css">

<style>
    .for-events{
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: thin;
        scrollbar-color: #00FFFFFF;
    }
    .for-events .event-container{
        margin: 5px 10px;
    }
</style>

<body>
    <?php
    	include('includes/header.php');
    ?>

    <div class="main">
        <!-- kani sha kay mu appear if admin ka -->
        <!-- so make a condition where if the user's admin status 
            is admin, then appear;
            else not appear -->
        <?php
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true){
                
                echo '
                <div class="for-admin">
                    <a href="create-event.php">
                        <span>Create Event</span>
                    </a>
                    </div>
                    ';
                }
                // <a href="report-link.php">
                //     <span>Report</span>
                // </a>
        ?>    

            <h2>UPCOMING EVENTS</h2>
            
            <div class="for-events">

                <?php
                    $statement_upcoming_events = $connection->prepare("SELECT eventID, eventName, eventType, date, time, image, isDelete FROM tblevents WHERE date >= CURDATE() ORDER BY date ASC, time ASC");
                    $statement_upcoming_events->execute();
                    $res_upEvents = $statement_upcoming_events->get_result();

                    while ($e = $res_upEvents->fetch_assoc()):
                        if (!$e['isDelete']):
                ?>

                <div class="event-container">
                    <div class="event-bg">
                        <img src = "images/events/<?=$e['image'];?>">
                        <a class="view-details" href="event-details.php?eventID=<?=$e['eventID'];?>">View Details</a>
                        <div class="event-infos">
                            <div class="the-event">
                                <?=$e['eventName'];?>
                            </div>
                            <div class="the-event">
                                <div class="event-details">
                                    <span>
                                        <?=$e['eventType'];?>
                                    </span>
                                    <br>
                                    <!-- <br> -->
                                    <?php
                                        if (!$_SESSION['isAdmin']){
                                            if (!isJoin($connection, $e['eventID'])){
                                                echo '
                                                    <a class="not-joined" href="includes/joinEvent.php?userID='.$_SESSION['userID'].'&eventID='.$e['eventID'].'">
                                                        Join
                                                    </a>
                                                ';
                                            } else {
                                                echo '
                                                    <a class="has-joined">
                                                        Already Joined
                                                    </a>
                                                ';
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="event-details">
                                    <div>Date: <?= date('d M Y',strtotime($e['date']));?></div>
                                    <div>Time:  <?= date('h:i A', strtotime($e['time']));?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <h2>POPULAR EVENTS</h2>

            <div class="for-events">

                <?php
                        $statement_popular_events = $connection->prepare("SELECT tblevents.eventID, eventName, eventType, date, time, image, isDelete, COUNT(tbluserevents.eventID) AS total_join 
                                                                            FROM tblevents, tbluserevents
                                                                            WHERE tblevents.date >= CURDATE() AND tbluserevents.eventID=tblevents.eventID
                                                                            GROUP BY tbluserevents.eventID
                                                                            ORDER BY COUNT(tbluserevents.eventID) DESC");
    
                        $statement_popular_events->execute();
                        $res_popEvents = $statement_popular_events->get_result();
    
                        while ($e = $res_popEvents->fetch_assoc()):
                            if (!$e['isDelete']):
                    ?>
    
                    <div class="event-container">
                        <div class="event-bg">
                            <img src = "images/events/<?=$e['image'];?>">
                            <a class="view-details" href="event-details.php?eventID=<?=$e['eventID'];?>">View Details</a>
                            <div class="event-infos">
                                <div class="the-event">
                                    <?=$e['eventName'];?>
                                </div>
                                <div class="the-event">
                                    <div class="event-details">
                                        <span>
                                            <?=$e['eventType'];?>
                                        </span>
                                        <br>
                                        <!-- <br> -->
                                        <?php
                                            if (!$_SESSION['isAdmin']){
                                                if (!isJoin($connection, $e['eventID'])){
                                                    echo '
                                                        <a class="not-joined" href="includes/joinEvent.php?userID='.$_SESSION['userID'].'&eventID='.$e['eventID'].'">
                                                            Join
                                                        </a>
                                                    ';
                                                } else {
                                                    echo '
                                                        <a class="has-joined">
                                                            Already Joined
                                                        </a>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="event-details">
                                        <div>Date: <?= date('d M Y',strtotime($e['date']));?></div>
                                        <div>Time:  <?= date('h:i A', strtotime($e['time']));?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <?php endif; ?>
                    <?php endwhile; ?>
            </div>
            
            <?php
                $statement_public_events = $connection->prepare("SELECT eventID, eventName, eventType, date, time, image, isDelete
                FROM tblevents
                WHERE eventType=?");
            ?>

            <h2>PUBLIC EVENTS</h2>

            <div class="for-events">

                <?php
                        $param = 'PUBLIC';
                        $statement_public_events->bind_param("s", $param);
                        $statement_public_events->execute();
                        $res_pubEvents = $statement_public_events->get_result();
    
                        while ($e = $res_pubEvents->fetch_assoc()):
                            if (!$e['isDelete']):
                    ?>
    
                    <div class="event-container">
                        <div class="event-bg">
                            <img src = "images/events/<?=$e['image'];?>">
                            <a class="view-details" href="event-details.php?eventID=<?=$e['eventID'];?>">View Details</a>
                            <div class="event-infos">
                                <div class="the-event">
                                    <?=$e['eventName'];?>
                                </div>
                                <div class="the-event">
                                    <div class="event-details">
                                        <span>
                                            <?=$e['eventType'];?>
                                        </span>
                                        <br>
                                        <!-- <br> -->
                                        <?php
                                            if (!$_SESSION['isAdmin']){
                                                if (!isJoin($connection, $e['eventID'])){
                                                    echo '
                                                        <a class="not-joined" href="includes/joinEvent.php?userID='.$_SESSION['userID'].'&eventID='.$e['eventID'].'">
                                                            Join
                                                        </a>
                                                    ';
                                                } else {
                                                    echo '
                                                        <a class="has-joined">
                                                            Already Joined
                                                        </a>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="event-details">
                                        <div>Date: <?= date('d M Y',strtotime($e['date']));?></div>
                                        <div>Time:  <?= date('h:i A', strtotime($e['time']));?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <?php endif; ?>
                    <?php endwhile; ?>
            </div>

            <h2>SEMI-PUBLIC EVENTS</h2>

            <div class="for-events">

                <?php
                        $param = 'SEMI-PUBLIC';
                        $statement_public_events->bind_param("s", $param);
                        $statement_public_events->execute();
                        $res_pubEvents = $statement_public_events->get_result();
    
                        while ($e = $res_pubEvents->fetch_assoc()):
                            if (!$e['isDelete']):
                    ?>
    
                    <div class="event-container">
                        <div class="event-bg">
                            <img src = "images/events/<?=$e['image'];?>">
                            <a class="view-details" href="event-details.php?eventID=<?=$e['eventID'];?>">View Details</a>
                            <div class="event-infos">
                                <div class="the-event">
                                    <?=$e['eventName'];?>
                                </div>
                                <div class="the-event">
                                    <div class="event-details">
                                        <span>
                                            <?=$e['eventType'];?>
                                        </span>
                                        <br>
                                        <!-- <br> -->
                                        <?php
                                            if (!$_SESSION['isAdmin']){
                                                if (!isJoin($connection, $e['eventID'])){
                                                    echo '
                                                        <a class="not-joined" href="includes/joinEvent.php?userID='.$_SESSION['userID'].'&eventID='.$e['eventID'].'">
                                                            Join
                                                        </a>
                                                    ';
                                                } else {
                                                    echo '
                                                        <a class="has-joined">
                                                            Already Joined
                                                        </a>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="event-details">
                                        <div>Date: <?= date('d M Y',strtotime($e['date']));?></div>
                                        <div>Time:  <?= date('h:i A', strtotime($e['time']));?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <?php endif; ?>
                    <?php endwhile; ?>
            </div>

            <h2>PRIVATE EVENTS</h2>

            <div class="for-events">

                <?php
                        $param = 'PRIVATE';
                        $statement_public_events->bind_param("s", $param);
                        $statement_public_events->execute();
                        $res_pubEvents = $statement_public_events->get_result();
    
                        while ($e = $res_pubEvents->fetch_assoc()):
                            if (!$e['isDelete']):
                    ?>
    
                    <div class="event-container">
                        <div class="event-bg">
                            <img src = "images/events/<?=$e['image'];?>">
                            <a class="view-details" href="event-details.php?eventID=<?=$e['eventID'];?>">View Details</a>
                            <div class="event-infos">
                                <div class="the-event">
                                    <?=$e['eventName'];?>
                                </div>
                                <div class="the-event">
                                    <div class="event-details">
                                        <span>
                                            <?=$e['eventType'];?>
                                        </span>
                                        <br>
                                        <!-- <br> -->
                                        <?php
                                            if (!$_SESSION['isAdmin']){
                                                if (!isJoin($connection, $e['eventID'])){
                                                    echo '
                                                        <a class="not-joined" href="includes/joinEvent.php?userID='.$_SESSION['userID'].'&eventID='.$e['eventID'].'">
                                                            Join
                                                        </a>
                                                    ';
                                                } else {
                                                    echo '
                                                        <a class="has-joined">
                                                            Already Joined
                                                        </a>
                                                    ';
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="event-details">
                                        <div>Date: <?= date('d M Y',strtotime($e['date']));?></div>
                                        <div>Time:  <?= date('h:i A', strtotime($e['time']));?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <?php endif; ?>
                    <?php endwhile; ?>
            </div>

        <!-- <center>
            HELLO PIPOL!
        </center> -->

        <!-- <?php
            $ctr = 1;
            $sql_events ="Select * from tblevents";
            $all_events = mysqli_query($connection,$sql_events);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                    <th>Event Type</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php
                    while($row = $all_events->fetch_assoc()):
                ?>
            
                <tr>
                    <td><?= $ctr++; ?> </td>
                    <td><?= $row['eventName']; ?> </td>
                    <td><?= $row['eventType']; ?> </td>
                    <td><?= $row['date']; ?> </td>
                    <td><?= $row['time']; ?> </td>
                    <td><?= $row['venue']; ?> </td>
                    <td>
                        <a href="includes/deleteEvents.php?eventID=<?=$row['eventID'];?>" >Delete</a>
                    </td>
                </tr>
                
                <?php endwhile;?>
                
            </tbody>
        </table>

        <?php
            $ctr = 1;
            $sql_admin ="SELECT * FROM tbladminaccount";
            $all_admin = mysqli_query($connection,$sql_admin);
        ?>

        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Admins </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php while($row = $all_admin->fetch_assoc()): 
             
                    $sql_account ="SELECT * FROM tblaccount WHERE accountID='".$row['accountID']."'";
                    $account_result = mysqli_query($connection,$sql_account);
                    $admin_account = mysqli_fetch_array($account_result);
                
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $admin_account['firstName']; ?> </td>
                    <td> <?= $admin_account['lastName']; ?> </td>
                    <td> <?= $admin_account['username']; ?> </td>
                    <td>
                        <a href="includes/deleteAdmin.php?adminID=<?=$row['accountID'];?>" >Delete</a>
                    </td>
                    
                </tr>
                
                <?php endwhile;?>
                
            </tbody>
        </table>
        
        <?php
            $ctr = 1;
            $sql_user ="SELECT * FROM tbluseraccount";
            $all_user = mysqli_query($connection,$sql_user);
        ?>

        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Users </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php while($row = $all_user->fetch_assoc()): 
             
                    $sql_account ="SELECT * FROM tblaccount WHERE accountID='".$row['accountID']."'";
                    $account_result = mysqli_query($connection,$sql_account);
                    $user_account = mysqli_fetch_array($account_result);
                
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $user_account['firstName']; ?> </td>
                    <td> <?= $user_account['lastName']; ?> </td>
                    <td> <?= $user_account['username']; ?> </td>
                    <td>
                    <a href="includes/deleteUser.php?userID=<?=$row['accountID'];?>" >Delete</a>
                    </td>
                </tr>
                
                <?php endwhile;?>
                
            </tbody>
        </table> -->

    </div>

    <?php
    	include('includes/footer.php');
    ?>
</body>
