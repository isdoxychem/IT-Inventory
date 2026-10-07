<?php include '../inc/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/dashboard.css">

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- ICONS CDN FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Dashboard</title>
</head>
<style>
    .main-cards a {
        transition: .2s ease-out;
    }
    .main-cards a:hover {
        color: white;
        transition: .2s ease-in;
    }

    .menu a.disabled {
        pointer-events: none;
        cursor: default;
        background-color: #7a7a7a;
    }
</style>    

<div class="grid-container">
<?php include '../inc/header.php'; ?>
<div class="dim-background"></div>

      <!-- Main -->

    <main class="main-container">
        <div class="main-title">
            <h2>DASHBOARD</h2>
        </div>

        <div class="main-cards">

            <a href="#">        
                <div class="card">
                <div class="card-inner">
                    <h3>ASSETS</h3>
                    <span class="material-icons-outlined">inventory_2</span>
                </div>
                <h1><?php 
                    $allAsset = $select->getAssetCount(); 
                    echo $allAsset; 
                ?></h1>
                </div>
            </a>

            <a href="#">
                <div class="card">
                <div class="card-inner">
                    <h3>DEPLOYED</h3>
                    <span class="material-icons-outlined">assignment_ind</span>
                </div>
                <h1><?php 
                    $deployed = $select->getDeployedAssetCount(); 
                    echo $deployed; 
                ?></h1>
                </div>
            </a>

            <a href="#">
                <div class="card">
                <div class="card-inner">
                    <h3>AVAILABLE</h3>
                    <span class="material-icons-outlined">event_available</span>
                </div>
                <h1><?php 
                    $available = $select->getAvailableAssetCount(); 
                    echo $available; 
                ?></h1>
                </div>
            </a>

            <a href="#">
                <div class="card">
                <div class="card-inner">
                    <h3>DEFECTIVE</h3>
                    <span class="material-icons-outlined">disabled_by_default</span>
                </div>
                <h1><?php 
                    $defect = $select->getDefectAssetCount(); 
                    echo $defect; 
                ?></h1>
                </div>
            </a>

            <a href="#">
                <div class="card">
                <div class="card-inner">
                    <h3>REPAIR</h3>
                    <span class="material-icons-outlined">build_circle</span>
                </div>
                <h1><?php 
                    $repair = $select->getRepairAssetCount(); 
                    echo $repair; 
                ?></h1>
                </div>
            </a>
                
            <a href="#">            
                <div class="card">
                <div class="card-inner">
                    <h3>SELL</h3>
                    <span class="material-icons-outlined">sell</span>
                </div>
                <h1><?php 
                    $sell = $select->getForSellAssetCount(); 
                    echo $sell; 
                ?></h1>
                </div>
            </a>

            <a href="#">            
                <div class="card">
                <div class="card-inner">
                    <h3>MISSING</h3>
                    <span class="material-icons-outlined">visibility_off</span>
                </div>
                <h1><?php 
                    $missing = $select->getForMissingAssetCount(); 
                    echo $missing; 
                ?></h1>
                </div>
            </a>

            <a href="../paths/nonAsset.php">           
                <div class="card">
                <div class="card-inner">
                    <h3>USER WITHOUT ACC..</h3>
                    <span class="material-icons-outlined">pending_actions</span>
                </div>
                <h1><?php 
                    $noacc = $select->getUserNoAccountability(); 
                    echo $noacc; 
                ?></h1>
                </div>
            </a>                
            
        </div>

        <div class="charts">
            <div class="charts-card">
            <h2 class="chart-title">Assets</h2>
            <div id="bar-chart"></div>
            </div>

            <div class="charts-card">
            <h2 class="chart-title">Purchase and Sales Orders</h2>
            <div id="area-chart"></div>
            </div>
        </div>

    </main>
    <!-- End Main -->   

</div>
<div class="menu" onclick="toggleDim()">

    <div class="menu__wrapper"><i class="fa-solid fa-plus"></i></div>

<?php if($role == 'admin') { ?>
    <ul class="menu__items">
        <li class="menu__item">
        <a class="items" href="../assetLists/Laptop.php"><i class="fa-solid fa-laptop"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/Desktop.php"><i class="fa-solid fa-computer"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/Monitor.php"><i class="fa-solid fa-tv"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/Printer.php"><i class="fa-solid fa-print"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/UPS.php"><i class="fa-solid fa-bolt"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/Mobile.php"><i class="fa-solid fa-mobile-screen-button"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/SIM.php"><i class="fa-solid fa-sim-card"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../admin/employeeLists.php"><i class="fa-solid fa-address-book"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../admin/adminConfig.php"><i class="fa-solid fa-gears"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../admin/reference.php"><i class="fa-solid fa-asterisk"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="../assetLists/Router.php"><i class="fa-solid fa-layer-group"></i></a>
        </li>
    </ul>
<?php } else { ?>
    <ul class="menu__items">
        <li class="menu__item">
        <a class="disabled items" href="#"><i class="fa-solid fa-laptop"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="#"><i class="fa-solid fa-computer"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="#"><i class="fa-solid fa-tv"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="#"><i class="fa-solid fa-print"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="#"><i class="fa-solid fa-bolt"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/Mobile.php"><i class="fa-solid fa-mobile-screen-button"></i></a>
        </li>
        <li class="menu__item">
        <a class="items" href="../assetLists/SIM.php"><i class="fa-solid fa-sim-card"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="../admin/employeeLists.php"><i class="fa-solid fa-address-book"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="../admin/adminConfig.php"><i class="fa-solid fa-gears"></i></a>
        </li>
        <li class="menu__item">
        <a class="disabled items" href="../admin/reference.php"><i class="fa-solid fa-asterisk"></i></a>
        <!-- <a href="../admin/references.php"><i class="fa-solid fa-asterisk"></i></a> -->
        </li>
    </ul>
<?php } ?>
</div>

<!-- Scripts -->
<!-- ApexCharts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
<!-- Custom JS -->
<script src="../js/dashboard.js"></script>
<!-- Passing value -->
<script> const chartData = <?php include '../class/fetch_data.php'; echo json_encode($data); ?>; </script>
<!-- menu js -->
<script>
const wrapper = document.querySelector('.menu__wrapper');

wrapper.addEventListener('click', () => {
    wrapper.classList.toggle('active');
})

function toggleDim() {
    var dimBackground = document.querySelector('.dim-background');
    dimBackground.style.display = dimBackground.style.display === 'block' ? 'none' : 'block';

}
</script>
</body>
</html>