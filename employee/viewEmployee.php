<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

if(isset($_GET['id']) && $_GET['id'] != '') {
    $eid = $_GET['id'];
    $rows = [];

    // Separate selected Employee
    $sqlSelectEmp = "SELECT * FROM employee_tbl WHERE id='$eid' AND empStatus='1'";
    $sqlResult = mysqli_query($db->conn, $sqlSelectEmp);
    if($sqlResult) {
        while($row = mysqli_fetch_assoc($sqlResult)) {
            $rows[] = $row;
        }
        foreach($rows as $row) {
            $empId = $row['id'];
            $name = $row['name'];
            $dept = $row['division'];
            $location = $row['location'];
        }
    } else {
        echo 'no selected. where the employee?';
        die();
    }

    $sql =
        "SELECT DISTINCT a.id AS aId, a.empId, a.assettype, a.assettag, a.status, 
        a.cpu, a.memory, a.storage, a.os, a.dimes, a.plan, a.mobile, 
        r.assetId, r.name AS rName, r.accountabilityRef, r.accountabilityStatus, r.turnoverRef, r.turnoverStatus, r.referenceStatus 
        FROM assets_tbl AS a 
        LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
        WHERE a.empId='$eid' AND r.name='$eid' AND a.status = 'Deployed' AND r.referenceStatus='1'"; 
        
    $results = mysqli_query($db->conn, $sql);
    $rowCount = $results->num_rows;
}
?>       

