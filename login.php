<?php
    include 'connect.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<body>
    <link href="css/login-style.css" type="text/css" rel="stylesheet" />

    <center>
        <img class="logo-big" src="images/logo-1.png">
    </center>
        
    <div class="login-box">
        <h2> L O G I N </h2>
        <form action="" method="POST">
            <div class="user-box">
                <input type="text" name="username" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required="">
                <label>Password</label>
                <a id="forgot-pass" href="#">
                    Forgot Password?
                </a>
            </div>
        
            <div id="exist"></div>

            <button class="login-btn" name="login" type="submit">
                <!-- for effect ning mga span mamsh ha -->
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Login
            </button>
        </form>
        <hr>
        <span class="no-account">
            Don't have an account?
            <a id="to-register" href="registration.php">Register</a>
        </span>
        </div>

</body>

<?php
    if(isset($_POST['login'])){

        // echo "<script>console.log('i was called!')</script>";

        $uname = $_POST['username'];
        $pwd = $_POST['password'];
        //check tbluseraccount if username is existing
        $sql_account ="Select * from tblaccount where username='".$uname."'";
        $result_account = mysqli_query($connection,$sql_account);
        
        //number of counts that has the same username
        $count = mysqli_num_rows($result_account);

        //ika-pila na row na same ang user input ug 
        $account_row = mysqli_fetch_array($result_account);

        if ($count == 0){
            echo "<script>
            var x = document.getElementById('exist');
            x.innerHTML = '*Username does not exist';
            </script>
            ";
        } else {
            if (!$account_row['isDelete']){
                if ( password_verify($pwd, $account_row['password'] ) ){
                    $query1 = "SELECT isAdmin from tbladminstatus WHERE accountID=?";
                    $statement1 = $connection->prepare($query1);
                    $statement1->bind_param("s", $account_row['accountID']);
                    $statement1->execute();
                    $res1 = $statement1->get_result();
                    $isExist = $res1->fetch_array();
    
                    if ($isExist['isAdmin']){                    
                        $query_admin = "SELECT adminID FROM tbladminaccount WHERE accountID=?";
                        $statement_admin = $connection->prepare($query_admin);
                        $statement_admin->bind_param("s", $account_row['accountID']);
                        $statement_admin->execute();
                        $res_admin = $statement_admin->get_result();
                        $admin_row = $res_admin->fetch_array();
                        
                        $_SESSION['isAdmin']=true;
                        $_SESSION['adminID']=$admin_row['adminID'];
                        $_SESSION['username']=$account_row['username'];
                    } else {
                        
                        $query_user = "SELECT userID FROM tbluseraccount WHERE accountID=?";
                        $statement_user = $connection->prepare($query_user);
                        $statement_user->bind_param("s", $account_row['accountID']);
                        $statement_user->execute();
                        $res_user = $statement_user->get_result();
                        $user_row = $res_user->fetch_array();
                            
                        $_SESSION['isAdmin']=false;
                        $_SESSION['userID']=$user_row['userID'];
                        $_SESSION['username']=$account_row['username'];
                    }
    
                    header("location: index.php");
                } else {
                    // echo "<script language='javascript'>
                    //         alert('Incorrect password');
                    //     </script>";
                    echo "<script>
                            var x = document.getElementById('exist');
                            x.innerHTML = '*Incorrect password';
                        </script>";
                }
            }
        }
    }
?>