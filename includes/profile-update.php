<?php
    include '../connect.php';

    if (isset($_POST['save-changes'])){
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $age = $_POST['age'];
        $email = $_POST['email'];

        $statement_common = $connection->prepare("UPDATE tblaccount SET firstName=?, lastName=?, age=?, email=? WHERE accountID=?");
        $statement_common->bind_param("ssisi", $fname, $lname, $age, $email, $_GET['accountID']);
        $statement_common->execute();
        
        if (isset($_POST['password']) && $_POST['password'] != ''){

            $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $statement_common = $connection->prepare("UPDATE tblaccount SET password=? WHERE accountID=?");
            $statement_common->bind_param("si", $hash_pass, $_GET['accountID']);
            $statement_common->execute();
        }

        
        if (isset($_POST['org']) && is_array($_POST['org'])) {
            try {
                $statement_getAdmin = $connection->prepare("SELECT adminID FROM tbladminaccount WHERE accountID=?");
                $statement_getAdmin->bind_param("i", $_GET['accountID']);
                $statement_getAdmin->execute();
                $the_admin = $statement_getAdmin->get_result()->fetch_column();
    
                $statement_addOrg = $connection->prepare("INSERT INTO tblorganization (organizationName) VALUES (?)");
                $statement_adminOrg = $connection->prepare("INSERT INTO tbladminorganization (adminID, organizationID) VALUES (?, ?)");
    
                foreach ($_POST['org'] as $value) {
                    $statement_addOrg->bind_param("s", $value);
                    $statement_addOrg->execute();
                    $orgID = $connection->insert_id;
    
                    $statement_adminOrg->bind_param("ii", $the_admin, $orgID);
                    $statement_adminOrg->execute();
                }
    
                $connection->commit();
                echo '<script>console.log("Organizations added successfully!");</script>';
            } catch (Exception $e) {
                $connection->rollback();
            }
        }
        header("location: ../profile.php");
    }
?>