<style>
    .voidAsset {
        cursor: pointer;
        opacity: 0.9;
    }

    .confirmButtons {
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .confirmButtons:hover {
        opacity:1;
    }

    /* Float cancel and delete buttons and add an equal width */
    .cancelbtn, .deletebtn {
        float: left;
        width: 50%;
    }

    /* Add a color to the cancel button */
    .cancelbtn {
        background-color: #ccc;
        color: black;
    }

    /* Add a color to the delete button */
    .deletebtn {
        background-color: #f44336;
    }

    /* Add padding and center-align text to the container */
    .deleteConfirm {
        padding: 16px;
        text-align: center;

        color: black;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        align-items: center;
        justify-items: center;
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        background-color: transparent;
        padding-top: 15dvh;
    }

        /* Modal Content/Box */
    .modal-content {
        justify-content: center;
        width: 60%;
        background-color: #f1f1f1;
        margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid black;
    }
    textarea {
        padding: 10px;
    }

    /* Style the horizontal ruler */

    
    /* The Modal Close Button (x) */
    .close {
        position: absolute;
        right: 35px;
        top: 15px;
        font-size: 40px;
        font-weight: bold;
        color: black;
        z-index: 999;
    }

    .close:hover,
    .close:focus {
        color: #f44336;
        cursor: pointer;
    }

    /* Clear floats */
    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    /* Change styles for cancel button and delete button on extra small screens */
    @media screen and (max-width: 300px) {
        .cancelbtn, .deletebtn {
            width: 100%;
        }
    }
</style>

<div class="content">

    <form method="get" action="../generateCode/generate.php">
        <main class="table " id="myTable2">
            <section class="table__header">
                <div class="btn">
                <a href="../admin/employeeLists.php" class="link-btn">Back</a>
                <!-- <button type="submit" formaction="../admin/accountability.php" class="link-btn" onclick="return checkPrompt()">Generate Acc</button> -->
                    <button type="submit" name="generateAcc" class="link-btn" onclick="return checkPrompt()">Generate Accountability</button>
                    <button type="submit" name="generateTrn" class="link-btn" onclick="return checkPrompt()">Generate Turnover</button>
                </div>

                <div class="input-group">
                    <!-- <input type="search" placeholder="Search Data..."> -->
                    <input type="search" id="searchInput" placeholder="Search Data..." oninput="searchTable()">
                    <img src="../assets/icons/search.png" alt="">
                </div>
            </section>

            <section class="table__userdata">
                <div class="userData">
                <strong style="font-size: 1.5em; color: #2E4583;"><?php echo $name; ?></strong><br>
                    <p><?php echo $dept . " - " . $location ?></p>
                </div>
                <div class="rowCount">
                    <p><h1 style='color:#2E4583; font-size: 2em;' class="result-count">~<strong><?php echo $rowCount; ?></strong></h1>Accountabilities</p>
                </div>
            </section>

            <section class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th width="2%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                            <th width='60%;'> Assets <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Accountability Code <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Turnover Code <span class="icon-arrow">&UpArrow;</span></th>
                            <th width='10%'> Action <span class="icon-arrow">&UpArrow;</span></th>
                        </tr>
                    </thead>
                    <tbody>          
                        <?php
                            while ($row = mysqli_fetch_assoc($results)) {

                                $aId = $row['aId'];
                                $assettype = $row['assettype'];
                                $assettag = $row['assettag'];
                                
                                $cpu = $row['cpu'];
                                $ram = $row['memory'];
                                $storage = $row['storage'];
                                $os = $row['os'];
                                $dimes = $row['dimes'];
                                $plan = $row['plan'];
                                $mobile = $row['mobile'];
                                
                                $accountabilityRef = $row['accountabilityRef'];
                                $accountabilityStatus = $row['accountabilityStatus'];
                                $turnoverRef = $row['turnoverRef'];
                                $turnoverStatus = $row['turnoverStatus'];
                                $referenceStatus = $row['referenceStatus'];

                                $specification = $operation->specificationCondition($aId);
                        ?>
                            <tr>
                                <td><input type="checkbox" class="select" id="select" name="select[]" value="<?php echo $aId; ?>"></td>
                                <td>
                                    <a href="../update/assetRefUpd.php?id=<?php echo $aId; ?>"><strong><?php echo $row['assettag']; ?></strong></a><br>~<br>
                                    <?php echo $specification; ?>
                                </td>
                                <td><a href="../admin/accountability.php?id=<?php echo $accountabilityRef; ?>"><?php echo $accountabilityRef; ?></a></td>
                                <td><a href="../admin/turnover.php?id=<?php echo $turnoverRef; ?>"><?php echo $turnoverRef; ?></a></td>
                                <td>
                                    <?php
                                    if($turnoverStatus == '2' || $accountabilityStatus == '2') {
                                    ?>
                                        <a class="voidAsset"  href="/" onclick="return false;"><img src="../assets/icons/remove.png" style="filter: grayscale(1); cursor: default;" width="32px"></a>
                                    <?php
                                    } elseif ($accountabilityStatus!='2') {
                                    ?>
                                        <a class="voidAsset" data-asset-id="<?= $aId ?>" data-emp-id="<?= $eid ?>" onclick="showModal(this)"><img src="../assets/icons/remove.png" width="32px"></a>
                                    <?php
                                    }
                                    ?>

                                    

                                </td>   
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>      
        </main> 

    </form>
</div>



<div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
    <form class="modal-content" action="../update/remove.php">
        <div class="deleteConfirm">
        
            <h1>Void this asset?</h1><br>
            <p><label for="voidRemark">Remarks:</label></p>
            <input type="hidden" id="modal-asset-id" name="unassignId">
            <input type="hidden" id="modal-emp-id" name="empId">
            <textarea id="voidRemark" name="voidRemark" rows="4" cols="50"></textarea><br>
            
            <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn confirmButtons">Cancel</button>
                <button type="submit" onclick="document.getElementById('id01').style.display='none'" class="deletebtn confirmButtons">Delete</button>
            </div>
        </div>
    </form>
</div>

<script>
function showModal(element) {
    // Get the asset ID from the data attribute
    var assetId = element.getAttribute('data-asset-id');
    var empId = element.getAttribute('data-emp-id');
    
    // Set the asset ID in the hidden input field
    document.getElementById('modal-asset-id').value = assetId;
    document.getElementById('modal-emp-id').value = empId;

    // Show the modal
    document.getElementById('id01').style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function() {
    var spans = document.getElementsByClassName("statusSpan");
    for (var i = 0; i < spans.length; i++) {
        var span = spans[i];
        if (span.innerHTML === '1') {
            span.innerText = 'Active'; // Use innerText or textContent to update the text
            span.classList.add("status", "delivered");
        } else if (span.innerHTML === '0') {
            span.innerText = 'Inactive';
            span.classList.add("status", "cancelled");
        }
    }
});
</script>
<script src="../js/sort.js"></script>

</body>
</html>