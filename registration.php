<?php
	include 'connect.php';
    
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    ?>  
<body>
    <link href="css/register-style.css" type="text/css" rel="stylesheet"/>

    <center>
        <img class="logo-big" src="images/logo-1.png"/>
    </center>
    <div class="register-box">
        <h2> CREATE ACCOUNT </h2>
        <form action="" method="POST">
            <div class="form-div">
                <div class="inline-div">
                    <div class="user-box">
                        <select class="typing selecting" id="accountType" name="accountType" required="true">
                            <option value="admin">Administrator</option>
                            <option value="user">User</option>
                        </select>
                        <label class="label-input">Account Type</label>
                    </div>
                    <div class="user-box">
                        <input class="typing" type="text" name="username" required="true">
                        <label class="label-input">Username</label>
                    </div>
                    <div class="user-box" id="orgField">
                        <input class="typing" type="text" name="organization" required>
                        <label class="label-input">Organization</label>
                    </div>
                    <script src="js/register.js"></script>
                </div>
                <div class="inline-div">
                    
                    <div class="inner-inline">
                        <div class="user-box">
                            <input class="typing" type="text" name="firstName" required="true">
                            <label class="label-input">First Name</label>
                        </div>
                        <div class="user-box">
                            <input class="typing" type="text" name="lastName" required="true">
                            <label class="label-input">Last Name</label>
                        </div>
                    </div>    

                    <div class="inner-inline">
                        <div class="user-box">
                            <input class="typing" type="number" name="age" required="true">
                            <label class="label-input">Age</label>
                        </div>
                        <div class="user-box">
                            <!-- <input class="typing" type="number" name="" required=""> -->
                            <select class="typing selecting" name="gender" required="true">
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                            <label class="label-input">Gender</label>
                        </div>
                    </div>
                    <div class="user-box">
                        <input class="typing" type="email" name="email" required="true">
                        <label class="label-input">Email</label>
                    </div>
                    <div class="user-box">
                        <input class="typing" type="password" name="password" required="true">
                        <label class="label-input">Password</label>
                    </div>
                </div>
            </div>
            <div id="exist"></div>
            <button class="register-btn" name="sign-up" type="submit" onclick="console.log('Button clicked');">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Register
            </button>
        </form>
        <hr>
        <span class="have-account">
            Already Registered?
            <a id="to-login" href="login.php">Login</a>
        </span>
    </div>
</body>

