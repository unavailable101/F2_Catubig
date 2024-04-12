<?php
    session_start();
	include 'connect.php';
    ?>  
<body>
    <link href="css/register-style.css" type="text/css" rel="stylesheet"/>
    <link href="css/common-style.css" type="text/css" rel="stylesheet"/>

    <center>
        <img class="logo-big" src="images/logo-1.png"/>
    </center>
    <div class="register-box">
        <h2> CREATE ACCOUNT </h2>
        <form>
            <div class="form-div">
                <div class="inline-div">
                    <div class="user-box">
                        <select class="typing selecting" id="accountType" name="" required="">
                            <option>Administrator</option>
                            <option>User</option>
                        </select>
                        <label class="label-input">Account Type</label>
                    </div>
                    <div class="user-box">
                        <input class="typing" type="text" name="" required="">
                        <label class="label-input">Username</label>
                    </div>
                    <div class="user-box" id="orgField">
                        <input class="typing" type="text" name="" required>
                        <label class="label-input">Organization</label>
                    </div>
                    <script src="js/register.js"></script>
                </div>
                <div class="inline-div">
                    
                    <div class="inner-inline">
                        <div class="user-box">
                            <input class="typing" type="text" name="" required="">
                            <label class="label-input">First Name</label>
                        </div>
                        <div class="user-box">
                            <input class="typing" type="text" name="" required="">
                            <label class="label-input">Last Name</label>
                        </div>
                    </div>    

                    <div class="inner-inline">
                        <div class="user-box">
                            <input class="typing" type="number" name="" required="">
                            <label class="label-input">Age</label>
                        </div>
                        <div class="user-box">
                            <!-- <input class="typing" type="number" name="" required=""> -->
                            <select class="typing selecting" name="" required="">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                            <label class="label-input">Gender</label>
                        </div>
                    </div>
                    <div class="user-box">
                        <input class="typing" type="email" name="" required="">
                        <label class="label-input">Email</label>
                    </div>
                    <div class="user-box">
                        <input class="typing" type="password" name="" required="">
                        <label class="label-input">Password</label>
                    </div>
                </div>
            </div>
            <button class="register-btn" type="submit">
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