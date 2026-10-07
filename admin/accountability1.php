<?php
include '../inc/auth.php';

if(isset($_GET['id'])) {

    $selectedReferenceCode = $_GET['id'];

    $sql =  
        "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
            e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef, r.referenceStatus 
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
            <a href="javascript:history.back()"><img src="../assets/logo.png" width="150px"></img></a>
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
                    <th>Asset Tag</th>
                    <th>Model</th>
                    <th>Specification</th>
                    <th>Serial no.</th>
                    <th>Date Deployed</th>
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
                    

                $result = $operation->getSpecificEmp($empId);
                
                while($row = mysqli_fetch_assoc($result)) {
                    $empName = $row['name'];
                    $dept = $row['division'];
                }
                ?>
            </table>
            <div class="info"><br>
                <h3>&nbsp;Responsibilities:</h3>
                <p>
                &nbsp;&nbsp;&nbsp;&nbsp;I, <b><?php echo $empName; ?></b>, acknowledge that the above-mentioned asset has been issued to me for the purpose of performing my job responsibilities. I understand and agree to the following responsibilities:
                <br><br></p>
                <p style="font-weight: 600;">
                1. I am responsible for the proper use and care of the assigned asset.
                <br>2. I will report any damage, loss, or malfunction of the asset to my supervisor immediately.
                <br>3. I will not loan, transfer, or dispose of the asset without prior authorization from the appropriate authority.
                <br>4. I will return the asset in good condition upon termination of my employment or upon request by the company.
                </p>
            
                <br><br>
                <h3>Asset Return:</h3>
                <p>
                &nbsp;&nbsp; &nbsp;&nbsp;I understand that I am required to return the asset on the specified date or upon termination of my employment. Failure to return the asset in good condition may result in disciplinary action and/or financial responsibility for repair or replacement costs.</p>
                <br><br><h4>Employee Signature: _________________</h4>
                    <h4>Department: <b><?php echo $dept; ?></b></h4>
                    <h4>Date: ___________</h4><br><br>

                    [For Asset Administrator Use Only]<br><br>
                    <p>Deployed by: ____________<br>
                    Signature: ______________</p>
                <br>
            </div>
            
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