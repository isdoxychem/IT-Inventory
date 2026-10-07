<?php 
include '../inc/auth.php'; 
include '../inc/listsHead.php'; 
include '../inc/header.php';    

$results = $operation->getEmp();
$results_per_page = 15;

if (!isset ($_GET['page']) ) {  
    $page = 1;  
} elseif ($_GET['page'] === 'all') {  
    $sql = "SELECT * FROM employee_tbl ORDER BY name ASC, empStatus DESC";
    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
} else {
    $page = $_GET['page'];  
}

$rowCount = $results->num_rows;
$number_of_page = ceil ($rowCount / $results_per_page);  
$page_first_result = ($page-1) * $results_per_page;  

if (!isset($_GET['page']) || $_GET['page'] !== 'all') {
    $sql = "SELECT * FROM employee_tbl ORDER BY name ASC, empStatus DESC
            LIMIT $page_first_result, $results_per_page";

    $res = mysqli_query($db->conn, $sql);
    $rowCountPage = $res->num_rows;
}

$rows = [];
while ($row = mysqli_fetch_assoc($res)) {
    $rows[] = $row;
}
?>       

<div class="content">
    <main class="table" id="customers_table">
        <section class="table__header">
            <a href="../php/add_emp_info.php" class="link-btn">New Record</a>
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
                        <th colspan="2" width='10%' style="pointer-events: none;"> Action</th>
                    </tr>
                </thead>
                <tbody>      
                <?php
                    foreach ($rows as $row) {
                        $status = $row['empStatus'];
                        if($status==0) {
                            echo "<tr style='background-color: pink'>";
                        } else {
                            echo "<tr>";
                        }
                        
                        $eid = $row['id'];
                ?>     
                        <td><a href="../update/empUpd.php?empID=<?php echo $eid; ?>"><strong><?php echo $row['name']; ?></strong></a></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['division']; ?></td>
                        <td>
                            <a href="../update/remove.php?empID=<?php echo $eid; ?>" onclick="return checkDelete()"><img src="../assets/icons/remove.png" width="32px"></a>
                        </td>   
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
           
        </section>
        <?php 
            if($rowCountPage != $rowCount) {
                echo '<div class="pagination">';
                if ($page > 1) {
                    echo '<a href="emp_List.php?page=' . ($page - 1) . '" class="next prev">Previous</a>';
                }
                
                $max_page_range = 7; // Maximum number of pages to show in pagination
                $start_page = max(1, $page - floor($max_page_range / 3));
                $end_page = min($number_of_page, $start_page + $max_page_range - 1);
                
                for($i = $start_page; $i <= $end_page; $i++) {
                    $active_class = ($i == $page) ? 'activePage' : ''; // Add active class to current page
                    echo '<a href="emp_List.php?page=' . $i . '" class="next ' . $active_class . '">' . $i . '</a>';                  
                }  
                
                if ($page < $number_of_page) {
                    echo '<a href="emp_List.php?page=' . ($page + 1) . '" class="next">Next</a>';
                    echo '<a href="emp_List.php?page=all" class="next">All</a>';
                }
                echo '</div>';

            }
        ?>
    </main>
    <script src="../js/sort.js"></script>

</div>
    
</body>
</html>