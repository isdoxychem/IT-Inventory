<?php include '../inc/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/config.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Administrator</title>
</head>
<?php include '../inc/header.php'; ?>
    
    <div class="content">
        <div class="sub-config">
            <div class="sub-btn" style="filter: invert(1)";><a href="../php/add_emp_info.php" title="Add Employees"><img src="../assets/icons/config/addemp.png"></a></div>
            <div class="sub-btn" style="filter: invert(1)";><a href="../php/add_location.php" title="Add Location"><img src="../assets/icons/config/addloc.png"></a></a></div>
            <div class="sub-btn" style="filter: invert(1)";><a href="../php/add_division.php" title="Add Department"><img src="../assets/icons/config/department.png"></a></a></div>
            <!-- <div class="sub-btn" style="filter: invert(1)";><a href="../php/add_division.php" title="Add Department"><img src="../assets/icons/config/department.png"></a></a></div> -->
        </div>
    </div>

    <script src="../js/dashboard.js"></script>
</body>
</html>