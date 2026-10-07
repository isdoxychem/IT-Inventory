<?php 
include '../inc/auth.php'; 

if(isset($_POST['submit'])) {

    $result = $register->register($_POST['role'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['cpassword']);
    
    if($result == 1) {
        echo "<script> alert('Registration Successful'); </script>";
    }
    elseif($result == 10) {
        echo "<script> alert('Username or Email Has Already Taken'); </script>";
    }
    elseif($result == 100) {
        echo "<script> alert('Password Does Not Match'); </script>";
    }    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/styles.css"> -->
    <link rel="stylesheet" href="../css/fields.css">
    <title>Register User</title>
</head>
<body>
    <div class="container">
        <div class="add-form">
            <a href="../admin/dashboard.php" class="return">Back</a>
            
            <form action="" method="POST" autocomplete="off">
                <div class="title">Add User</div>
                <div class="asset-details">
                    <div class="input-box">
                        <span class="details">User Access:</span>
                        <!-- <input type="text" name="role" id="role"/> -->
                        <select name="role">
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Username:</span>
                        <input type="text" name="username" id="user"/>
                    </div>
                    <div class="input-box">
                        <span class="details">Email:</span>
                        <input type="email" name="email" id="email"/>
                    </div>
                    <div class="input-box">
                        <span class="details">Password:</span>
                        <input type="password" name="password" id="pass"/>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password:</span>
                        <input type="password" name="cpassword" id="cpass"/>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Save">
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>