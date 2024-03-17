<link href = "css/styles.css" type="text/css" rel="stylesheet"/>
<script src="js/script.js"></script>

<?php
    session_start();
	include 'connect.php';
	include 'includes/header.php';
?>  
    
	<div class="register-form">
            <h1>Register</h1>
            <!-- <hr> -->
            <form method = POST>
                <!--first name-->
                <div class="txt_field">
                    <input type=text name="firstname" required>
                    <label>First Name</label>
                </div>
                <!--last name-->
                <div class="txt_field">
                    <input type=text name="lastname" required>
                    <label>Last Name</label>
                </div>
                <!--username-->
                <div class="txt_field">
                    <input type=text name="username" required>
                    <label>Username</label>
                </div>
                <!--gender-->
                <div id="radio-btn">
                    <div id="btns">
                        <input type=radio name="gender" value="Male" required> Male
                        <input type=radio name="gender" value="Female" required> Female
                    </div>  
                    <label>Gender</label>
                </div>
                <!--email-->
                <div class="txt_field">
                    <input type=email name="email" required>
                    <label>Email</label>
                </div>
                <!--password-->
                <div class="txt_field">
                    <input type=password name="password" required>
                    <label>Password</label>
                </div>

                <div id="exist"> </div>

                <input name="sign-up" type="submit" value="Sign Up">

                <div class="signup_link">
                    Have an account? <a href="login.php">Login Here</a>
                </div>
            </form>
    </div>

<?php
    if(isset($_POST['sign-up'])){
        //retrieve data from form and save the value to a variable
        //for tbluserprofile
        $fname=$_POST['firstname'];
        $lname=$_POST['lastname'];
        $gender=$_POST['gender'];

        //for tbluseraccount
        $email=$_POST['email'];
        $uname=$_POST['username'];
        $pword=$_POST['password'];

        //hash password
        $hash_pword = password_hash($pword,PASSWORD_BCRYPT);

        //save data to tbluserprofile
        $sql1 ="Insert into tbluserprofile(firstname,lastname,gender) values('".$fname."','".$lname."','".$gender."')";
        mysqli_query($connection,$sql1);

        //Check tbluseraccount if username is already existing. Save info if false. Prompt msg if true.
        $sql2 = "SELECT * FROM tbluseraccount WHERE username='$uname' OR emailadd='$email'";
        $result = mysqli_query($connection,$sql2);
        $row = mysqli_num_rows($result);
        if($row == 0){
            $sql ="Insert into tbluseraccount(emailadd,username,password) values('".$email."','".$uname."','".$hash_pword."')";
            mysqli_query($connection,$sql);
            // echo "<script language='javascript'>
            //             alert('New record saved.');
            //       </script>";
            header("location: index.php");
            $_SESSION['username'] = $uname;
        }else{
            echo "<script>
                    var x = document.getElementById('exist');
                    x.innerHTML = '*Username or Email Address already exist';
                  </script>";
                  //hey
        }
    }
?>

<?php
	require_once 'includes/footer.php';
?>