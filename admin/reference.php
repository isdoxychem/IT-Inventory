<<<<<<< HEAD
<?php 
include '../inc/auth.php'; 
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

    $accReferenceTbl = $operation->getAccReferenceTable();
    $trnReferenceTbl = $operation->getTrnReferenceTable();

    $sql = "SELECT a.id AS aId, a.empId, a.status AS status, a.assettype, a.assettag AS tag, a.model, a.remarks, 
            e.id, e.name AS ename, e.division, e.location, 
            r.id AS rid, r.assetId AS assetId, r.name AS rname, GROUP_CONCAT(DISTINCT r.accountabilityRef ORDER BY r.accountabilityRef) AS accountabilityRef, 
            r.accountabilityStatus AS accountabilityStatus, r.accountabilityDate AS accountabilityDate, r.accountabilityFile AS accountabilityFile, r.referenceStatus 
            FROM assets_tbl AS a 
            LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
            LEFT JOIN employee_tbl AS e ON a.empId = e.id 
            WHERE (referenceStatus='1' OR referenceStatus='2') AND accountabilityRef!='' 
            GROUP BY rname, accountabilityRef 
            ORDER BY accountabilityStatus, ename ASC";
            // LIMIT $page_first_result, $results_per_page";

    $res = mysqli_query($db->conn, $sql);
    $accCountPage = $res->num_rows;
