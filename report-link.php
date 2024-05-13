<?php
    include 'connect.php';
?>
<link href="css/create-event.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
    <?php
    	include('includes/header.php');
    ?>
    <div class="main">

        <?php
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true){
                
                echo '
                <div class="for-admin">
                    <a href="create-event.php">
                        <span>Create Event</span>
                    </a>
                    <a href="report-link.php">
                        <span>Report</span>
                    </a>
                </div>
                ';
            }
        ?>
        
        <!-- ambot mao bha ni imo gusto -->
        <?php
            $ctr = 1;   
            $sql_eventType ="SELECT eventType, COUNT(eventType) AS types, (
                                                                            SELECT AVG(types) 
                                                                            FROM (
                                                                                -- ni-select sa event type niya gi-count
                                                                                SELECT COUNT(eventType) AS types 
                                                                                FROM tblevents 
                                                                                GROUP BY eventType
                                                                            ) AS avg_counts
                                                                        ) AS average 
                            FROM tblevents
                            GROUP BY eventType";
            // kuan nlng ni, total number of eventtype then averge user join this type of event
            // $sql_eventType ="SELECT 
            //                     eventType, 
            //                     COUNT(eventType) AS types
            //                     AVG(types) AS average
            //                 FROM 
            //                     tblevents
            //                 GROUP BY 
            //                     eventType
            //                 ";
            $eventType_result = mysqli_query($connection,$sql_eventType);
            $res;
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Average Event Types </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Type</th>
                    <th>Number of Events</th>
                    <!-- <th>Average</th> -->
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $eventType_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['eventType']; ?> </td>
                    <td> <?= $row['types']; ?> </td>
                    <!-- <td> <?php $res = $row['average']; ?> </td> -->
                </tr>
                
            <?php endwhile;?>  
                <tr>
                    <td colspan="2">AVERAGE</td>
                    <td> <?= $res; ?> </td>
                </tr>
            </tbody>
        </table> 

        <?php
            $ctr = 1;   
            $sql_account ="SELECT tblaccount.firstName, tblaccount.lastName, tblaccount.username FROM tblaccount INNER JOIN tbluseraccount ON tblaccount.accountID = tbluseraccount.accountID";
            $account_result = mysqli_query($connection,$sql_account);
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
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $account_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['firstName']; ?> </td>
                    <td> <?= $row['lastName']; ?> </td>
                    <td> <?= $row['username']; ?> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>

        <?php
            $ctr = 1;   
            $sql_totalevents ="SELECT tblaccount.firstName, tblaccount.lastName, COUNT(tblevents.eventID) AS Total 
                                FROM tblaccount
                                INNER JOIN tbladminaccount ON tblaccount.accountID = tbladminaccount.accountID 
                                LEFT JOIN tblevents ON tbladminaccount.adminID = tblevents.adminID 
                                GROUP BY tblaccount.firstName, tblaccount.lastName";
            $totalevents_result = mysqli_query($connection,$sql_totalevents);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Admin and Events Created </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Admin Name</th>
                    <th>Total Number of Created Events</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($te = $totalevents_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $te['firstName']. ' ' .$te['lastName'] ; ?> </td>
                    <td> <?= isset($te['Total']) ? $te['Total'] : 0; ?> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
        
        <?php
            $ctr = 1;   
            $sql_theEvent ="SELECT tblaccount.username, tblevents.eventName, COUNT(tbluserevents.id) AS total
                            FROM tblevents
                            LEFT JOIN tbluserevents ON tblevents.eventID=tbluserevents.eventID
                            LEFT JOIN tbladminaccount ON tblevents.adminID=tbladminaccount.adminID
                            LEFT JOIN tblaccount ON tblaccount.accountID=tbladminaccount.accountID
                            GROUP BY tblevents.eventName
                            ORDER BY tblevents.eventName ASC";
                                            
            $theEvent_result = mysqli_query($connection,$sql_theEvent);
        ?>


        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Events with Creator and Total Join </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                    <th>Creator / Admin</th>
                    <th>Total Number Who Joined The Event</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($te = $theEvent_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $te['eventName']; ?> </td>
                    <td> <?= $te['username'] ;?> </td>
                    <td> <?= isset($te['total']) ? $te['total'] : 0; ?> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>

        <?php
            $ctr = 1;   
            $sql_joinOrg ="SELECT tblaccount.username, COUNT(tbladminorganization.id) AS total
                            FROM tblorganization
                            INNER JOIN tbladminorganization ON tbladminorganization.organizationID=tblorganization.organizationID
                            INNER JOIN tbladminaccount ON tbladminorganization.adminID=tbladminaccount.adminID
                            INNER JOIN tblaccount ON tblaccount.accountID=tbladminaccount.accountID
                            GROUP BY tbladminaccount.adminID
                            ORDER BY tbladminaccount.adminID ASC";
                                            
            $joinOrg_result = mysqli_query($connection,$sql_joinOrg);
        ?>


        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Admins with Total Join of Organization </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Admin Username</th>
                    <th>Total Number of Joined Organization</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($jo = $joinOrg_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $jo['username'] ;?> </td>
                    <td> <?= isset($jo['total']) ? $jo['total'] : 0; ?> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>

        <!-- anaaaa -->
        <?php
            $ctr = 1;
            $sql_events ="Select eventName, eventType from tblevents";
            $all_events = mysqli_query($connection,$sql_events);
        ?>

        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> All Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                    <th>Event Type</th>
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
                    <!-- <td><?= $row['date']; ?> </td>
                    <td><?= $row['time']; ?> </td>
                    <td><?= $row['venue']; ?> </td> -->
                </tr>
                
                <?php endwhile;?>
                
            </tbody>
        </table>


        <!-- //////////////////////////////////////////////////// -->
        <?php
            $ctr = 1;
            // $sql_events ="Select * from tblevent";
            // $sql_events = "SELECT tblevent.eventID, tblevent.eventName, tblevent.eventType, tblevent.date, tblevent.time, tblevent.venue FROM tblevent INNER JOIN tbladminaccount ON tblevent.adminID = tbladminaccount.adminID";
            $sql_events = "SELECT eventName FROM tblevents WHERE adminID=".$_SESSION['adminID']." ORDER BY eventID DESC";
            $all_events = mysqli_query($connection,$sql_events);
        ?>

        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> By You </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    while($row = $all_events->fetch_assoc()):
                ?>
            
                <tr>
                    <td><?= $ctr++; ?> </td>
                    <td><?= $row['eventName']; ?> </td>
                </tr>
                
                <?php endwhile;?>
                
            </tbody>
        </table>

        <?php
            $ctr = 1;
            $sql_orgs ="SELECT age, username FROM tblaccount WHERE age <=20";
            $all_orgs = mysqli_query($connection, $sql_orgs);
        ?>

        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Accounts by Age </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Age</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = $all_orgs->fetch_assoc()):
                ?>
            
                <tr>
                    <td><?= $ctr++; ?> </td>
                    <td><?= $row['age']; ?> </td>
                    <td><?=$row['username'];?></td>
                </tr>
                
                <?php endwhile;?>
                
            </tbody>
        </table>

        <!-- all admins count -->
        <?php
        
            $sql_events = "SELECT count(adminID) FROM tbladminaccount";
            $all_events = mysqli_query($connection,$sql_events);
        ?>
        <center>
            <h1>Number of Admins</h1>
            <h2><?=$all_events->fetch_column()?></h2>
        </center>

    </div>
    <?php
    	include('includes/footer.php');
    ?>
</body>