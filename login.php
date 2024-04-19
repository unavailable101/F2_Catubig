<?php
    include 'connect.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>

<body>
    <link href="css/login-style.css" type="text/css" rel="stylesheet" />
    <link href="css/common-style.css" type="text/css" rel="stylesheet" />

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
            if ( password_verify($pwd, $account_row['password'] ) ){
                
                $sql_adminStat ="Select * from tbladminstatus where accountID='".$account_row['accountID']."'";
                $result_stat = mysqli_query($connection,$sql_adminStat);
                $isExist = mysqli_num_rows($result_stat);
                
                if ($isExist != 0){
                    $row_stat = mysqli_fetch_array($result_stat);
                    
                    $sql_admin ="Select * from tbladminaccount where adminID='".$row_stat['adminStatusID']."'";
                    $result_admin = mysqli_query($connection,$sql_admin);
                    $isAdminExist = mysqli_num_rows($result_admin);
                    
                    if ($isAdminExist!=0){
                        $admin_row = mysqli_fetch_array($result_admin);
                        
                        $_SESSION['isAdmin']=true;
                        $_SESSION['adminID']=$admin_row['adminID'];
                        $_SESSION['username']=$account_row['username'];
                    }
                } else {
                    $sql_user ="Select * from tbluseraccount where accountID='".$account_row['accountID']."'";
                    $result_user = mysqli_query($connection,$sql_user);
                    $isUserExist = mysqli_num_rows($result_user);
                    
                    if ($isUserExist != 0){
                        $user_row = mysqli_fetch_array($result_user);
                        
                        $_SESSION['isAdmin']=false;
                        $_SESSION['userID']=$user_row['userID'];
                        $_SESSION['username']=$account_row['username'];
                    }
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
?>