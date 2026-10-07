<?php 
include '../inc/auth.php';
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

$sqlSelectAll = "SELECT a.*, e.* 
                FROM assets_tbl AS a 
                INNER JOIN employee_tbl AS e ON e.id = a.empId 
                WHERE a.status!='Archive'";
                // "SELECT *
                // FROM assets_tbl 
                // WHERE status!='Archive'";
$results = mysqli_query($db->conn, $sqlSelectAll);

$results_per_page = 15;

if (!isset ($_GET['page']) ) {  
    $page = 1;  
} elseif ($_GET['page'] === 'all') {  
    $sql =  "SELECT a.*, a.Id AS aId, e.* 
            FROM assets_tbl AS a 
            INNER JOIN employee_tbl AS e ON e.id = a.empId 
            WHERE a.status!='Archive'";
    // $sql =  "SELECT * 
    //         FROM assets_tbl 
    //         WHERE status!='Archive'";
    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
} else {
    $page = $_GET['page'];  
}

$rowCount = $results->num_rows;
$number_of_page = ceil ($rowCount / $results_per_page);  
$page_first_result = ($page-1) * $results_per_page;  

if (!isset($_GET['page']) || $_GET['page'] !== 'all') {
    $sql =  "SELECT a.*, a.Id AS aId, e.* 
            FROM assets_tbl AS a 
            INNER JOIN employee_tbl AS e ON e.id = a.empId 
            WHERE a.status!='Archive' 
            LIMIT ". $page_first_result . ',' . $results_per_page;

    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
}

$res = mysqli_query($db->conn, $sql);
$rowCountPage = $res->num_rows;

$rows = [];
while ($row = mysqli_fetch_assoc($res)) {
    $rows[] = $row;
}

// Sort the result array by assettag
usort($rows, function($a, $b) {
    preg_match('/\d+$/', $a['assettag'], $aMatches);
    preg_match('/\d+$/', $b['assettag'], $bMatches);
    $aNum = intval($aMatches[0] ?? 0);
    $bNum = intval($bMatches[0] ?? 0);

    if ($aNum == $bNum) {
        return strcmp($a['assettag'], $b['assettag']);
    }
    return ($aNum < $bNum) ? -1 : 1;
});  
?>       
<form method="post" action="report.php">
    <main class="table">
        <section class="table__header">
            <button type="submit" class="link-btn" name="turnover">Report</button>
            <div class="input-group">
                <input type="search" id="searchInput" placeholder="Search Data...">
                <img src="../assets/icons/search.png" alt="">
            </div>
            <p><b style="color: yellow; font-size: 20px; margin-top: 10px;" class="result-count"><?php echo $rowCountPage; ?></b> result/s.</p>
        </section>
        <section class="table__body">
            <table id="myTable2">
                <thead>
                    <tr>
                        <th width="1%"><input type="checkbox" onClick="toggle(this)" id="selectAll" name="selectAll"></th>
                        <th>Asset Tag <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Location <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Model <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Specification <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Status <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($rows as $row): 
                            $specifications = $operation->reportSpecificationCondition([$row['aId']]);
                    ?>
                    <tr>
                        <td><input type="checkbox" class="select" id="select" name="select[]" value="<?php echo $row['aId']; ?>"></td>
                        <td><a href="../update/assetUpd.php?id=<?php echo $row['aId']; ?>"><strong><?php echo $row['assettag']; ?></strong></a></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['model']; ?></td>
                        <td><?php echo $specifications; ?></td>
                        <td><?php echo "<span class='statusSpan'>". $row['status'] ."</span>"; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <?php 
            if($rowCountPage != $rowCount) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="allRecord.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'activePage' : ''; // Add active class to current page
                    echo '<a href="allRecord.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="allRecord.php?page=' . ($page + 1) . '" class="next">Next</a>';
                    echo '<a href="allRecord.php?page=all" class="next">All</a>';
                }
                echo '</div>';

            }
        ?>

    </main>
</form>
<script src="../js/allRecordSort.js"></script>

</body>
</html>