<?php
    include 'connect.php';
?>

<link rel="stylesheet" type="text/css" href="css/profile-styles.css">

<body>
    <?php
        require_once 'includes/header.php';
    ?>

    <div class="main">
    <!-- begin main  -->
        <div class="profile">

            <div class="pfp-container">

                <div class="pfp">
                <!-- start pfp -->
                    <div class="pfp-pic">
                        <img class="pic" src="images/FB_IMG_1595646904455.jpg">
                        <div class="pfp-border">
                            <img class="border" src="images/border.png">
                        </div>
                    </div>
                <!-- end pfp -->
                </div>
                <a href="edit-profile.php">
                    <div class="edit">
                        <img src="images/circle_edit_icon_212071.png">
                    </div>
                </a>

            </div>
            
            <div class="user-info">
                <?php
                    if ($_SESSION['isAdmin']){
                        $query = "SELECT firstName, lastName, username FROM tblaccount, tbladminaccount WHERE adminID=? AND tblaccount.accountID=tbladminaccount.accountID";
                        $statement = $connection->prepare($query);
                        $statement->bind_param("s", $_SESSION['adminID']);
                        $statement->execute();
                        $res = $statement->get_result();
                    } else {
                        $query = "SELECT firstName, lastName, username FROM tblaccount, tbluseraccount WHERE userID=? AND tblaccount.accountID=tbluseraccount.accountID";
                        $statement = $connection->prepare($query);
                        $statement->bind_param("s", $_SESSION['userID']);
                        $statement->execute();
                        $res = $statement->get_result();
                    }
                    $currUser = $res->fetch_array();
                    echo '
                        <div class="name">
                            '.$currUser['firstName'].' '.$currUser['lastName'].'
                        </div>
                        <div class="username">
                            '.$currUser['username'].'
                        </div>
                    ';
                ?>
            </div>

        </div>
        <div class="more-info">
                <div class="content">
                    <div class="inner-bar">
                        <div class="active" id="overview-tab">Overview</div>
                        <?php
                            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === true){
                                echo '
                                    <div id="events-tab">Events</div>
                                ';
                            } else {
                                echo '
                                    <div id="events-tab">Joined Events</div>
                                ';
                            }
                        ?>
                        <script src="js/profile.js"></script>
                    </div>
                    <div class="overview">
                        <hr>
                        <div class="literal-overview">
                            <div class="most-event">
                                <?php
                                    if ($_SESSION['isAdmin']){
                                        echo '
                                            <span>
                                                Way Uyab Event
                                            </span>
                                            <span>
                                                Most Joined Even
                                            </span>
                                        ';
                                    } else {
                                        echo '
                                            <span>
                                                Way Uyab Event
                                            </span>
                                            <span>
                                                Next Upcoming Event
                                            </span>
                                        ';
                                    }
                                ?>
                            </div>
                            <div class="total-events">
                                <?php
                                    if ($_SESSION['isAdmin']){
                                        echo '
                                            <span>
                                                10000
                                            </span>
                                            <span>
                                                Total Events
                                            </span>
                                        ';
                                    } else {
                                        echo '
                                            <span>
                                                10000
                                            </span>
                                            <span>
                                                Total Joined Events
                                            </span>
                                        ';
                                    }
                                ?>
                            
                            </div>
                        </div>
                        <hr>
                        <?php
                            if ($_SESSION['isAdmin']){
                                echo '
                                    <span id="top-events">
                                        TOP EVENTS
                                    </span>
                                ';
                            } else {
                                echo '
                                    <span id="upcoming-events">
                                        UPCOMING EVENTS
                                    </span>
                                ';
                            }
                        ?>
                        <div class="list-top-events">
                            <div class="event-pic">
                                <img src="images/3 (2).jpg">
                                <div class="event-name">
                                    <div>Kiro</div>
                                    <div>da hacker</div>
                                </div>
                            </div>
                            <div class="event-pic">
                                <img src="images/3 (4).jpg">
                                <div class="event-name">
                                    <div>Gavin</div>
                                    <div>gwapo</div>
                                </div>
                            </div>
                            <div class="event-pic">
                                <img src="images/274000211_507612747391631_804088690670275201_n.jpg">
                                <div class="event-name">
                                    <div>MAMAA</div>
                                    <div>ang pagkikita</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="admin-events">
                    <div class="list-top-events">
                            <div class="event-pic">
                                <img src="images/3 (2).jpg">
                                <div class="event-name">
                                    <div>Kiro</div>
                                    <div>da hacker</div>
                                </div>
                            </div>
                            <div class="event-pic">
                                <img src="images/3 (4).jpg">
                                <div class="event-name">
                                    <div>Gavin</div>
                                    <div>gwapo</div>
                                </div>
                            </div>
                            <div class="event-pic">
                                <img src="images/274000211_507612747391631_804088690670275201_n.jpg">
                                <div class="event-name">
                                    <div>MAMAA</div>
                                    <div>ang pagkikita</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>

    <!-- end main -->
    </div>

    <?php
        require_once 'includes/footer.php';
    ?>
</body>