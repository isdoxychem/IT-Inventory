<?php include '../inc/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/config.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="css/menustyles.css"> -->

    <!-- ICONS CDN FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>index</title>
</head>
<body>
<?php include '../inc/header.php'; ?>
<div class="content">
    <div class="menu">
      <div class="menu__wrapper"><i class="fa-solid fa-plus"></i></div>

      <ul class="menu__items">
        <li class="menu__item">
          <a href="../assetLists/Laptop.php"><i class="fa-solid fa-laptop"></i></a>
        </li>
        <li class="menu__item">
          <a href="../assetLists/Desktop.php"><i class="fa-solid fa-computer"></i></a>
        </li>
        <li class="menu__item">
          <a href="../assetLists/Monitor.php"><i class="fa-solid fa-tv"></i></a>
        </li>
        <li class="menu__item">
          <a href="../assetLists/Printer.php"><i class="fa-solid fa-print"></i></a>
        </li>
        <li class="menu__item">
          <a href="../assetLists/UPS.php"><i class="fa-solid fa-bolt"></i></a>
        </li>
        <li class="menu__item">
          <a href="../assetLists/Mobile.php"><i class="fa-solid fa-mobile-screen-button"></i></a>
        </li>
        <li class="menu__item">
          <a href="../assetLists/SIM.php"><i class="fa-solid fa-sim-card"></i></a>
        </li>
        <li class="menu__item">
          <a href="../admin/employeeLists.php"><i class="fa-solid fa-address-book"></i></a>
        </li>
        <li class="menu__item">
          <a href="../admin/adminConfig.php"><i class="fa-solid fa-gears"></i></a>
        </li>
        <li class="menu__item">
          <a href="../admin/reference.php"><i class="fa-solid fa-asterisk"></i></a>
          <!-- <a href="../admin/references.php"><i class="fa-solid fa-asterisk"></i></a> -->
        </li>
      </ul>
    </div>

<!-- JS -->
<script>
const wrapper = document.querySelector('.menu__wrapper');

wrapper.addEventListener('click', () => {
    wrapper.classList.toggle('active');
})
</script>

</div>



    <!-- <div class="content">
        <div class="config-buttons">
            <div class="config-btn"><a href="../assetLists/Laptop.php" title="Desktop"><img src="../assets/icons/config/laptop.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Desktop.php" title="Desktop"><img src="../assets/icons/config/computer.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Monitor.php" title="Monitor"><img src="../assets/icons/config/monitor.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Printer.php" title="Printer"><img src="../assets/icons/config/printer.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/UPS.php" title="UPS/AVR"><img src="../assets/icons/config/UPS.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/Mobile.php" title="Mobile"><img src="../assets/icons/config/mobile.png"></a><br></div>
            <div class="config-btn"><a href="../assetLists/SIM.php" title="SIM Card"><img src="../assets/icons/config/sim.png"></a><br></div>
        </div>
        <div class="config-buttons sub-config">
            <div class="sub-btn"></div>
            <div class="sub-btn"><a href="../admin/employeeLists.php" title="Employees"><img src="../assets/icons/config/daily-tasks.png"></a></div>
            <div class="sub-btn"><a href="../admin/adminConfig.php" title="Settings"><img src="../assets/icons/config/turnover.png"></a></div>
            <div class="sub-btn"><a href="../admin/references.php" title="Reference"><img src="../assets/icons/config/research.png"></a></div>
            <div class="sub-btn"></div>
        </div>
    </div>
    
    <script src="../js/dashboard.js"></script> -->
</body>
</html>