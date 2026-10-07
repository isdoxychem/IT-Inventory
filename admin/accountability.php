<?php
include '../inc/auth.php';

if(isset($_GET['id'])) {

    $selectedReferenceCode = $_GET['id'];

    $sql =  
        "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
            e.id, e.name AS ename, e.division AS edivision, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef, r.referenceStatus 
        FROM assets_tbl AS a 
        LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
        WHERE (r.referenceStatus=1 OR r.referenceStatus=2) AND r.accountabilityRef='$selectedReferenceCode'";  

    $res = mysqli_query($db->conn, $sql);

    while($row = mysqli_fetch_assoc($res)) {
        $assetTags[] = $row['assettag'];
        $acc_ref = $row['accountabilityRef'];
        $empId = $row['rname'];
        
    }
    $result = $operation->getSpecificEmp($empId);

    while($row = mysqli_fetch_assoc($result)) {
        $empName = $row['name'];
        $dept = $row['division'];
    }

    if($dept === "Sauber") {
        $logo_src = "../assets/sauber-logo.png"; 
        $company = "Sauber Professionals";
    } else {
        $logo_src = "../assets/logo.png";
        $company = "Oxychem Corporation";
    }
 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/accountability.css">
    <title>Accountability Form</title>
</head>
<body>
    <div class="content">
        <div class="logo">
            <a href="javascript:history.back()">
                <img src="<?php echo $logo_src; ?>" width="150px"></img>
            </a>
        </div>
        <br>
        <center>
        <h2>Accountability Form</h2>
        </center>
        <div class="reference-code" align="right">
            <?php echo "<b>Ref#: " . $acc_ref . "</b>"; ?>
        </div>
            <table class="assets-table">
                <tr>
                    <th>Tag</th>
                    <th>Model</th>
                    <th>Specs</th>
                    <th>Serial</th>
                    <th>Deployed on</th>
                    <th>Remarks</th>
                </tr>
                <?php
                // Function for getting all same reference codes
                $getAll = $operation->getAllSameCodes($selectedReferenceCode);
                while($row = mysqli_fetch_assoc($getAll)) {
                    $assettag = $row['assettag'];
                    $model = $row['model'];

                    $serial = $row['serial'];
                    $datedeployed = $row['datedeployed'];
                    $remarks = $row['remarks'];

                    $specifications = $operation->specificationCondition([$row['aId']]);
                ?>
                    <tr>
                        <td><?php echo $assettag; ?></td>
                        <td><?php echo $model; ?></td>
                        <td><?php echo $specifications; ?></td>
                        <td><?php echo $serial; ?></td>
                        <td><?php echo $datedeployed; ?></td>
                        <td><?php echo $remarks; ?></td>    
                    </tr>
                <?php
                }
                    
                ?>
            </table>
            <?php include("../inc/accountability_info.php"); ?>
            
    </div>
        
    <?php
} else {
    ?>
    <script>
        alert('Please select asset');
        window.location.replace('employeeLists.php');
    </script>
    <?php
}
?>
<script src="../js/print.js"></script>
</body>
</html>