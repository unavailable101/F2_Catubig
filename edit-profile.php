<?php
    include 'connect.php';

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
?>

<!-- goals: 
    maka change nag profile pic ang user/admin -->

<link rel="stylesheet" type="text/css" href="css/profile-styles.css">
<link rel="stylesheet" type="text/css" href="css/profile-settings-styles.css">

<body>
    <?php
        require_once 'includes/header.php';
    
        if ($_SESSION['isAdmin']){
            $query = "SELECT accountID FROM tbladminaccount WHERE adminID=?";
            $statement = $connection->prepare($query);
            $statement->bind_param("s", $_SESSION['adminID']);
        } else {
            $query = "SELECT accountID FROM tbluseraccount WHERE userID=?";
            $statement = $connection->prepare($query);
            $statement->bind_param("s", $_SESSION['userID']);
        }
        $statement->execute();
        $res = $statement->get_result()->fetch_column();
    ?>

    <div class="main">
        <form id="update-profile" method="POST" action="includes/profile-update.php?accountID=<?=$res;?>">
            <div class="the-form">
                <div class="pic-n-btns">
                    <div class="pfp">
                    <!-- start pfp -->
                        <div class="pfp-pic">
                            <img class="pic" src="images/FB_IMG_1595646904455.jpg" id="profile-pic">
                            <div class="pfp-border">
                                <img class="border" src="images/border.png">
                            </div>
                        </div>
                    <!-- end pfp -->
                    </div>
                    <label for="update-image">Update Picture</label>
                    <input type="file" accept="image/jpeg, image/png, image/jpg" name="update-image" id="update-image">

                    <script src="js/profile-pic.js"></script>

                    <br>
                    <br>
                    <br>
                    <a href="includes/deleteAccount.php?accountID=<?=$res;?>">
                        Delete Account
                    </a>
                    <?php
                        if (!$_SESSION['isAdmin'])
                        echo '
                            <br>
                            <a href="includes/requestToAdmin.php?accountID='.$res.'">
                                Request Administrator
                            </a>
                        ';
                    ?>
                </div>
                
                <?php
                    $statement_account = $connection->prepare("SELECT firstName, lastName, email, age FROM tblaccount WHERE accountID=?");
                    $statement_account->bind_param("s", $res);
                    $statement_account->execute();
                    $currAccount = $statement_account->get_result()->fetch_array();
                ?>

                <div class="the-updates">
                    <div class="info">
                        <div class="info-inline">
                            <div class="input-box">
                                <input class="typing" type="text" name="firstName" value="<?=$currAccount['firstName'];?>">
                                <label class="label-input">First Name</label>
                            </div>
                            <div class="input-box">
                                <input class="typing" type="text" name="lastName" value="<?=$currAccount['lastName'];?>">
                                <label class="label-input">Last Name</label>
                            </div>
                            <div class="input-box">
                                <input class="typing" type="number" name="age" value="<?=$currAccount['age'];?>">
                                <label class="label-input">Age</label>
                            </div>
                        </div>
                        <div class="info-inline">
                            <?php
                                if ($_SESSION['isAdmin']){
                                    echo '
                                        <div class="para-admin">
                                            <div class="input-box" id="to-add">
                                                <div class="add-more">
                                                    <input class="typing" type="text" name="org[]" >
                                                    <input type="button" class="btn-add" value="Add">
                                                </div>
                                                '?>
                                                <?php
                                                    $statement_getAdminOrgs = $connection->prepare("SELECT organizationName FROM tblorganization, tbladminorganization WHERE tbladminorganization.adminID=? AND tblorganization.organizationID=tbladminorganization.organizationID");
                                                    $statement_getAdminOrgs->bind_param("i", $_SESSION['adminID']);
                                                    $statement_getAdminOrgs->execute();
                                                    $res = $statement_getAdminOrgs->get_result();

                                                    while ($org = $res->fetch_assoc()):
                                                ?>    
                                                <input class="typing" type="text" value="<?=$org['organizationName'];?>" disabled>
                                                <?php
                                                    endwhile;
                                                ?>
                                                <?php 
                                                echo '<input class="typing hidden" >
                                                <label class="label-input">Organization</label>
                                            </div>
                                        </div>
                                        <div class="para-admin">
                                            <div class="input-box">
                                                <input class="typing" type="email" name="email" value=" ' . $currAccount['email']. '">
                                                <label class="label-input">Email</label>
                                            </div>
                                            <div class="input-box">
                                                <input class="typing" type="password" name="password" >
                                                <label class="label-input">New Password</label>
                                            </div>
                                        </div>
                                    ';
                                } else {
                                    echo '
                                        <div class="input-box">
                                            <input class="typing" type="email" name="email" value=" ' . $currAccount['email']. '">
                                            <label class="label-input">Email</label>
                                        </div>
                                        <div class="input-box">
                                            <input class="typing" type="password" name="password" >
                                            <label class="label-input">New Password</label>
                                        </div>
                                    ';
                                }
                            ?>
                        </div>
                        
                        <input class="submit-changes" type="submit" name="save-changes" value="Save Changes">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
        if ($_SESSION['isAdmin']){
            echo "
                <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
                <script src='js/script.js'></script>
            ";
        }
    ?>

    <?php
        require_once 'includes/footer.php';
    ?>
</body>