<link href="css/common-style.css" type="text/css" rel="stylesheet">
<link href="css/create-event.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
    <?php
    	include('includes/header.php');
    ?>
    <div class="main">

        <form>
            <h3>Create Event</h3>
            <div>
                <label for="event-name">Event Name</label>
                <input type="text" id="first-name">
            </div>
            <div>
                <label for="event-type">Event Type</label>
                <input type="text" id="event-type">
                </div>
            <div>
                <label for="date">Date</label>
                <input type="date" id="date">
            </div>
            <div>
                <label for="time">Time</label>
                <select id="hour">
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
                    <!-- Add more options for hours -->
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
                </select>
            </div>
            <div id="venue">
                <label for="address">Venue</label>
                <input type="text" id="address" placeholder="Street Address">
                <input type="text" id="city" placeholder="City">
            </div>
            <button type="submit">CREATE</button>
        </form>

    </div>

    <?php
    	include('includes/footer.php');
    ?>
</body>