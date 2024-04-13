<link href="css/common-style.css" type="text/css" rel="stylesheet">
<link href="css/create-event.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
    <?php
        session_start();
    	include('includes/header.php');
    	include 'connect.php';
    ?>
    <div class="main">

        <form action="" method="POST">
            <h3>Create Event</h3>
            <div>
                <label for="event-name">Event Name</label>
                <input type="text" name="event-name" id="first-name">
            </div>
            <div>
                <label for="event-type">Event Type</label>
                <input type="text" name="event-type" id="event-type">
                </div>
            <div>
                <label for="date">Date</label>
                <input type="date" name="date" id="date">
            </div>
            <div>
                <label for="time">Time</label>
                <input type="time" name="time" id="time">
                <!-- <select id="hour">
                    <option value="">Hour</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                :
                <select id="minute">
                    <option value="">Minute</option>
                    <option value="0">00</option>
                    <option value="5">05</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                    <option value="55">55</option>
                </select>
                <select id="period">
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select> -->
            </div>
            <div id="venue">
                <label for="address">Venue</label>
                <input type="text" name="venue" id="address">
                <!-- <input type="text" id="city"  placeholder="Street Address" placeholder="City"> -->
            </div>
            <button name="create" type="submit">CREATE</button>
        </form>

    </div>

    <?php
        if(isset($_POST['create'])){
            $eventName = $_POST['event-name'];
            $eventType = $_POST['event-type'];
            $eventDate = $_POST['date'];
            $eventTime = $_POST['time'];
            $eventVenue = $_POST['venue'];
        }

        $sql1 = "SELECT * FROM tblevents WHERE eventName='$eventName' AND eventType='$eventType'";
        $result = mysqli_query($connection,$sql1);
        $row = mysqli_num_rows($result);
        if($row == 0){
            $sql ="Insert into tblevents(eventName, eventType, date, time, venue) values( ' ".$eventName." ',' ".$eventType." ',' ".$eventDate." ',' ".$eventTime." ',' ".$eventVenue."' )";
            mysqli_query($connection,$sql);
            echo "<script language='javascript'>
                        alert('New record saved.');
                  </script>";
            header("location: index.php");
        }else{
            echo "<script>
                    var x = document.getElementById('exist');
                    x.innerHTML = '*Username or Email Address already exist';
                  </script>";
                  //hey
        }

    ?>

    <?php
    	include('includes/footer.php');
    ?>
</body>