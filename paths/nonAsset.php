<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

$sqlSelectAll = 
                "SELECT e.name AS empName, e.empStatus, e.location, e.division, e.id AS eId
                FROM employee_tbl AS e
                WHERE e.empStatus=1 AND e.id NOT IN (SELECT empId FROM assets_tbl WHERE empId != 0)
                ORDER BY empName ASC";
                // "SELECT DISTINCT r.name AS empName
                // FROM employee_tbl AS e
                // INNER JOIN reference_tbl AS r ON r.name = e.id  
                // WHERE r.name != '' 
                // AND r.accountabilityStatus = '0' 
                // AND r.referenceStatus = '1'
                // ORDER BY empName ASC";
$results = mysqli_query($db->conn, $sqlSelectAll);

$results_per_page = 15;

if (!isset ($_GET['page']) ) {  
    $page = 1;  
} elseif ($_GET['page'] === 'all') {  
    $sql = "SELECT e.name AS empName, e.empStatus, e.location, e.division, e.id AS eId
            FROM employee_tbl AS e
            WHERE e.empStatus=1 AND e.id NOT IN (SELECT empId FROM assets_tbl WHERE empId != 0)
            ORDER BY empName ASC";
    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
} else {
    $page = $_GET['page'];  
}

$rowCount = $results->num_rows;
$number_of_page = ceil ($rowCount / $results_per_page);  
$page_first_result = ($page-1) * $results_per_page;  

if (!isset($_GET['page']) || $_GET['page'] !== 'all') {
    $sql = "SELECT e.name AS empName, e.empStatus, e.location, e.division, e.id AS eId
            FROM employee_tbl AS e
            WHERE e.empStatus=1 AND e.id NOT IN (SELECT empId FROM assets_tbl WHERE empId != 0)
            ORDER BY empName ASC 
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
    preg_match('/\d+$/', $a['empName'], $aMatches);
    preg_match('/\d+$/', $b['empName'], $bMatches);
    $aNum = intval($aMatches[0] ?? 0);
    $bNum = intval($bMatches[0] ?? 0);

    if ($aNum == $bNum) {
        return strcmp($a['empName'], $b['empName']);
    }
    return ($aNum < $bNum) ? -1 : 1;
});  
?>       

<div class="content">
    <main class="table" id="customers_table">
        <section class="table__header">
            <!-- <a href="../admin/add-assets.php?id=recordLaptop" class="link-btn">New Record</a> -->
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
                        <th> Name <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Location <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Division <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Status <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>          
                    <?php
                        foreach ($rows as $row) {
                            $status = $row['empStatus'];
                            $eid = $row['eId'];
                    ?>
                    <tr>
                        <td><a href="../employee/viewEmployee.php?id=<?php echo $eid; ?>"><strong><?php echo $row['empName']; ?></strong></a></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['division']; ?></td>
                        <td><?php echo "<span class='statusSpan'>".$status."</span>" ?></td>
                        <!-- <td>
                            <a href="../update/remove.php?empID=?php echo $eid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="32px"></a>
                        </td>    -->
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
           
        </section>
        <?php 
            if($rowCountPage != $rowCount) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="nonAsset.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'activePage' : ''; // Add active class to current page
                    echo '<a href="nonAsset.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="nonAsset.php?page=' . ($page + 1) . '" class="next">Next</a>';
                    echo '<a href="nonAsset.php?page=all" class="next">All</a>';
                }
                echo '</div>';

            }
        ?>
    </main>
    <script src="../js/sort.js"></script>

</div>

</body>
</html>