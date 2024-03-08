<link href = "css/styles.css" type="text/css" rel="stylesheet"/>

<?php
	include 'connect.php';
	include 'includes/header.php';
?>  
    
	<div class="register-form">
            <h1>Register</h1>
            <!-- <hr> -->
            <form method = POST>
                <!--first name-->
                <div class="txt_field">
                    <input type=text name="firstname">
                    <label>First Name</label>
                </div>
                <!--last name-->
                <div class="txt_field">
                    <input type=text name="lastname">
                    <label>Last Name</label>
                </div>
                <!--username-->
                <div class="txt_field">
                    <input type=text name="username">
                    <label>Username</label>
                </div>
                <!--gender-->
                <div class="txt_field">
                    <input type=text name="gender">
                    <label>Gender</label>
                </div>
                <!--email-->
                <div class="txt_field">
                    <input type=email name="email">
                    <label>Email</label>
                </div>
                <!--password-->
                <div class="txt_field">
                    <input type=password name="password">
                    <label>Password</label>
                </div>
                <input name="sign-up" type="submit" value="Sign Up">
                <div class="signup_link">
                    Have an account? <a href="#">Login Here</a>
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

        //save data to tbluserprofile
        $sql1 ="Insert into tbluserprofile(firstname,lastname,gender) values('".$fname."','".$lname."','".$gender."')";
        mysqli_query($connection,$sql1);

        //Check tbluseraccount if username is already existing. Save info if false. Prompt msg if true.
        $sql2 ="Select * from tbluseraccount where username='".$uname."'";
        $result = mysqli_query($connection,$sql2);
        $row = mysqli_num_rows($result);
        if($row == 0){
            $sql ="Insert into tbluseraccount(emailadd,username,password) values('".$email."','".$uname."','".$pword."')";
            mysqli_query($connection,$sql);
            echo "<script language='javascript'>
                        alert('New record saved.');
                  </script>";
            //header("location: index.php");
        }else{
            echo "<script language='javascript'>
                        alert('Username already existing');
                  </script>";
        }


    }


?>

<?php
	require_once 'includes/footer.php';
?>