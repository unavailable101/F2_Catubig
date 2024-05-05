<?php
    include 'connect.php';
?>
<link href="css/create-event.css" type="text/css" rel="stylesheet">

<body>
    <?php
    	include('includes/header.php');

        $statement_eventInfo = $connection->prepare("SELECT * FROM tblevents WHERE eventID=? AND adminID=?"); //naniguro lng hehe
        $statement_eventInfo->bind_param("ii", $_GET['eventID'], $_SESSION['adminID']);
        $statement_eventInfo->execute();
        $e = $statement_eventInfo->get_result()->fetch_assoc();
    ?>
    <div class="main">

        <form action="" method="POST" enctype="multipart/form-data">
            <h2>EDIT EVENT</h2>
            
            <div class="event-form">
                <div class="inline">
                    <div class="for-event-pic">
                        <img name="the-event-pic" src="images/events/<?=$e['image'];?>" id="preview-pic">
                        <label for="pic-event" id="btn-add-pic">Update Picture</label>
                        <input type="file" name="image" id="pic-event" accept=".jpeg, .png, .jpg" value="">
                    </div>
                    <script src="js/eventpic.js"></script>
                    <div class="info-events">
                        <label for="event-name">Event Name</label>
                        <input type="text" name="event-name" id="first-name" value="<?=$e['eventName'];?>">
                    </div>
                    <div class="info-events">
                        <label for="event-type">Event Type</label>
                        <input type="text" name="event-type" id="event-type" value="<?=$e['eventType'];?>">
                    </div>
                </div>
                <div class="inline">
                    <div class="info-events">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" value="<?=$e['date'];?>">
                    </div>
                    <div class="info-events">
                        <label for="time">Time</label>
                        <input type="time" name="time" id="time" value="<?=$e['time'];?>">
                    </div>
                    <div  class="info-events">
                        <label for="address">Venue</label>
                        <input type="text" name="venue" id="address" value="<?=$e['venue'];?>">
                    </div>
                    <div  class="info-events">
                        <label for="description">Description</label>
                        <textarea name="description" id="description"></textarea>
                    </div>
                </div>
            </div>
            <br>
            <button name="save-changes" type="submit">SAVE CHANGES</button>
        </form>

    </div>

    <script>
        document.getElementById("description").value="<?=$e['description'];?>";
    </script>

    <?php
        if(isset($_POST['save-changes'])){
            $eventName = $_POST['event-name'];
            $eventType = $_POST['event-type'];
            $eventDate = $_POST['date'];
            $eventTime = $_POST['time'];
            $eventVenue = $_POST['venue'];
            $eventDescription = $_POST['description'];

                
            $statement_addEvents = $connection->prepare("UPDATE tblevents SET eventName=?, eventType=?, date=?, time=?, venue=?, description=? WHERE eventID=?");
            $statement_addEvents->bind_param("ssssssi", $eventName, $eventType, $eventDate, $eventTime, $eventVenue, $eventDescription, $_GET['eventID']);
            $statement_addEvents->execute();
            // $add_pic = $connection->insert_id;

            if (isset($_FILES['image'])) {
                $temp_pic_name = $_FILES['image']['tmp_name'];
                $pic_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $unique_filename = uniqid('', true) . '.' . $pic_extension;
                
                if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    echo "Upload Error: " . $_FILES['image']['error'];
                } else {
                    move_uploaded_file($temp_pic_name, "images/events/" . $unique_filename);

                    $statement_addPicEvents = $connection->prepare("UPDATE tblevents SET image=? WHERE eventID=?");
                    $statement_addPicEvents->bind_param("si", $unique_filename, $_GET['eventID']);
                    $statement_addPicEvents->execute();
                }
            }
            header("location: profile.php");
        
        }

    ?>

    <?php
    	include('includes/footer.php');
    ?>
</body>