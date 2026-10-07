<<<<<<< HEAD
<?php include '../inc/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <title>Update</title>
</head>
<body>
<?php include '../inc/header.php'; ?>

    <div class="container">
        <div class="add-form">
            <a href="javascript:history.back()" class="return">Go back</a>

            <div class="title">Reference Details</div>
            <?php
            // if(isset($_GET['Acct_id']) || isset($_GET['acctRef'])) {
            if(isset($_GET['acctRef'])) {
                // $refId = mysqli_real_escape_string($db->conn, $_GET['Acct_id']); // refId from reference tbl
                $refNo = mysqli_real_escape_string($db->conn, $_GET['acctRef']); // refId from reference tbl
                if(isset($_GET['name'])) { 
                    $empName = mysqli_real_escape_string($db->conn, $_GET['name']);
                }

                $result = $assetController->editReference($refNo);

                if($result) {
                    $assetIds = is_array($result['rAssetId']) ? implode(',', $result['rAssetId']) : $result['rAssetId'];
                    // $trnStatus = $result['turnoverStatus'];
                    // $trnoFile = $result['turnoverFile'];
                    $accStatus = $result['accountabilityStatus'];
                    $acctFile = $result['accountabilityFile'];
            ?>
                <form action="../admin/update-selected.php" method="POST" enctype="multipart/form-data">
                    <div class="asset-details">
                        <input type="hidden" name="id" value="<?=$result['accountabilityRef']?>">
                        <input type="hidden" name="eId" value="<?=$result['name']?>">
                        <input type="hidden" name="eName" value="<?=$empName?>">
                        <!-- <input type="text" name="assetId[]" value="?=$assetId?>"> -->
                        <?php 
                            $assetIdArray = explode(',', $assetIds); 
                            foreach ($assetIdArray as $assetId) {
                            ?>
                                <input type="text" name="assetId[]" value="<?=$assetId?>">
                            <?php 
                            }
                        ?>

                        <div class="input-box" style="width: 100%;">
                            <span class="details">Assigned to: </span>
                            <input type="text" name="name" value="<?=$empName?>" style="background-color: #ccc; font-weight: 600; text-align: center;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Accountability Code</span>
                            <input type="text" value="<?=$result['accountabilityRef'] ?>" style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="acctStatus">

                            <?php
                            switch($accStatus) {
                                case 1:
                                    $accStatus = 'On Process';
                                    ?>
                                        <option value="<?=$result['accountabilityStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="2">Signed</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                case 2:
                                    $accStatus = 'Signed';
                                    ?>
                                        <option value="<?=$result['accountabilityStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                default:
                                    $accStatus = 'N/A';
                                    ?>
                                        <option value="<?=$result['accountabilityStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="2">Signed</option>
                                    <?php
                                    break;
                            }
                            ?>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Accountability File</span>
                            <input type="file" name="acctfile" id="acctfile" accept="files/*">
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <input type="date" name="acctDate" id="acctDate" value="<?=$result['accountabilityDate']?>">
                        </div>
                    </div>
                    <div class="button">
                        <input type="hidden" name="accountabilityFile" id="" value="<?=$acctFile?>">
                        <input type="hidden" name="action" id="" value="AccountabilityRef">
                        <input type="submit" onclick="passValue()" value="Save" name="update-acctRef"/>
                    </div>
                </form>
            <?php 
                } else {
                    echo "No data found";
                }
            } elseif(isset($_GET['turnoverRef'])) {
                
                $refId = mysqli_real_escape_string($db->conn, $_GET['turnoverRef']); // refId from reference tbl
                if(isset($_GET['name'])) { 
                    $empName = mysqli_real_escape_string($db->conn, $_GET['name']);
                }
                $result = $assetController->editReference($refId);

                if($result) {
                    $assetIds = is_array($result['rAssetId']) ? implode(',', $result['rAssetId']) : $result['rAssetId'];
                    $trnStatus = $result['turnoverStatus'];
                    $trnoFile = $result['turnoverFile'];
                    
                    if($trnStatus == 2) {
                        ?>
                            <style>
                                .trnStatus {
                                    background-color: #ccc;
                                    pointer-events: none;
                                }
                            </style>
                        <?php
                    } 
            ?>
                <form action="../admin/update-selected.php" method="POST" enctype="multipart/form-data">
                    <div class="asset-details">
                        <!-- <input type="text" name="id" value="?=$result['refId']?>"> -->
                        <input type="hidden" readonly name="id" value="<?=$result['turnoverRef']?>">
                        <input type="hidden" readonly name="eId" value="<?=$result['name']?>">
                        <input type="hidden" readonly name="eName" value="<?=$empName?>">
                        <?php 
                            $assetIdArray = explode(',', $assetIds); 
                            foreach ($assetIdArray as $assetId) {
                            ?>
                                <input type="hidden" name="assetId[]" value="<?=$assetId?>">
                            <?php 
                            }
                        ?>
                        <!-- <input type="text" readonly name="assetId[]" value="?=$assetIdArray?>"> -->

                        <div class="input-box" style="width: 100%;">
                            <span class="details">Assigned to: </span>
                            <input type="text" name="name" value="<?=$empName?>" style="background-color: #ccc; font-weight: 600; text-align: center;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Turnover Code</span>
                            <input type="text" value="<?=$result['turnoverRef'] ?>"  style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="trnStatus" class="trnStatus">

                            <?php
                            switch($trnStatus) {
                                case 1:
                                    $trnStatus = 'On Process';
                                    ?>
                                        <option value="<?=$result['turnoverStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="2">Signed</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                case 2:
                                    $trnStatus = 'Signed';
                                    ?>
                                        <option value="<?=$result['turnoverStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                default:
                                    $trnStatus = 'N/A';
                                    ?>
                                        <option value="<?=$result['turnoverStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="2">Signed</option>
                                    <?php
                            }
                            ?>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Turnover File</span>
                            <input type="file" class="trnStatus" name="trnfile" accept="files/*">
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <input type="date" name="trnDate" class="trnStatus" id="trnDate" value="<?=$result['turnoverDate']?>">
                        </div>
                    </div>
                    
                    <div class="button">
                        <input type="hidden" name="turnoverFile" id="" value="<?=$trnoFile?>">
                        <input type="hidden" name="action" id="" value="TurnoverRef">
                        <input class="trnStatus" type="submit" onclick="passValue()" value="Save" name="update-trnRef"/>
                    </div>
                </form>
            <?php 
                } else {
                    echo "No data found";
                }
            }
            ?>
                    
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/addAssets.js"></script>
</body>
=======
<?php include '../inc/auth.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/formStyles.css">
    <title>Update</title>
