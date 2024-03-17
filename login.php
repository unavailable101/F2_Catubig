<link href = "css/styles.css" type="text/css" rel="stylesheet"/>
<link href = "css/style.css" type="text/css" rel="stylesheet"/>

<?php
    include 'connect.php';
    require_once 'includes/header.php';
?>

<section class="content-login">
    <h1>Join the CONquests</h1>
    <div class="login-time">
        <div class="log-in">
            <h2>LOG IN</h2>
            <form id="log-in-form" method="POST">
                <div class="input">
                    <!-- username -->
                    <label for="username">Username: </label>
                    <input type="text" id="username" name="username" required/>
                </div>
                <div class="input">
                    <!-- password -->
                    <label for="pass">Password: </label>
                    <input type="password" id="pass" name="password" required/>
                </div>
                <button class="btn-1" name="login" type="submit">LOG IN</button>
            </form>
            <p id="error" class="err-msg"></p>
        </div>
    </div>
    <p class="extra">
        Need an account? <a href="#">Sign up for free.</a>
    </p>
    <p class="extra">
        Forgot password?
    </p>
</section>

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
                    if (x.innerHTML === ' ') {
                        x.innerHTML = '*Username does not exist';
                    }
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
                        if (x.innerHTML === ' ') {
                            x.innerHTML = '*Incorrect password';
                        }
                    </script>";
            }
        }
    }
?>


<?php
    require_once 'includes/footer.php';
?>