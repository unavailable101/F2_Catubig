<?php
    session_start();
	include 'connect.php';
?>

<head>
    <meta charset="UTF-8">
    <title>CONquest: Event Planner</title>
    <link href="css/common-style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <?php
    	include('includes/header.php');
    ?>

    <div class="main">
        <!-- kani sha kay mu appear if admin ka -->
        <!-- so make a condition where if the user's admin status 
            is admin, then appear;
            else not appear -->
        <div class="for-admin">
            <a href="create-event.php">
                <span>Create Event</span>
            </a>
            <a href="#">
                <span>Your Events</span>
            </a>
        </div>
        <!-- an option and can be true to all types of users -->
        <!-- temporary lng kay para naa lang ma pass -->
        <table class="table">
            <tr>
                <th>Seq. No.</th>
                <th>Event Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th>Event Type</th>
            </tr>
            <tr>
                <td>0</td>
                <td>Test Event</td>
                <td>10/15/03</td>
                <td>1:06pm</td>
                <td>Cebu City, Waterfront Hotel</td>
                <td>Way Lingaw</td>
            </tr>
        </table>
    
    </div>

    <?php
    	include('includes/footer.php');
    ?>
</body>
