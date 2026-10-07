<?php
include '../inc/auth.php';
    
if(isset($_GET['id'])) {
    
    $selectedReferenceCode = $_GET['id'];

    $sql = "SELECT a.id AS aId, a.empId AS empId, a.status, a.assettype AS assettype, a.assettag, a.model, a.serial, a.remarks, a.datedeployed, 
        e.id, e.name AS ename, e.division, r.assetId, r.name AS rname, r.accountabilityRef, r.turnoverRef 
        FROM assets_tbl AS a 
        LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
        LEFT JOIN employee_tbl AS e ON a.empId = e.id 
        WHERE r.turnoverRef = '$selectedReferenceCode'";  

    $res = mysqli_query($db->conn, $sql);

    while($row = mysqli_fetch_assoc($res)) {
        $assetTags[] = $row['assettag'];
        $trn_ref = $row['turnoverRef'];

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
    <title>Turnover Form</title>
</head>
<body>
    <div class="content">
        <div class="logo">
            <!-- <a href="employeeLists.php"><img src="../assets/logo.png" width="150px"></img></a> -->
            <a href="javascript:history.back()"><img src="../assets/logo.png" width="150px"></img></a>
        </div>
        <br>
        <center>
        <h2>Turnover Form</h2>
        </center>
        <div class="reference-code" align="right">
            <?php echo "<b>Ref#: " . $trn_ref . "</b>"; ?>
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
        <div class="info"><br><br>
            <h3>Acknowledgment:</h3>
            <p>
            &nbsp;&nbsp;I, <b><?php echo $empName; ?></b>, acknowledge that I have returned the above-mentioned equipment in the condition stated above. I understand that any damage or missing items may result in charges or disciplinary action.
            <br><br>
            <p>
            &nbsp;&nbsp;I, the undersigned, approve the transfer of the equipment as documented in this form.<br><br>
            Signature: __________________    <br>Date: __________</p>
            <br><br>
            [For Asset Administrator Use Only]<br><br>
            <h3>Asset Status:</h3>
            <p>
            ☐ Accepted in Good Condition<br>
            ☐ Accepted with Noted Issues (please specify): _______________________
            </p>
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