</head>
<body>
<?php include '../inc/header.php'; ?>

    <div class="container">
        <div class="add-form">
            <a href="javascript:history.back()" class="return">Go back</a>

            <div class="title">Reference Details</div>
            <?php
            // if(isset($_GET['Acct_id']) || isset($_GET['acctRef'])) {
            if(isset($_GET['acctRef'])) {
                // $refId = mysqli_real_escape_string($db->conn, $_GET['Acct_id']); // refId from reference tbl
                $refNo = mysqli_real_escape_string($db->conn, $_GET['acctRef']); // refId from reference tbl
                if(isset($_GET['name'])) { 
                    $empName = mysqli_real_escape_string($db->conn, $_GET['name']);
                }

                $result = $assetController->editReference($refNo);

                if($result) {
                    $assetIds = is_array($result['rAssetId']) ? implode(',', $result['rAssetId']) : $result['rAssetId'];
                    // $trnStatus = $result['turnoverStatus'];
                    // $trnoFile = $result['turnoverFile'];
                    $accStatus = $result['accountabilityStatus'];
                    $acctFile = $result['accountabilityFile'];
            ?>
                <form action="../admin/update-selected.php" method="POST" enctype="multipart/form-data">
                    <div class="asset-details">
                        <input type="hidden" name="id" value="<?=$result['accountabilityRef']?>">
                        <input type="hidden" name="eId" value="<?=$result['name']?>">
                        <input type="hidden" name="eName" value="<?=$empName?>">
                        <!-- <input type="text" name="assetId[]" value="?=$assetId?>"> -->
                        <?php 
                            $assetIdArray = explode(',', $assetIds); 
                            foreach ($assetIdArray as $assetId) {
                            ?>
                                <input type="text" name="assetId[]" value="<?=$assetId?>">
                            <?php 
                            }
                        ?>

                        <div class="input-box" style="width: 100%;">
                            <span class="details">Assigned to: </span>
                            <input type="text" name="name" value="<?=$empName?>" style="background-color: #ccc; font-weight: 600; text-align: center;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Accountability Code</span>
                            <input type="text" value="<?=$result['accountabilityRef'] ?>" style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="acctStatus">

                            <?php
                            switch($accStatus) {
                                case 1:
                                    $accStatus = 'On Process';
                                    ?>
                                        <option value="<?=$result['accountabilityStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="2">Signed</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                case 2:
                                    $accStatus = 'Signed';
                                    ?>
                                        <option value="<?=$result['accountabilityStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                default:
                                    $accStatus = 'N/A';
                                    ?>
                                        <option value="<?=$result['accountabilityStatus']?>"><?php echo $accStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="2">Signed</option>
                                    <?php
                                    break;
                            }
                            ?>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Accountability File</span>
                            <input type="file" name="acctfile" id="acctfile" accept="files/*">
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <input type="date" name="acctDate" id="acctDate" value="<?=$result['accountabilityDate']?>">
                        </div>
                    </div>
                    <div class="button">
                        <input type="hidden" name="accountabilityFile" id="" value="<?=$acctFile?>">
                        <input type="hidden" name="action" id="" value="AccountabilityRef">
                        <input type="submit" onclick="passValue()" value="Save" name="update-acctRef"/>
                    </div>
                </form>
            <?php 
                } else {
                    echo "No data found";
                }
            } elseif(isset($_GET['turnoverRef'])) {
                
                $refId = mysqli_real_escape_string($db->conn, $_GET['turnoverRef']); // refId from reference tbl
                if(isset($_GET['name'])) { 
                    $empName = mysqli_real_escape_string($db->conn, $_GET['name']);
                }
                $result = $assetController->editReference($refId);

                if($result) {
                    $assetIds = is_array($result['rAssetId']) ? implode(',', $result['rAssetId']) : $result['rAssetId'];
                    $trnStatus = $result['turnoverStatus'];
                    $trnoFile = $result['turnoverFile'];
                    
                    if($trnStatus == 2) {
                        ?>
                            <style>
                                .trnStatus {
                                    background-color: #ccc;
                                    pointer-events: none;
                                }
                            </style>
                        <?php
                    } 
            ?>
                <form action="../admin/update-selected.php" method="POST" enctype="multipart/form-data">
                    <div class="asset-details">
                        <!-- <input type="text" name="id" value="?=$result['refId']?>"> -->
                        <input type="hidden" readonly name="id" value="<?=$result['turnoverRef']?>">
                        <input type="hidden" readonly name="eId" value="<?=$result['name']?>">
                        <input type="hidden" readonly name="eName" value="<?=$empName?>">
                        <?php 
                            $assetIdArray = explode(',', $assetIds); 
                            foreach ($assetIdArray as $assetId) {
                            ?>
                                <input type="hidden" name="assetId[]" value="<?=$assetId?>">
                            <?php 
                            }
                        ?>
                        <!-- <input type="text" readonly name="assetId[]" value="?=$assetIdArray?>"> -->

                        <div class="input-box" style="width: 100%;">
                            <span class="details">Assigned to: </span>
                            <input type="text" name="name" value="<?=$empName?>" style="background-color: #ccc; font-weight: 600; text-align: center;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details">Turnover Code</span>
                            <input type="text" value="<?=$result['turnoverRef'] ?>"  style="background-color: #ccc;" readonly>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Status</span>
                            <select name="trnStatus" class="trnStatus">

                            <?php
                            switch($trnStatus) {
                                case 1:
                                    $trnStatus = 'On Process';
                                    ?>
                                        <option value="<?=$result['turnoverStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="2">Signed</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                case 2:
                                    $trnStatus = 'Signed';
                                    ?>
                                        <option value="<?=$result['turnoverStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="0">N/A</option>
                                    <?php
                                    break;
                                default:
                                    $trnStatus = 'N/A';
                                    ?>
                                        <option value="<?=$result['turnoverStatus']?>"><?php echo $trnStatus; ?></option>
                                        <option value="1">On Process</option>
                                        <option value="2">Signed</option>
                                    <?php
                            }
                            ?>
                                
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details" style="margin-bottom: 10px;">Turnover File</span>
                            <input type="file" class="trnStatus" name="trnfile" accept="files/*">
                        </div>
                        <div class="input-box">
                            <span class="details">Date</span>
                            <input type="date" name="trnDate" class="trnStatus" id="trnDate" value="<?=$result['turnoverDate']?>">
                        </div>
                    </div>
                    
                    <div class="button">
                        <input type="hidden" name="turnoverFile" id="" value="<?=$trnoFile?>">
                        <input type="hidden" name="action" id="" value="TurnoverRef">
                        <input class="trnStatus" type="submit" onclick="passValue()" value="Save" name="update-trnRef"/>
                    </div>
                </form>
            <?php 
                } else {
                    echo "No data found";
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