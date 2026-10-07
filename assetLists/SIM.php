<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

$sqlSelectAll = "SELECT * FROM assets_tbl WHERE status!='Archive' AND assettype='SIM'";
$results = mysqli_query($db->conn, $sqlSelectAll);

$results_per_page = 15;
if (!isset ($_GET['page']) ) {  
    $page = 1;  
} elseif ($_GET['page'] === 'all') {  
    $sql = "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.serial, a.status, a.datepurchased, a.cost, 
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e1.id AS assignedId, e1.name AS empName, e1.division AS empDivision, e1.location AS empLocation, 
                e2.id AS lastUsedId, e2.name AS lastUsedName, e2.division AS lastUsedDivision, e2.location AS lastUsedLocation 
            FROM assets_tbl AS a 
            LEFT JOIN employee_tbl AS e1 ON e1.id = a.empId 
            LEFT JOIN employee_tbl AS e2 ON e2.id = a.lastused 
            WHERE a.status!='Archive' AND assettype='SIM'";
    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
} else {
    $page = $_GET['page'];  
}

$rowCount = $results->num_rows;
$number_of_page = ceil ($rowCount / $results_per_page);  
$page_first_result = ($page-1) * $results_per_page;  

if (!isset($_GET['page']) || $_GET['page'] !== 'all') {
    $sql = "SELECT a.id AS aId, a.assettype AS assettype, a.assettag AS assettag, a.model, a.serial, a.status, a.datepurchased, a.cost,  
                a.cpu, a.memory, a.storage, a.os, a.plan, a.dimes, a.mobile, 
                e1.id AS assignedId, e1.name AS empName, e1.division AS empDivision, e1.location AS empLocation, 
                e2.id AS lastUsedId, e2.name AS lastUsedName, e2.division AS lastUsedDivision, e2.location AS lastUsedLocation 
            FROM assets_tbl AS a 
            LEFT JOIN employee_tbl AS e1 ON e1.id = a.empId 
            LEFT JOIN employee_tbl AS e2 ON e2.id = a.lastused 
            WHERE a.status!='Archive' AND assettype='SIM' 
            LIMIT $page_first_result, $results_per_page";
    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
}

$rows = [];
while ($row = mysqli_fetch_assoc($res)) {
    $rows[] = $row;
}

// Sort the result array by assettag
usort($rows, function($a, $b) {
    // Define custom priority order for status
    $statusOrder = [
            'To be deploy' => 1,
            'Deployed' => 2,
            'For repair' => 3,
            'Defective' => 4,
            'Sell' => 5,
            'Sold' => 6,
            'Missing' => 7
        ];

    // Get priority of each status
    $aStatusPriority = $statusOrder[$a['status']] ?? 99; // Default low priority
    $bStatusPriority = $statusOrder[$b['status']] ?? 99;

    // First, sort by status priority (lower number means higher priority)
    if ($aStatusPriority != $bStatusPriority) {
        return $aStatusPriority - $bStatusPriority;
    }

    // Extract numeric part of assettag
    preg_match('/\d+$/', $a['assettag'], $aMatches);
    preg_match('/\d+$/', $b['assettag'], $bMatches);
    $aNum = intval($aMatches[0] ?? 0);
    $bNum = intval($bMatches[0] ?? 0);

    // If status is the same, sort assettag in ascending order
    return $aNum <=> $bNum; // Ascending order
});
?>       

<div class="content">
    <main class="table" id="customers_table">
        <section class="table__header">
            <!-- <button type="submit" class="link-btn" name="turnover">Report</button> -->
            <a href="../admin/add-assets.php?id=recordSim" class="link-btn">New Record</a>
            <div class="input-group">
                <input type="search" id="searchInput" placeholder="Search Data..." oninput="searchTable()">
                <img src="../assets/icons/search.png" alt="">
            </div>
            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;" class="result-count"><?php echo $rowCountPage; ?></b> result/s.</p>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Asset Tag <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Specification <span class="icon-arrow">&UpArrow;</span></th>
                        <th hidden> Assigned </th>
                        <th hidden> Lastused </th>
                        <th> Status <span class="icon-arrow">&UpArrow;</span></th>
                        <th width='10%' style="pointer-events: none;"> Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($rows as $row) {
                            $status = $row['status'];
                            $aId = $row['aId'];
                            $assetType = $row['assettype'];

                            $plan = $row['plan'];
                            $mobile = $row['mobile'];
                            $cost = $row['cost'];
                    ?>            
                    <tr>
                        <td hidden><?php echo $row['serial']; ?></td>
                        <td hidden><?php echo $row['mobile']; ?></td>
                        <td><a href="../update/assetUpd.php?id=<?php echo $aId; ?>"><strong><?php echo $row['assettag']; ?></strong></td></a>
                        <td>
                            <?php 
                            if($plan == '') {
                                echo "<i style='color:#FF6646;'>No details found.";
                            } else {
                                echo $plan . " - ₱" . $cost . "<br>- " . $mobile;
                            }
                                
                            ?>
                        </td>
                        <td hidden><?php echo $row['empName']; ?></td>
                        <td hidden><?php echo $row['lastUsedName']; ?></td>
                        <td><?php echo "<span class='statusSpan'>". $status ."</span>" ?></td>

                        <td>
                            <a href="../update/remove.php?assetID=<?php echo $aId; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="24px"></a>
                        </td>   
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
           
        </section>
        <?php 
            if($rowCountPage != $rowCount) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="SIM.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'activePage' : ''; // Add active class to current page
                    echo '<a href="SIM.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="SIM.php?page=' . ($page + 1) . '" class="next">Next</a>';
                    echo '<a href="SIM.php?page=all" class="next">All</a>';
                }
                echo '</div>';

            }
        ?>
    </main>
    <script src="../js/sort.js"></script>

</div>

</body>
</html>