<?php
	include 'connect.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
                    <a href="#">
                        <span>Your Events</span>
                    </a>
                </div>
                ';
            }
        ?>    
        <?php
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
        </table>

    </div>

    <?php
    	include('includes/footer.php');
    ?>
</body>
