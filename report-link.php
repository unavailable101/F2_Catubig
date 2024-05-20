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



    <center>
        <h1>REPORT PAGE</h1>
    </center>
        
        <!-- Deleted Accounts -->
        <?php
            $ctr = 1;  
            $sql_deleteAccount ="SELECT accountID, firstName, lastName, username, isDelete 
                            FROM tblaccount 
                            WHERE isDelete = 1
            ";
            $deleteAccount_result = mysqli_query($connection,$sql_deleteAccount);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Delete Accounts </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th></th>
                    <!-- <th>Username</th> -->
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $deleteAccount_result->fetch_assoc()):
                        $counter = ($row['isDelete'] == 1) ? "text-confirm": "text-danger";
                        $archiveStatus = $row["isDelete"] == 1 ?"Archive" : "Archived";  
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['firstName'].' '. $row['lastName']; ?> </td>
                    <td> <?= $row['username']; ?> </td>
                    <td> <a href="includes/activateAccount.php?accountID=<?=$row['accountID'];?>" class="btn btn-success">Activate User</a> </td>
                    <!-- <td> <?= $row['username']; ?> </td> -->
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
        

        <!-- Archived Events -->
        <?php
            $ctr = 1;  
            $sql_archiveEvents ="SELECT eventID, eventName, eventType, date, isDelete 
                            FROM tblevents 
                            WHERE isDelete = 1
            ";
            $archiveEvents_result = mysqli_query($connection,$sql_archiveEvents);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Archive Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                    <th>Event Type</th>
                    <th>Event Date</th>
                    <th></th>
                    <!-- <th>Username</th> -->
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $archiveEvents_result->fetch_assoc()):
                        $counter = ($row['isDelete'] == 1) ? "text-confirm": "text-danger";
                        $archiveStatus = $row["isDelete"] == 1 ?"Archive" : "Archived";  
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['eventName']; ?> </td>
                    <td> <?= $row['eventType']; ?> </td>
                    <td> <?= date('M d, Y', strtotime($row['date'])); ?> </td>
                    <td> <a href="includes/enableEvents.php?eventID=<?=$row['eventID'];?>" class="btn btn-success">Enable Event</a> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
        
        <!-- MOST JOINED EVENTS -->
        <!-- <?php
            $ctr = 1;  
            $sql_mostJoin ="SELECT username, COUNT(tbluserevents.userID) AS total
                            FROM tblaccount
                            INNER JOIN tbluseraccount ON tblaccount.accountID = tbluseraccount.accountID AND tblaccount.isDelete=0
                            INNER JOIN tbluserevents ON tbluserevents.userID = tbluseraccount.userID
                            INNER JOIN tblevents ON tbluserevents.eventID = tblevents.eventID AND tblevents.isDelete=0
                            GROUP BY username
            ";
            $mostJoin_result = mysqli_query($connection,$sql_mostJoin);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Joined Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Username</th>
                    <th>Number of Events Joined</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $mostJoin_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['username']; ?> </td>
                    <td> <?= $row['total']; ?> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table> -->
                        <!-- MOST JOINED Organization -->
        <?php
            $ctr = 1;   
            $sql_joinOrgs ="SELECT organizationName, COUNT(tbladminorganization.organizationID) AS total
                            FROM tblorganization
                            INNER JOIN tbladminorganization
                            ON tbladminorganization.organizationID = tblorganization.organizationID
                            INNER JOIN tbladminaccount
                            ON tbladminorganization.adminID = tbladminaccount.adminID
                            INNER JOIN tblaccount
                            ON tbladminaccount.accountID = tblaccount.accountID AND isDelete=0
                            GROUP BY organizationName
            ";
            $joinOrgs_result = mysqli_query($connection,$sql_joinOrgs);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Joined Organization</h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Organization Name</th>
                    <th>Number of Join</th>
                    <!-- <th>Username</th> -->
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $joinOrgs_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['organizationName']; ?> </td>
                    <td> <?= $row['total']; ?> </td>
                    <!-- <td> <?= $row['username']; ?> </td> -->
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
                        <!-- NUMBER OF USERS JOINED THE EVENTS -->
        <?php
            $ctr = 1;   
            $sql_numberJoin ="SELECT eventName, COUNT(tbluserevents.eventID) AS total
                            FROM tblevents
                            INNER JOIN tbluserevents
                            ON tbluserevents.eventID = tblevents.eventID
                            WHERE isDelete=0
                            GROUP BY eventName
            ";
            $numberJoin_result = mysqli_query($connection,$sql_numberJoin);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Users Joined the Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                    <th>Number of Join</th>
                    <!-- <th>Username</th> -->
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $numberJoin_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['eventName']; ?> </td>
                    <td> <?= $row['total']; ?> </td>
                    <!-- <td> <?= $row['username']; ?> </td> -->
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
                        <!-- NUMBER OF UPCOMING EVENTS -->
        <?php
            $monthNames = array(
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
                7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
            );
            $ctr = 1;   
            $sql_releaseDate = "SELECT COUNT(eventID) AS count, MONTH(date) AS release_months, YEAR(date) AS release_year 
                                FROM tblevents
                                WHERE date >= CURDATE() AND isDelete=0
                                GROUP BY MONTH(date), 
                                        YEAR(date)
                                ORDER BY 
                                        release_year ASC,
                                        MONTH(date) ASC
                                ";
            $releaseDate_result = mysqli_query($connection, $sql_releaseDate);  
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Upcoming Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Date</th>
                    <th>Joined</th>
                    <!-- <th>Username</th> -->
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $releaseDate_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $monthNames[(int)$row['release_months']] . ' ' . $row['release_year']; ?> </td>
                    <td> <?= $row['count']; ?> </td>
                    <!-- date('d M', strtotime($ue['date'])) -->
                    <!-- <td> <?= $row['username']; ?> </td> -->
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
        
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
                            WHERE isDelete=0
                            GROUP BY eventType";
            $eventType_result = mysqli_query($connection,$sql_eventType);
            $res;
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Event Types </h1>
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
                <!-- <tr>
                    <td colspan="2">AVERAGE</td>
                    <td> <?= $res; ?> </td>
                </tr> -->
            </tbody>
        </table> 
        
        <center>
            <h1>
                Chart For Event Types
            </h1>
            <?php
                $sql = "SELECT COUNT(eventType) as public_type FROM tblevents WHERE eventType = 'Public'";
                $eventType1_result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($eventType1_result);
                $public_type = $row["public_type"];

                $sql = "SELECT COUNT(eventType) as private_type FROM tblevents WHERE eventType = 'Private'";
                $eventType2_result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($eventType2_result);
                $private_type = $row["private_type"];

                $sql = "SELECT COUNT(eventType) as semi_type FROM tblevents WHERE eventType = 'Semi-Public'";
                $eventType3_result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($eventType3_result);
                $semi_type = $row["semi_type"];
            ?>

            <!-- Include Chart.js library -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <div class="chart">
                <canvas id="eventTypeChart" width="50" height="50"></canvas>
            </div>
            <script>
                var ctx = document.getElementById('eventTypeChart').getContext('2d');

                var eventTypeChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Public', 'Semi-Public', 'Private'],
                        datasets: [{
                            label: '# of Events by Type',
                            data: [<?php echo $public_type; ?>, <?php echo $private_type; ?>, <?php echo $semi_type; ?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });
            </script>
        </center>


        <!-- <?php
            $ctr = 1;  
            $sql_mostJoin ="SELECT username, COUNT(tbluserevents.userID) AS total
                            FROM tblaccount
                            INNER JOIN tbluseraccount ON tblaccount.accountID = tbluseraccount.accountID AND tblaccount.isDelete=0
                            INNER JOIN tbluserevents ON tbluserevents.userID = tbluseraccount.userID
                            INNER JOIN tblevents ON tbluserevents.eventID = tblevents.eventID AND tblevents.isDelete=0
                            GROUP BY username
            ";
            $mostJoin_result = mysqli_query($connection,$sql_mostJoin);
        ?> 
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Joined Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Username</th>
                    <th>Number of Events Joined</th>
            </thead>
            <tbody>

                <?php 
                    while($row = $mostJoin_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['username']; ?> </td>
                    <td> <?= $row['total']; ?> </td>
                     <td> <?= $row['username']; ?> </td> 
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>

        <?php
            $ctr = 1;   
            $sql_mostJoin ="SELECT organizationName, COUNT(tbladminorganization.organizationID) AS total
                            FROM tblorganization
                            INNER JOIN tbladminorganization
                            ON tbladminorganization.organizationID = tblorganization.organizationID
                            INNER JOIN tbladminaccount
                            ON tbladminorganization.adminID = tbladminaccount.adminID
                            INNER JOIN tblaccount
                            ON tbladminaccount.accountID = tblaccount.accountID AND isDelete=0
                            GROUP BY organizationName
            ";
            $mostJoin_result = mysqli_query($connection,$sql_mostJoin);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Joined Organization</h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Organization Name</th>
                    <th>Number of Join</th>
                     <th>Username</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $mostJoin_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['organizationName']; ?> </td>
                    <td> <?= $row['total']; ?> </td>
                     <td> <?= $row['username']; ?> </td> 
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>

        <?php
            $ctr = 1;   
            $sql_mostJoin ="SELECT eventName, COUNT(tbluserevents.eventID) AS total
                            FROM tblevents
                            INNER JOIN tbluserevents
                            ON tbluserevents.eventID = tblevents.eventID
                            WHERE isDelete=0
                            GROUP BY eventName
            ";
            $mostJoin_result = mysqli_query($connection,$sql_mostJoin);
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Users Joined the Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Name</th>
                    <th>Number of Join</th>
                    
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $mostJoin_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $row['eventName']; ?> </td>
                    <td> <?= $row['total']; ?> </td>
                   
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
                    -->
        <!-- <?php
            $monthNames = array(
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
                7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
            );
            $ctr = 1;   
            $sql_releaseDate = "SELECT COUNT(eventID) AS count, MONTH(date) AS release_months, YEAR(date) AS release_year 
                        FROM tblevents
                        WHERE date >= CURDATE() AND isDelete=0
                        GROUP BY MONTH(date), 
                                YEAR(date)
                        ORDER BY 
                                release_year ASC,
                                MONTH(date) ASC
                                ";
            $releaseDate_result = mysqli_query($connection, $sql_releaseDate);  
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Number of Upcoming Events </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Date</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>

                <?php 
                    while($row = $releaseDate_result->fetch_assoc()): 
                ?>
            
                <tr>
                    <td> <?= $ctr++; ?> </td>
                    <td> <?= $monthNames[(int)$row['release_months']] . ' ' . $row['release_year']; ?> </td>
                    <td> <?= $row['count']; ?> </td>
                </tr>
                
            <?php endwhile;?>        
            </tbody>
        </table>
        
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
                            WHERE isDelete=0
                            GROUP BY eventType";
            $eventType_result = mysqli_query($connection,$sql_eventType);
            $res;
        ?>
        <table class="table" cellspacing="1" width="75%">
            <center>
                <h1> Event Types </h1>
            </center>
            <thead>
                <tr>
                    <th>Seq. No.</th>
                    <th>Event Type</th>
                    <th>Number of Events</th>
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
                </tr>
                
            <?php endwhile;?> 
                    <td colspan="2">AVERAGE</td>
                    <td> <?= $res; ?> </td>
                </tr> 
            </tbody>
        </table>  -->


        <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <center>
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////////////////
        </center>
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