?>
<main class="table">

    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'Accountability')">Accountability</button>
        <button class="tablinks" onclick="openCity(event, 'Turnover')">Turnover</button>
    </div>
    
    <div id="Accountability" class="tabcontent">
        <section class="ref__table__header">
            <div class="input-group">
                <input type="searchAcc" id="searchAccInput" placeholder="Search Data..." oninput="searchAccTable()">
                <img src="../assets/icons/search.png" alt="">
            </div>

            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;" class="acc-result-count"><?php echo $accCountPage; ?></b> result/s.</p>

        </section>
        <section class="ref__table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Accountability Ref #</th>
                        <th width="15%">File</th>
                        <th width="8%">Status</th>
                        <th width="10%">Date</th>
                        <th colspan='2' width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevAccRef = '';

                    while ($row = mysqli_fetch_assoc($accReferenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $acctRef = $row['accountabilityRef'];
                        $acctStatus = $row['accountabilityStatus'];
                        $acctDate = $row['accountabilityDate'];
                        $acctFile = $row['accountabilityFile'];

                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname'];

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }

                        if ($acctRef != '') {
                            echo "<tr class='acc'>";

                            $operation->ifEmptyAccReference($acctRef, $acctFile);

                            if ($acctRef != $prevAccRef) {
                               
                                echo "<td>$empName</td>";
                                echo "<td><a class='link' href='accountability.php?id=$acctRef'>$acctRef</a></td>";
                                echo "<td width='10%'><a class='link' href='../files/download.php?acctRef_id=$rid' target='_blank'>$acctFile</td>";
                                echo "<td><span class='documentStatus'>$acctStatus</span></td>";
                                echo "<td>$acctDate</td>";
                                echo "<td>";

                                if ($acctStatus == 'Signed') {
                                    echo "<span class='disable-btn'><a href='../update/referenceUpd.php?id=$rid'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Acct_id=$rid' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a></span>";
                                } else {
                                    echo "<a href='../update/referenceUpd.php?acctRef=$acctRef&name=$empName'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?acctRef=$acctRef&name=$empId' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a>";
                                }
                                echo "</td>";
                                echo "</tr>";

                            } 
                            $prevAccRef = $acctRef;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>


    <?php
        $sql1 = "SELECT a.id AS aId, a.empId, a.status AS status, a.assettype, a.assettag AS tag, a.model, a.remarks, 
                e.id, e.name AS ename, e.division, e.location, 
                r.id AS rid, r.assetId AS assetId, r.name AS rname, GROUP_CONCAT(DISTINCT r.turnoverRef ORDER BY r.turnoverRef) AS turnoverRef, 
                r.turnoverStatus AS turnoverStatus, r.turnoverDate AS turnoverDate, r.turnoverFile AS turnoverFile, r.referenceStatus 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE (referenceStatus='1' OR referenceStatus='2') AND turnoverRef!='' 
                GROUP BY rname, turnoverRef 
                ORDER BY turnoverStatus, ename ASC";

        $res1 = mysqli_query($db->conn, $sql1);
        $trnCountPage = $res1->num_rows;
    ?>

    <div id="Turnover" class="tabcontent hidden">
        <section class="ref__table__header">
            <div class="input-group">
                <input type="search" id="searchTrnInput" placeholder="Search Data..." oninput="searchTrnTable()">
                <img src="../assets/icons/search.png" alt="">
            </div>

            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;" class="trn-result-count"><?php echo $trnCountPage; ?></b> result/s.</p>

        </section>
        <section class="ref__table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Turnover Ref #</th>
                        <th width="15%">File</th>
                        <th width="8%">Status</th>
                        <th width="10%">Date</th>
                        <th width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevTrnRef = '';
                    while ($row = mysqli_fetch_assoc($trnReferenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $turnoverRef = $row['turnoverRef'];
                        $turnoverStatus = $row['turnoverStatus'];
                        $turnoverDate = $row['turnoverDate'];
                        $turnoverFile = $row['turnoverFile'];
                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname'];

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }

                        if ($turnoverRef != '') {
                            echo "<tr class='trn'>";
                            
                            $operation->ifEmptyTrnReference($turnoverRef, $turnoverFile);                            

                            if ($turnoverRef != $prevTrnRef) {
                                // if ($prevTrnRef != '') {
                                //     echo "</tr>";
                                // }
                                echo "<td>$empName</td>";
                                echo "<td><a class='link' href='turnover.php?id=$turnoverRef'>$turnoverRef</a></td>";
                                echo "<td width='10%;'><a class='link' href='../files/download.php?trnRef_id=$rid' target='_blank'>$turnoverFile</td>";
                                echo "<td><span class='documentStatus'>$turnoverStatus</span></td>";
                                echo "<td>$turnoverDate</td>";
                                echo "<td>";
                                if ($turnoverStatus == 'Signed') {
                                    echo "<span class='disable-btn'><a href='../update/referenceUpd.php?Turnover_id=$rid'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Turnover_id=$rid;' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a></span>";
                                    
                                } else {
                                    echo "<a href='../update/referenceUpd.php?turnoverRef=$turnoverRef&name=$empName'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?turnoverRef=$turnoverRef&name=$empId' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            } 
                            $prevTrnRef = $turnoverRef;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</main>
<script src="../js/sort.js"></script>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

</body>
</html> 
=======
<?php 
include '../inc/auth.php'; 
include '../inc/listsHead.php'; 
include '../inc/header.php'; 

    $accReferenceTbl = $operation->getAccReferenceTable();
    $trnReferenceTbl = $operation->getTrnReferenceTable();

    $sql = "SELECT a.id AS aId, a.empId, a.status AS status, a.assettype, a.assettag AS tag, a.model, a.remarks, 
            e.id, e.name AS ename, e.division, e.location, 
            r.id AS rid, r.assetId AS assetId, r.name AS rname, GROUP_CONCAT(DISTINCT r.accountabilityRef ORDER BY r.accountabilityRef) AS accountabilityRef, 
            r.accountabilityStatus AS accountabilityStatus, r.accountabilityDate AS accountabilityDate, r.accountabilityFile AS accountabilityFile, r.referenceStatus 
            FROM assets_tbl AS a 
            LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
            LEFT JOIN employee_tbl AS e ON a.empId = e.id 
            WHERE (referenceStatus='1' OR referenceStatus='2') AND accountabilityRef!='' 
            GROUP BY rname, accountabilityRef 
            ORDER BY accountabilityStatus, ename ASC";
            // LIMIT $page_first_result, $results_per_page";

    $res = mysqli_query($db->conn, $sql);
    $accCountPage = $res->num_rows;
?>
<main class="table">

    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'Accountability')">Accountability</button>
        <button class="tablinks" onclick="openCity(event, 'Turnover')">Turnover</button>
    </div>
    
    <div id="Accountability" class="tabcontent">
        <section class="ref__table__header">
            <div class="input-group">
                <input type="searchAcc" id="searchAccInput" placeholder="Search Data..." oninput="searchAccTable()">
                <img src="../assets/icons/search.png" alt="">
            </div>

            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;" class="acc-result-count"><?php echo $accCountPage; ?></b> result/s.</p>

        </section>
        <section class="ref__table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Accountability Ref #</th>
                        <th width="15%">File</th>
                        <th width="8%">Status</th>
                        <th width="10%">Date</th>
                        <th colspan='2' width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevAccRef = '';

                    while ($row = mysqli_fetch_assoc($accReferenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $acctRef = $row['accountabilityRef'];
                        $acctStatus = $row['accountabilityStatus'];
                        $acctDate = $row['accountabilityDate'];
                        $acctFile = $row['accountabilityFile'];

                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname'];

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }

                        if ($acctRef != '') {
                            echo "<tr class='acc'>";

                            $operation->ifEmptyAccReference($acctRef, $acctFile);

                            if ($acctRef != $prevAccRef) {
                               
                                echo "<td>$empName</td>";
                                echo "<td><a class='link' href='accountability.php?id=$acctRef'>$acctRef</a></td>";
                                echo "<td width='10%'><a class='link' href='../files/download.php?acctRef_id=$rid' target='_blank'>$acctFile</td>";
                                echo "<td><span class='documentStatus'>$acctStatus</span></td>";
                                echo "<td>$acctDate</td>";
                                echo "<td>";

                                if ($acctStatus == 'Signed') {
                                    echo "<span class='disable-btn'><a href='../update/referenceUpd.php?id=$rid'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Acct_id=$rid' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a></span>";
                                } else {
                                    echo "<a href='../update/referenceUpd.php?acctRef=$acctRef&name=$empName'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?acctRef=$acctRef&name=$empId' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a>";
                                }
                                echo "</td>";
                                echo "</tr>";

                            } 
                            $prevAccRef = $acctRef;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>


    <?php
        $sql1 = "SELECT a.id AS aId, a.empId, a.status AS status, a.assettype, a.assettag AS tag, a.model, a.remarks, 
                e.id, e.name AS ename, e.division, e.location, 
                r.id AS rid, r.assetId AS assetId, r.name AS rname, GROUP_CONCAT(DISTINCT r.turnoverRef ORDER BY r.turnoverRef) AS turnoverRef, 
                r.turnoverStatus AS turnoverStatus, r.turnoverDate AS turnoverDate, r.turnoverFile AS turnoverFile, r.referenceStatus 
                FROM assets_tbl AS a 
                LEFT JOIN reference_tbl AS r ON r.assetId = a.id 
                LEFT JOIN employee_tbl AS e ON a.empId = e.id 
                WHERE (referenceStatus='1' OR referenceStatus='2') AND turnoverRef!='' 
                GROUP BY rname, turnoverRef 
                ORDER BY turnoverStatus, ename ASC";

        $res1 = mysqli_query($db->conn, $sql1);
        $trnCountPage = $res1->num_rows;
    ?>

    <div id="Turnover" class="tabcontent hidden">
        <section class="ref__table__header">
            <div class="input-group">
                <input type="search" id="searchTrnInput" placeholder="Search Data..." oninput="searchTrnTable()">
                <img src="../assets/icons/search.png" alt="">
            </div>

            <p> <b style="color: yellow; font-size: 20px; margin-top: 10px;" class="trn-result-count"><?php echo $trnCountPage; ?></b> result/s.</p>

        </section>
        <section class="ref__table__body">
            <table>
                <thead>
                    <tr>
                        <th width="15%">User</th>
                        <th>Turnover Ref #</th>
                        <th width="15%">File</th>
                        <th width="8%">Status</th>
                        <th width="10%">Date</th>
                        <th width="8%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $prevTrnRef = '';
                    while ($row = mysqli_fetch_assoc($trnReferenceTbl)) {
                        $rid = $row['rid'];
                        $assetId = $row['assetId'];
                        $assettag = $row['tag'];
                        $turnoverRef = $row['turnoverRef'];
                        $turnoverStatus = $row['turnoverStatus'];
                        $turnoverDate = $row['turnoverDate'];
                        $turnoverFile = $row['turnoverFile'];
                        $referenceStatus = $row['referenceStatus'];
                        $empId = $row['rname'];

                        $qrySelect = "SELECT * FROM employee_tbl WHERE id='$empId'";
                        $result = mysqli_query($db->conn, $qrySelect);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $empName = $row['name'];
                        }

                        if ($turnoverRef != '') {
                            echo "<tr class='trn'>";
                            
                            $operation->ifEmptyTrnReference($turnoverRef, $turnoverFile);                            

                            if ($turnoverRef != $prevTrnRef) {
                                // if ($prevTrnRef != '') {
                                //     echo "</tr>";
                                // }
                                echo "<td>$empName</td>";
                                echo "<td><a class='link' href='turnover.php?id=$turnoverRef'>$turnoverRef</a></td>";
                                echo "<td width='10%;'><a class='link' href='../files/download.php?trnRef_id=$rid' target='_blank'>$turnoverFile</td>";
                                echo "<td><span class='documentStatus'>$turnoverStatus</span></td>";
                                echo "<td>$turnoverDate</td>";
                                echo "<td>";
                                if ($turnoverStatus == 'Signed') {
                                    echo "<span class='disable-btn'><a href='../update/referenceUpd.php?Turnover_id=$rid'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?Turnover_id=$rid;' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a></span>";
                                    
                                } else {
                                    echo "<a href='../update/referenceUpd.php?turnoverRef=$turnoverRef&name=$empName'><img src='../assets/icons/update.png' width='24px'></a>&nbsp;
                                        <a href='../update/remove.php?turnoverRef=$turnoverRef&name=$empId' onclick='return checkDelete()'><img src='../assets/icons/remove.png' width='24px'></a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            } 
                            $prevTrnRef = $turnoverRef;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</main>
<script src="../js/sort.js"></script>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

</body>
</html> 
>>>>>>> a955ca4 ([ADD] Lacking Files)
