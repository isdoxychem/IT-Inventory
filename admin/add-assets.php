<?php 
include '../inc/auth.php';

if(isset($_GET['id'])) {
    $id = $_GET['id']; 
} else {
    $id = 'default';
}

if(isset($_POST['save'])) {
    $operation->checkAssetCount($_POST['asset-type']);  

    $result = $operation->recordAssetData($_POST['asset-type'], $_POST['asset-tag'], 
    isset($_POST['model']) ? $_POST['model'] : '', isset($_POST['serial']) ? $_POST['serial'] : '', $_POST['supplier'], 
    isset($_POST['assigned']) ? $_POST['assigned'] : '', isset($_POST['lastused']) ? $_POST['lastused'] : '', 
    $_POST['status'], $_POST['dateprchs'], 
    isset($_POST['cost']) ? mysqli_real_escape_string($db->conn, str_replace(',', '', $_POST['cost'])) : '', 
    isset($_POST['repair-cost']) ? mysqli_real_escape_string($db->conn, str_replace(',', '', $_POST['repair-cost'])) : '', 
    $_POST['remarks'], $_POST['datedeployed'], 
    isset($_POST['processor']) ? mysqli_real_escape_string($db->conn, $_POST['processor']) : '', isset($_POST['memory']) ? mysqli_real_escape_string($db->conn, $_POST['memory']) : '',
    isset($_POST['storage']) ? mysqli_real_escape_string($db->conn, $_POST['storage']) : '', isset($_POST['dimes']) ? mysqli_real_escape_string($db->conn, $_POST['dimes']) : '',
    isset($_POST['mobile']) ? mysqli_real_escape_string($db->conn, $_POST['mobile']) : '', isset($_POST['plan']) ? mysqli_real_escape_string($db->conn, $_POST['plan']) : '',
    isset($_POST['os']) ? mysqli_real_escape_string($db->conn, $_POST['os']) : '', $_POST['action']);
    
    if ($result >= 1 && $result <= 8) {
        $urls = [
            1 => "../assetLists/Laptop.php",
            2 => "../assetLists/Desktop.php",
            3 => "../assetLists/Monitor.php",
            4 => "../assetLists/Printer.php",
            5 => "../assetLists/UPS.php",
            6 => "../assetLists/Mobile.php",
            7 => "../assetLists/SIM.php",
            8 => "../assetLists/Laptop.php",
        ];
    
        $url = $urls[$result];
    
        echo "<script> alert('Data Stored successfully!'); </script>";
        header("Refresh:0; url= $url");

    } elseif ($result == 100) {
        echo "<script> alert('Failed'); </script>";

        // die();
    }           
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <title>Add Assets</title>
</head>
<body>
<?php include '../inc/header.php'; ?>

    <div class="container">
        <div class="add-form">
            <?php 
                if($id == 'recordDesktop') { 
                    $url = "../assetLists/Desktop.php";
                } elseif($id == 'recordLaptop') {
                    $url = "../assetLists/Laptop.php";
                } elseif($id == 'recordMonitor') {
                    $url = "../assetLists/Monitor.php";
                } elseif($id == 'recordPrinter') {
                    $url = "../assetLists/Printer.php";
                } elseif($id == 'recordMobile') {
                    $url = "../assetLists/Mobile.php";
                } elseif($id == 'recordSim') {
                    $url = "../assetLists/SIM.php";
                } elseif($id == 'recordUps') {
                    $url = "../assetLists/UPS.php";
                } else {
                    $url = "../admin/dashboard.php"; // Change name to 'All Assets'
                }

                echo "<a href=\"$url\" class=\"return\">Back</a>";
            ?>

                <form action="" method="POST">
                    <div class="title">Asset Details</div>
                    <div class="asset-details">

                        <div class="input-box" style="width: 100%;">
                            <span class="details">Asset Type</span>       
                                <?php
                                $assettype = $operation->getAssets($id);

                                if($id == 'recordUps') {
                                ?>
                                    <select name="asset-type">
                                    <?php
                                        foreach($assettype as $assets) {
                                            $assetType = $assets['assetType'];
                                    ?>
                                        <option value="<?=$assets['assetType']?>"><?=$assets['assetType']?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                <?php
                                } else {
                                    foreach($assettype as $assets) {
                                        $assetType = $assets['assetType'];
                                ?>
                                    <input type="text" name="asset-type" style="background-color: #ccc; text-align: center; font-weight: 600; cursor: default;" readonly value="<?=$assets['assetType']?>">
                                <?php
                                    }
                                }
                                ?>
                        </div>   

                        <div class="input-box" hidden>
                            <span class="details" style="margin-bottom: 10px;">Hidden Tag</span>
                            <div class="asset-tag" id="tag" style="background-color: #ccc;"></div>
                            <input type="text" name="asset-tag" id="asset-tag">
                        </div>

                    <?php 
                    switch($id) {
                        case 'recordDesktop':
                        case 'recordLaptop':
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" id="">
                                </div>
                                
                                <div class="input-box" id="serial">
                                    <span class="details">Serial no.</span>
                                    <input type="text" name="serial" placeholder="Serial Number" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Supplier</span>
                                    <input type="text" name="supplier" placeholder="Supplier" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Cost</span>
                                    <input type="text" name="cost" placeholder="Item cost.." id="">
                                </div>
                                
                                <div class="input-box">
                                    <span class="details">Date Purchased</span>
                                    <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                                </div>
                                <div class="input-box">
                                    <span class="details" style="margin-bottom: 10px;">Status</span>
                                    <select name="status" id="status" onChange="changetextbox()" required>
                                        <option value='' hidden selected disabled>Please select</option>
                                        <option value="For repair">For repair</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="To be deploy">To be deploy</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Missing">Missing</option>
                                    </select>
                                </div>
                                <div class="input-box" id="repair-cost" style="display: none;">
                                    <span class="details">Repair Cost</span>
                                    <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
                                </div>
                                <div class="input-box">
                                    <span class="details">Remarks</span>
                                    <input type="text" name="remarks" placeholder="Remarks" id="">
                                </div>
                            
                            </div>
                            <div class="title">Specification</div>
                            <div class="asset-details">
                                <div class="input-box" id="processor">
                                    <span class="details">Processor</span>
                                    <input type="text" name="processor" placeholder="Processor" id="">
                                </div>
                                <div class="input-box" id="ram">
                                    <span class="details">Memory</span>
                                    <input type="text" name="memory" placeholder="Memory" id="">
                                </div>
                                <div class="input-box" id="storage">
                                    <span class="details">Storage</span>
                                    <input type="text" name="storage" placeholder="Storage" id="">
                                </div>
                                <div class="input-box" id="os">
                                    <span class="details">Operating System</span>
                                    <input type="text" name="os" placeholder="Operating System" id="">
                                </div>

                            </div>

                            <?php
                        break;

                        case 'recordMobile':
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" id="">
                                </div>
                                
                                <div class="input-box" id="serial">
                                    <span class="details">Serial no.</span>
                                    <input type="text" name="serial" placeholder="Serial Number" id="">
                                </div>

                                <div class="input-box">
                                    <span class="details">Supplier</span>
                                    <input type="text" name="supplier" placeholder="Supplier" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Cost</span>
                                    <input type="text" name="cost" placeholder="Item cost.." id="">
                                </div>
                                
                                <div class="input-box">
                                    <span class="details">Date Purchased</span>
                                    <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                                </div>
                                <div class="input-box">
                                    <span class="details" style="margin-bottom: 10px;">Status</span>
                                    <select name="status" id="status" onChange="changetextbox()" required>
                                        <option value='' hidden selected disabled>Please select</option>
                                        <option value="For repair">For repair</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="To be deploy">To be deploy</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Missing">Missing</option>
                                    </select>
                                </div>
                                <div class="input-box" id="repair-cost" style="display: none;">
                                    <span class="details">Repair Cost</span>
                                    <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
                                </div>
                                <div class="input-box">
                                    <span class="details">Remarks</span>
                                    <input type="text" name="remarks" placeholder="Remarks" id="">
                                </div>
                            
                            </div>
                            <div class="title">Specification</div>
                            <div class="asset-details">

                                <div class="input-box" id="ram">
                                    <span class="details">Memory</span>
                                    <input type="text" name="memory" placeholder="Memory" id="">
                                </div>
                                <div class="input-box" id="storage">
                                    <span class="details">Storage</span>
                                    <input type="text" name="storage" placeholder="Storage" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details" style="margin-bottom: 10px;">Plan</span>
                                    <select name="plan" id="plan" required>
                                        <option value='' hidden selected disabled>Please select</option>
                                        <option value="Purchase">Purchase</option>
                                        <option value="Postpaid">Postpaid</option>
                                    </select>
                                    </span>
                                </div>

                            </div>

                            <?php
                        break;
                        
                        case 'recordSim':
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Supplier</span>
                                    <input type="text" name="supplier" placeholder="Supplier" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Cost</span>
                                    <input type="text" name="cost" placeholder="Item cost.." id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Date Purchased</span>
                                    <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                                </div>
                                <div class="input-box">
                                    <span class="details" style="margin-bottom: 10px;">Status</span>
                                    <select name="status" id="status" onChange="changetextbox()" required>
                                        <option value='' hidden selected disabled>Please select</option>
                                        <option value="For repair">For repair</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="To be deploy">To be deploy</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Missing">Missing</option>
                                    </select>
                                </div>
                                <div class="input-box" id="repair-cost" style="display: none;">
                                    <span class="details">Repair Cost</span>
                                    <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
                                </div>
                                <div class="input-box">
                                    <span class="details">Remarks</span>
                                    <input type="text" name="remarks" placeholder="Remarks" id="">
                                </div>
                            
                            </div>
                            <div class="title">Specification</div>
                            <div class="asset-details">

                                <div class="input-box" id="plan">
                                    <span class="details" style="margin-bottom: 10px;">Plan</span>
                                    <select name="plan" id="plan" required>
                                        <option value='' hidden selected disabled>Please select</option>
                                        <option value="Prepaid">Prepaid</option>
                                        <option value="Postpaid">Postpaid</option>
                                    </select>
                                </div>

                                <div class="input-box" id="mobile">
                                    <span class="details">Mobile no.</span>
                                    <input type="text" name="mobile" placeholder="Mobile no." id="">
                                </div>
                            
                            </div>
                            
                            <?php
                        break;
                        
                        case 'recordMonitor':
                        case 'recordUps':
                        case 'recordAVR':
                        case 'recordPrinter':
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" id="">
                                </div>
                                <div class="input-box" id="serial">
                                    <span class="details">Serial no.</span>
                                    <input type="text" name="serial" placeholder="Serial Number" id="">
                                </div>

                                <div class="input-box">
                                    <span class="details">Supplier</span>
                                    <input type="text" name="supplier" placeholder="Supplier" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Cost</span>
                                    <input type="text" name="cost" placeholder="Item cost.." id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Date Purchased</span>
                                    <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                                </div>
                                <div class="input-box">
                                    <span class="details" style="margin-bottom: 10px;">Status</span>
                                    <select name="status" id="status" onChange="changetextbox()" required>
                                        <option value='' hidden selected disabled>Please select</option>
                                        <option value="For repair">For repair</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="To be deploy">To be deploy</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Missing">Missing</option>
                                    </select>
                                </div>
                                <div class="input-box" id="repair-cost" style="display: none;">
                                    <span class="details">Repair Cost</span>
                                    <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
                                </div>
                                <div class="input-box">
                                    <span class="details">Remarks</span>
                                    <input type="text" name="remarks" placeholder="Remarks" id="">
                                </div>
                            
                            </div>
                            <div class="title">Specification</div>
                            <div class="asset-details">
                                <div class="input-box" id="dimes">
                                    <?php if($assetType == 'Printer') { ?>
                                        <span class="details">Type</span>
                                        <input type="text" name="dimes" placeholder="Type" id="">
                                    <?php } elseif($assetType == 'UPS' || $assetType == 'AVR') { ?>
                                        <span class="details">Volt-Amp</span>
                                        <input type="text" name="dimes" placeholder="Volt-Amphere" id="">
                                    <?php } elseif($assetType == 'Router' || $assetType == 'Switch' || $assetType == 'Projector' || $assettype='DVR' || $assetType == 'Others') { ?>
                                        <span class="details">Description</span>
                                        <input type="text" name="dimes" placeholder="device desc.." id="">
                                    <?php } else { ?>
                                        <span class="details">Dimension</span>
                                        <input type="text" name="dimes" placeholder="Dimension" id="">
                                    <?php } ?>

                                </div>
                            </div> 

                            <?php
                        break;

                        default:
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" id="">
                                </div>
                                
                                <div class="input-box" id="serial">
                                    <span class="details">Serial no.</span>
                                    <input type="text" name="serial" placeholder="Serial Number" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Supplier</span>
                                    <input type="text" name="supplier" placeholder="Supplier" id="">
                                </div>
                                <div class="input-box">
                                    <span class="details">Cost</span>
                                    <input type="text" name="cost" placeholder="Item cost.." id="">
                                </div>
                                
                                <div class="input-box">
                                    <span class="details">Date Purchased</span>
                                    <input type="date" name="dateprchs" placeholder="Date Purchased" id="" required>
                                </div>
                                <div class="input-box">
                                    <span class="details" style="margin-bottom: 10px;">Status</span>
                                    <select name="status" id="status" onChange="changetextbox()" required>
                                        <option value='' selected disabled>Please select</option>
                                        <option value="For repair">For repair</option>
                                        <option value="Deployed">Deployed</option>
                                        <option value="To be deploy">To be deploy</option>
                                        <option value="Defective">Defective</option>
                                        <option value="Sell">Sell</option>
                                        <option value="Missing">Missing</option>
                                    </select>
                                </div>
                                <div class="input-box" id="repair-cost" style="display: none;">
                                    <span class="details">Repair Cost</span>
                                    <input type="text" name="repair-cost" value="" placeholder="Repair Cost...">
                                </div>
                                <div class="input-box">
                                    <span class="details">Remarks</span>
                                    <input type="text" name="remarks" placeholder="Remarks" id="">
                                </div>
                            
                            </div>
                            <div class="title">Specification</div>
                            <div class="asset-details">
                                <div class="input-box" id="processor">
                                    <span class="details">Processor</span>
                                    <input type="text" name="processor" placeholder="Processor" id="">
                                </div>
                                <div class="input-box" id="ram">
                                    <span class="details">Memory</span>
                                    <input type="text" name="memory" placeholder="Memory" id="">
                                </div>
                                <div class="input-box" id="storage">
                                    <span class="details">Storage</span>
                                    <input type="text" name="storage" placeholder="Storage" id="">
                                </div>
                                <div class="input-box" id="os">
                                    <span class="details">Operating System</span>
                                    <input type="text" name="os" placeholder="Operating System" id="">
                                </div>
                            </div> 

                            <?php
                        break;
                    } 
                    ?>

                    <div class="title">Accountable</div>
                    <div class="asset-details">
                        <div class="input-box" id="datedeployed" style="display: none;">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="" id="">
                        </div>

                        <div class="input-box" id="assignedto" style="display: none;">
                            <span class="details" style="margin-bottom: 10px;">Assign To</span>
                            <select name="assigned" id="assigned" class="assigned">
                                <option value='' selected>Please Select</option>
                                <?php
                                        $user = $getAllUser->selectAllEmp();
                                        foreach($user as $row) {
                                ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                                    }
                                    
                                ?>
                            </select>
                        </div>
                        <?php if($role == 'admin' || $role == 'utilities') { ?>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <!-- <input type="text" name="lastused" placeholder="Last used by.." style="background-color: #ccc; font-weight: 600;" value="?=$result['']?>" readonly id=""> -->
                            <select name="lastused" id="lastused" class="assigned">
                                <option value='' selected>Please Select</option>
                                <?php
                                        foreach($user as $row) {
                                ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php
                                    }
                                    
                                ?>
                            </select>
                        </div>
                        <?php } ?>

                    </div>

                    <div class="button">
                        <input type="hidden" name="action" value="<?php echo $id; ?>"/>
                        <input type="submit" onclick="passValue()" value="Save" name="save"/>
                    </div>
                </form>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
</html>