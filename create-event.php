<?php
    include 'connect.php';
?>
<link href="css/create-event.css" type="text/css" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->

<body>
    <?php
    	include('includes/header.php');
    ?>
    <div class="main">

        <form action="" method="POST" enctype="multipart/form-data">
            <h2>CREATE EVENT</h2>
            
            <div class="event-form">
                <div class="inline">
                    <div class="for-event-pic">
                        <img name="the-event-pic" src="images/274000211_507612747391631_804088690670275201_n.jpg" id="preview-pic">
                        <label for="pic-event" id="btn-add-pic">Add Picture</label>
                        <input type="file" name="image" id="pic-event" accept=".jpeg, .png, .jpg" value="" required>
                    </div>
                    <script src="js/eventpic.js"></script>
                    <div class="info-events">
                        <label for="event-name">Event Name</label>
                        <input type="text" name="event-name" id="first-name" required>
                    </div>
                    <div class="info-events">
                        <label for="event-type">Event Type</label>
                        <!-- <input type="text" name="event-type" id="event-type" required> -->
                        <select name="event-type" id="event-type" required>
                            <option value="PUBLIC">
                                PUBLIC
                            </option>
                            <option value="SEMI-PUBLIC">
                                SEMI-PUBLIC
                            </option>
                            <option value="PRIVATE">
                                PRIVATE
                            </option>
                        </select>
                    </div>
                </div>
                <div class="inline">
                    <div class="info-events">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" required>
                    </div>
                    <div class="info-events">
                        <label for="time">Time</label>
                        <input type="time" name="time" id="time" required>
                    </div>
                    <div  class="info-events">
                        <label for="address">Venue</label>
                        <input type="text" name="venue" id="address" required>
                    </div>
                    <div  class="info-events">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" required></textarea>
                    </div>
                </div>
            </div>
            <br>
            <button name="create" type="submit">CREATE</button>
        </form>

    </div>

    <?php
        if(isset($_POST['create'])){
            //kulang nig description and image
            //goal in here is to tarong the ui of the form, na pwede mu insert og image
            $eventName = $_POST['event-name'];
            $eventType = $_POST['event-type'];
            $eventDate = $_POST['date'];
            $eventTime = $_POST['time'];
            $eventVenue = $_POST['venue'];
            $eventDescription = nl2br($_POST['description']);

            $statement_checkEvents = $connection->prepare("SELECT eventName, eventType FROM tblevents WHERE eventName=? AND eventType=?");
            $statement_checkEvents->bind_param("ss", $eventName, $eventType);
            $statement_checkEvents->execute();
            $result = $statement_checkEvents->get_result()->fetch_row();
            
            if(!$result){
                $delete = false;
                $statement_addEvents = $connection->prepare("INSERT INTO tblevents (adminID, eventName, eventType, date, time, venue, description, isDelete) VALUES (?,?,?,?,?,?,?,?)");
                $statement_addEvents->bind_param("issssssi", $_SESSION['adminID'], $eventName, $eventType, $eventDate, $eventTime, $eventVenue, $eventDescription, $delete);
                $statement_addEvents->execute();
                $add_pic = $connection->insert_id;
                
                // echo "Upload Error: " . $_FILES['image']['error'];  
                // echo "Uploaded File: " . $_FILES['image']['tmp_name'];
                // print_r($_FILES['image']);


                if (isset($_FILES['image'])) {
                    $temp_pic_name = $_FILES['image']['tmp_name'];
                    $pic_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $unique_filename = uniqid('', true) . '.' . $pic_extension;
                    
                    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                        echo "Upload Error: " . $_FILES['image']['error'];
                    } else {
                        move_uploaded_file($temp_pic_name, "images/events/" . $unique_filename);

                        $statement_addPicEvents = $connection->prepare("UPDATE tblevents SET image=? WHERE eventID=?");
                        $statement_addPicEvents->bind_param("si", $unique_filename, $add_pic);
                        $statement_addPicEvents->execute();
                    }
                }

                // echo "<script language='javascript'>
                //             console.log('New record saved.');
                //       </script>";
                header("location: index.php");
            }else{
                echo "<script>
                        console.log('Not successful');
                      </script>";
            }
        }

    ?>

    <?php
    	include('includes/footer.php');
    ?>
</body>