<?php
    if(isset($_POST['sign-up'])){
        
        //for tblaccount
        $fname=$_POST['firstName'];
        $lname=$_POST['lastName'];
        $username=$_POST['username'];
        $age=$_POST['age'];
        $gender=$_POST['gender'];
        $email=$_POST['email'];
        $pword=$_POST['password'];
        $account_type=$_POST['accountType'];

        //hash password
        $hash_pword = password_hash($pword,PASSWORD_BCRYPT);

        // Check if username or email already exist
        $sql = "SELECT * FROM tblaccount WHERE username=? OR email=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->num_rows;

        if($row == 0){
        // Insert into tblaccount
        $sql_account ="INSERT INTO tblaccount (firstName, lastName, username, age, gender, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_account = $connection->prepare($sql_account);
        $stmt_account->bind_param("sssssss", $fname, $lname, $username, $age, $gender, $email, $hash_pword);
        $stmt_account->execute();
        $accountID = $stmt_account->insert_id;

            if ($account_type == 'admin'){
                $organizationName=$_POST['organization'];
                // Insert into tblorganization if not exists
                $sql_orgFind = "SELECT * FROM tblorganization WHERE organizationName=?";
                $stmt_orgFind = $connection->prepare($sql_orgFind);
                $stmt_orgFind->bind_param("s", $organizationName);
                $stmt_orgFind->execute();
                $org_result = $stmt_orgFind->get_result();
                $org_row = $org_result->fetch_assoc();

                if (!$org_row){
                    $sql_orgInsert ="INSERT INTO tblorganization (organizationName) VALUES (?)";
                    $stmt_orgInsert = $connection->prepare($sql_orgInsert);
                    $stmt_orgInsert->bind_param("s", $organizationName);
                    $stmt_orgInsert->execute();
                    $orgID = $connection->insert_id;
                } else {
                    $orgID = $org_row['organizationID'];
                }

                // Insert into tbladminaccount
                $adminStat = -1;
                $sql_adminInsert ="INSERT INTO tbladminaccount (organizationID, accountID, adminStatusID) VALUES (?, ?, ?)";
                $stmt_adminInsert = $connection->prepare($sql_adminInsert);
                $stmt_adminInsert->bind_param("iii", $orgID, $accountID, $adminStat);
                $stmt_adminInsert->execute();
                $adminID = $connection->insert_id;

                // Insert into tbladminstatus
                $isAdmin = true;
                $sql_adminStatus = "INSERT INTO tbladminstatus (isAdmin, accountID) VALUES (?, ?)";
                $stmt_adminStatus = $connection->prepare($sql_adminStatus);
                // $stmt_adminStatus->bind_param("ii", $isAdmin, $adminID);
                $stmt_adminStatus->bind_param("ii", $isAdmin, $accountID);
                $stmt_adminStatus->execute();
                $adminStatusID = $connection->insert_id;

                // Update tbladminaccount with adminStatusID
                $sql_updateAdminStatus = "UPDATE tbladminaccount SET adminStatusID = ? WHERE adminID = ?";
                $stmt_updateAdminStatus = $connection->prepare($sql_updateAdminStatus);
                $stmt_updateAdminStatus->bind_param("ii", $adminStatusID, $adminID);
                $stmt_updateAdminStatus->execute();

                //Insert into tbladminorganization
                $sql_adminOrg = "INSERT INTO tbladminorganization (adminID, organizationID) VALUES (?, ?)";
                $statement_adminOrg = $connection->prepare($sql_adminOrg);
                $statement_adminOrg->bind_param("ii", $adminID, $orgID);
                $statement_adminOrg->execute();

                // Set session variables
                $_SESSION['isAdmin'] = true;
                $_SESSION['adminID'] = $adminID;
                $_SESSION['username'] = $username;
            } else if ($account_type == 'user') {
                // Insert into tbluseraccount
                $sql_userInsert = "INSERT INTO tbluseraccount (accountID) VALUES (?)";
                $stmt_userInsert = $connection->prepare($sql_userInsert);
                $stmt_userInsert->bind_param("i", $accountID);
                $stmt_userInsert->execute();
                $userID = $connection->insert_id;
            
                // Insert into tbladminstatus
                $isAdmin = false;
                $sql_adminStatus = "INSERT INTO tbladminstatus (isAdmin, accountID) VALUES (?, ?)";
                $stmt_adminStatus = $connection->prepare($sql_adminStatus);
                $stmt_adminStatus->bind_param("ii", $isAdmin, $accountID);
                $stmt_adminStatus->execute();
                $adminStatusID = $connection->insert_id;
            
                // Update tbluseraccount with adminStatusID
                $sql_updateAdminStatus = "UPDATE tbluseraccount SET adminStatusID = ? WHERE userID = ?";
                $stmt_updateAdminStatus = $connection->prepare($sql_updateAdminStatus);
                $stmt_updateAdminStatus->bind_param("ii", $adminStatusID, $userID);
                $stmt_updateAdminStatus->execute();
            
                $_SESSION['isAdmin'] = false;
                $_SESSION['userID'] = $userID;
                $_SESSION['username'] = $username;
            }
            
            header ("location: index.php");
        } else {
            // echo "<script>alert('Username or Email Address already exists');</script>";
            echo 
            "<script>
                var x = document.getElementById('exist');
                x.innerHTML = '*Username or Email Already Exist';
            </script>";
            ;
        }
    } else {
    // echo "<script>alert('Form not submitted');</script>";
    }
?>