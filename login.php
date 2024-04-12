<?php
    session_start();
    include 'connect.php';
?>

<body>
    <link href="css/login-style.css" type="text/css" rel="stylesheet" />
    <link href="css/common-style.css" type="text/css" rel="stylesheet" />

    <center>
        <img class="logo-big" src="images/logo-1.png">
    </center>
        
    <div class="login-box">
        <h2> L O G I N </h2>
        <form>
            <div class="user-box">
                <input type="text" name="" required="">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="" required="">
                <label>Password</label>
                <a id="forgot-pass" href="#">
                    Forgot Password?
                </a>
            </div>
            <button class="login-btn" type="submit">
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
            <a id="to-register" href="#">Register</a>
        </span>
        </div>

</body>

<?php
    if(isset($_POST['login'])){
        $uname = $_POST['username'];
        $pwd = $_POST['password'];
        //check tbluseraccount if username is existing
        $sql ="Select * from tbluseraccount where username='".$uname."'";

        $result = mysqli_query($connection,$sql);

        //number of counts that has the same username
        $count = mysqli_num_rows($result);

        //ika-pila na row na same ang user input ug 
        $row = mysqli_fetch_array($result);
        if ($count == 0){
            // echo "<script language='javascript'>
            //             alert('username not existing.');
            //         </script>";
            echo "<script>
                    var x = document.getElementById('exist');
                    x.innerHTML = '*Username does not exist';
                </script>
            ";
            //hey
        } else {
            if ( password_verify($pwd, $row[3] ) ){
                $_SESSION['username']=$row[0];
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