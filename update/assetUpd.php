<<<<<<< HEAD
<?php 
include '../inc/auth.php';
include '../inc/formHead.php'; 
include '../inc/header.php'; 
?>
<div class="container">
    <div class="add-form">
    <!-- <a href="../admin/dashboard.php" class="return">Back</a> -->
    <button onclick="history.back()" class="return">Go Back</button>

        <div class="title">Asset Details</div>
        <?php
        if(isset($_GET['id'])) {

            $assetID = mysqli_real_escape_string($db->conn, $_GET['id']);
            $result = $assetController->edit($assetID);

            if($result) {
                $assetType = $result['assettype'];
        ?>
            <form action="../admin/update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="assetID" value="<?=$result['aId']?>">

                    <div class="input-box" style="width:100%;">
                        <span class="details">Asset Tag</span>
                        <!-- <div class="asset-tag" id="tag" hidden> -->
                        <input type="text" id="asset-tag" style="background-color: #ccc; text-align: center; font-weight: 600; cursor: default;" readonly value="<?=$result['assettag']?>">
                    </div>
                
                                            
                        <?php 
                        switch($assetType) { 
                            
                            case 'SIM': 
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                                </div>
                            <?php
                            break;

                            default:
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                                </div>
                                
                                <div class="input-box" id="serial">
                                    <span class="details">Serial no.</span>
                                    <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                                </div>
                            <?php
                        }
                        ?>

                    <div class="input-box">
                        <span class="details">Supplier</span>
                        <input type="text" name="supplier" value="<?=$result['supplier']?>" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Cost</span>
                        <input type="text" name="cost" style="background-color: #ccc; font-weight: 600;" value="<?=$result['cost']; ?>" id="">
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Date Purchased</span>
                        <input type="date" name="dateprchs" value="<?=$result['datepurchased']?>" id="" required>
                    </div>
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Status</span>
                        <select name="status" id="status" onChange="changetextbox()">
                            <option value="<?=$result['aStatus']?>"><?=$result['aStatus']?></option>
                            <option value="For repair">For repair</option>
                            <option value="Deployed">Deployed</option>
                            <option value="To be deploy">To be deploy</option>
                            <option value="Defective">Defective</option>
                            <option value="Sold">Sold</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>
                    <div class="input-box" id="repair-cost">
                        <span class="details">Repair Cost</span>
                        <input type="text" name="repair-cost" style="background-color: #ccc; font-weight: 600;" readonly value="<?=$result['repair_cost']; ?>" value="">
                    </div>
                    <div class="input-box">
                        <span class="details">Remarks</span>
                        <input type="text" name="remarks" value="<?=$result['remarks']?>" id="">
                    </div>

                </div>
                <div class="title">Specification</div>
                <div class="asset-details">

                <?php 
                switch($assetType) { 
                    case 'Laptop':
                    case 'Desktop':
                    ?>
                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['cpu']?>" placeholder="Processor" id="">
                        </div>
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['os']?>" placeholder="Operating System" id="">
                        </div>

                    <?php 
                    break;

                    case 'Mobile': 
                    ?>

                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="plan">
                            <span class="details">Plan</span>
                            <select name="plan" id="plan" class="assigned">
                                <?php
                                    $plan = $result['plan'];
                                    if($plan == 'Purchase') {
                                ?>
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Postpaid">Postpaid</option>
                                <?php
                                    } elseif($plan == 'Postpaid') { 
                                ?> 
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Purchase">Purchase</option>
                                <?php
                                    } else {
                                ?>
                                    <option value="Postpaid">Postpaid</option>
                                    <option value="Purchase">Purchase</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                    <?php 
                    break;
                    
                    case 'Monitor':
                    case 'UPS':
                    case 'Printer':
                    case 'AVR':
                    ?>
                        <div class="input-box" id="dimes">
                            <?php if($assetType == 'Printer') { ?>
                                <span class="details">Type</span>
                                <input type="text" name="dimes" placeholder="Type" value="<?=$result['dimes']?>">
                            <?php } elseif($assetType == 'UPS') { ?>
                                <span class="details">Volt-Amp</span>
                                <input type="text" name="dimes" placeholder="Volt-Amphere" value="<?=$result['dimes']?>">
                            <?php } else { ?>
                                <span class="details">Dimension</span>
                                <input type="text" name="dimes" placeholder="Dimension" value="<?=$result['dimes']?>">
                            <?php } ?>

                        </div>
                    <?php 
                    break;

                    case 'SIM': 
                    ?>

                        <div class="input-box" id="plan">
                            <span class="details" style="margin-bottom: 10px;">Plan</span>
                            <select name="plan" id="plan" class="assigned">
                                <?php
                                    $plan = $result['plan'];
                                    if($plan == 'Prepaid') {
                                ?>
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Postpaid">Postpaid</option>
                                <?php
                                    } else { 
                                ?> 
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Prepaid">Prepaid</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="input-box" id="mobile">
                            <span class="details">Mobile no.</span>
                            <input type="text" name="mobile" value="<?=$result['mobile']?>" placeholder="Mobile no." id="">
                        </div>

                    <?php 
                    break;

                    default: 
                    ?>
                    
                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['cpu']?>" placeholder="Processor" id="">
                        </div>          
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['os']?>" placeholder="Operating System" id="">
                        </div>
                        
                    <?php 
                    break;
                } ?>
                    
                </div>
                <div class="title">Accountable</div>
                    <div class="asset-details">
                    <?php 
                    $status = $result['aStatus']; 

                    switch($status) {

                        case 'Deployed':
                    ?>
                        <div class="input-box" id="assignedto">
                            <span class="details" style="margin-bottom: 10px;">Assigned To</span>
                            <select name="assigned" id="assigned" class="assigned" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['assignedId']?>"><?=$result['empName']?></option>
                                <!-- <option value=''>None</option>
                                ?php
                                    $user = $getAllUser->selectAllEmp();
                                    foreach($user as $row) {
                                ?>
                                <option value="?php echo $row['id']; ?>">
                                    ?php echo $row['name']; ?>
                                </option>
                                ?php
                                    }
                                ?> -->
                            </select>
                        </div>              

                        <div class="input-box" id="datedeployed">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="<?=$result['datedeployed']?>" id="">
                        </div>

                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <select name="lastused" id="lastused" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['lastUsedId']?>"><?=$result['lastUsedName']?></option>
                            </select>
                        </div>
                        
                    <?php
                        break; 
                        default:
                    ?>
                        <div class="input-box" id="assignedto" style="display: none;">
                            <span class="details" style="margin-bottom: 10px;">Assigned To</span>
                            <select name="assigned" id="assigned" class="assigned" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['assignedId']?>"><?=$result['empName']?></option>

                                <option value=''>None</option>
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

                        <div class="input-box" id="datedeployed" style="display: none;">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="<?=$result['datedeployed']?>" id="">
                        </div>

                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <select name="lastused" id="lastused" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['lastUsedId']?>"><?=$result['lastUsedName']?></option>
                            </select>
                        </div>
                    <?php 
                        break;
                    }
                    ?>
                    </div>
                <div class="button">
                    <input type="hidden" value="ComputerUpdate" name="action"/>
                    <input type="submit" onclick="passValue()" value="Save" name="update-asset"/>
                </div>
            </form>
            <?php
                }
            }
            ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
=======
<?php 
include '../inc/auth.php';
include '../inc/formHead.php'; 
include '../inc/header.php'; 
?>
<div class="container">
    <div class="add-form">
    <!-- <a href="../admin/dashboard.php" class="return">Back</a> -->
    <button onclick="history.back()" class="return">Go Back</button>

        <div class="title">Asset Details</div>
        <?php
        if(isset($_GET['id'])) {

            $assetID = mysqli_real_escape_string($db->conn, $_GET['id']);
            $result = $assetController->edit($assetID);

            if($result) {
                $assetType = $result['assettype'];
        ?>
            <form action="../admin/update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="assetID" value="<?=$result['aId']?>">

                    <div class="input-box" style="width:100%;">
                        <span class="details">Asset Tag</span>
                        <!-- <div class="asset-tag" id="tag" hidden> -->
                        <input type="text" id="asset-tag" style="background-color: #ccc; text-align: center; font-weight: 600; cursor: default;" readonly value="<?=$result['assettag']?>">
                    </div>
                
                                            
                        <?php 
                        switch($assetType) { 
                            
                            case 'SIM': 
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                                </div>
                            <?php
                            break;

                            default:
                            ?>
                                <div class="input-box" id="model">
                                    <span class="details">Model</span>
                                    <input type="text" name="model" placeholder="Model" value="<?=$result['model']?>" id="">
                                </div>
                                
                                <div class="input-box" id="serial">
                                    <span class="details">Serial no.</span>
                                    <input type="text" name="serial" value="<?=$result['serial']?>" placeholder="Serial Number" id="">
                                </div>
                            <?php
                        }
                        ?>

                    <div class="input-box">
                        <span class="details">Supplier</span>
                        <input type="text" name="supplier" value="<?=$result['supplier']?>" id="">
                    </div>
                    <div class="input-box">
                        <span class="details">Cost</span>
                        <input type="text" name="cost" style="background-color: #ccc; font-weight: 600;" value="<?=$result['cost']; ?>" id="">
                    </div>
                    
                    <div class="input-box">
                        <span class="details">Date Purchased</span>
                        <input type="date" name="dateprchs" value="<?=$result['datepurchased']?>" id="" required>
                    </div>
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Status</span>
                        <select name="status" id="status" onChange="changetextbox()">
                            <option value="<?=$result['aStatus']?>"><?=$result['aStatus']?></option>
                            <option value="For repair">For repair</option>
                            <option value="Deployed">Deployed</option>
                            <option value="To be deploy">To be deploy</option>
                            <option value="Defective">Defective</option>
                            <option value="Sold">Sold</option>
                            <option value="Missing">Missing</option>
                        </select>
                    </div>
                    <div class="input-box" id="repair-cost">
                        <span class="details">Repair Cost</span>
                        <input type="text" name="repair-cost" style="background-color: #ccc; font-weight: 600;" readonly value="<?=$result['repair_cost']; ?>" value="">
                    </div>
                    <div class="input-box">
                        <span class="details">Remarks</span>
                        <input type="text" name="remarks" value="<?=$result['remarks']?>" id="">
                    </div>

                </div>
                <div class="title">Specification</div>
                <div class="asset-details">

                <?php 
                switch($assetType) { 
                    case 'Laptop':
                    case 'Desktop':
                    ?>
                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['cpu']?>" placeholder="Processor" id="">
                        </div>
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['os']?>" placeholder="Operating System" id="">
                        </div>

                    <?php 
                    break;

                    case 'Mobile': 
                    ?>

                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="plan">
                            <span class="details">Plan</span>
                            <select name="plan" id="plan" class="assigned">
                                <?php
                                    $plan = $result['plan'];
                                    if($plan == 'Purchase') {
                                ?>
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Postpaid">Postpaid</option>
                                <?php
                                    } elseif($plan == 'Postpaid') { 
                                ?> 
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Purchase">Purchase</option>
                                <?php
                                    } else {
                                ?>
                                    <option value="Postpaid">Postpaid</option>
                                    <option value="Purchase">Purchase</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                    <?php 
                    break;
                    
                    case 'Monitor':
                    case 'UPS':
                    case 'Printer':
                    case 'AVR':
                    ?>
                        <div class="input-box" id="dimes">
                            <?php if($assetType == 'Printer') { ?>
                                <span class="details">Type</span>
                                <input type="text" name="dimes" placeholder="Type" value="<?=$result['dimes']?>">
                            <?php } elseif($assetType == 'UPS') { ?>
                                <span class="details">Volt-Amp</span>
                                <input type="text" name="dimes" placeholder="Volt-Amphere" value="<?=$result['dimes']?>">
                            <?php } else { ?>
                                <span class="details">Dimension</span>
                                <input type="text" name="dimes" placeholder="Dimension" value="<?=$result['dimes']?>">
                            <?php } ?>

                        </div>
                    <?php 
                    break;

                    case 'SIM': 
                    ?>

                        <div class="input-box" id="plan">
                            <span class="details" style="margin-bottom: 10px;">Plan</span>
                            <select name="plan" id="plan" class="assigned">
                                <?php
                                    $plan = $result['plan'];
                                    if($plan == 'Prepaid') {
                                ?>
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Postpaid">Postpaid</option>
                                <?php
                                    } else { 
                                ?> 
                                    <option value="<?=$result['plan']?>"><?=$result['plan']?></option>
                                    <option value="Prepaid">Prepaid</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="input-box" id="mobile">
                            <span class="details">Mobile no.</span>
                            <input type="text" name="mobile" value="<?=$result['mobile']?>" placeholder="Mobile no." id="">
                        </div>

                    <?php 
                    break;

                    default: 
                    ?>
                    
                        <div class="input-box" id="processor">
                            <span class="details">Processor</span>
                            <input type="text" name="processor" value="<?=$result['cpu']?>" placeholder="Processor" id="">
                        </div>          
                        <div class="input-box" id="ram">
                            <span class="details">Memory</span>
                            <input type="text" name="memory" value="<?=$result['memory']?>"v placeholder="Memory" id="">
                        </div>
                        <div class="input-box" id="storage">
                            <span class="details">Storage</span>
                            <input type="text" name="storage" value="<?=$result['storage']?>" placeholder="Storage" id="">
                        </div>
                        <div class="input-box" id="os">
                            <span class="details">Operating System</span>
                            <input type="text" name="os" value="<?=$result['os']?>" placeholder="Operating System" id="">
                        </div>
                        
                    <?php 
                    break;
                } ?>
                    
                </div>
                <div class="title">Accountable</div>
                    <div class="asset-details">
                    <?php 
                    $status = $result['aStatus']; 

                    switch($status) {

                        case 'Deployed':
                    ?>
                        <div class="input-box" id="assignedto">
                            <span class="details" style="margin-bottom: 10px;">Assigned To</span>
                            <select name="assigned" id="assigned" class="assigned" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['assignedId']?>"><?=$result['empName']?></option>
                                <!-- <option value=''>None</option>
                                ?php
                                    $user = $getAllUser->selectAllEmp();
                                    foreach($user as $row) {
                                ?>
                                <option value="?php echo $row['id']; ?>">
                                    ?php echo $row['name']; ?>
                                </option>
                                ?php
                                    }
                                ?> -->
                            </select>
                        </div>              

                        <div class="input-box" id="datedeployed">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="<?=$result['datedeployed']?>" id="">
                        </div>

                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <select name="lastused" id="lastused" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['lastUsedId']?>"><?=$result['lastUsedName']?></option>
                            </select>
                        </div>
                        
                    <?php
                        break; 
                        default:
                    ?>
                        <div class="input-box" id="assignedto" style="display: none;">
                            <span class="details" style="margin-bottom: 10px;">Assigned To</span>
                            <select name="assigned" id="assigned" class="assigned" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['assignedId']?>"><?=$result['empName']?></option>

                                <option value=''>None</option>
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

                        <div class="input-box" id="datedeployed" style="display: none;">
                            <span class="details">Date Deployed</span>
                            <input type="date" name="datedeployed" placeholder="Date Deployed" value="<?=$result['datedeployed']?>" id="">
                        </div>

                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Last Used by:</span>
                            <select name="lastused" id="lastused" style="background-color: #ccc; font-weight: 600;">
                                <option value="<?=$result['lastUsedId']?>"><?=$result['lastUsedName']?></option>
                            </select>
                        </div>
                    <?php 
                        break;
                    }
                    ?>
                    </div>
                <div class="button">
                    <input type="hidden" value="ComputerUpdate" name="action"/>
                    <input type="submit" onclick="passValue()" value="Save" name="update-asset"/>
                </div>
            </form>
            <?php
                }
            }
            ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
>>>>>>> a955ca4 ([ADD] Lacking Files)
</html>