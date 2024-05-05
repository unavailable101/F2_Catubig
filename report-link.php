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
                <h1> Admin-Events </h1>
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

    </div>
    <?php
    	include('includes/footer.php');
    ?>
</body>