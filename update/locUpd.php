<?php 
include '../inc/auth.php';
include '../inc/formHead.php'; 
include '../inc/header.php'; 
?>

<div class="container">
    <div class="add-form">
        <a href="../admin/location_List.php" class="return">Back</a>

        <div class="title">Division Update</div>
        <?php
        if(isset($_GET['locID'])) {
            $locID = mysqli_real_escape_string($db->conn, $_GET['locID']);
            $asset = new assetsController;
            $result = $asset->locationEdit($locID);

            if($result) {
        ?>
            <form action="../admin/update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="locationID" value="<?=$result['id']?>">

                    <div class="input-box">
                        <span class="details">Name</span>
                        <input type="text" name="name" value="<?=$result['name']?>" required>
                    </div>
                    
                    <div class="input-box">
                        <span class="details" style="margin-bottom: 10px;">Status</span>
                        <select name="status">
                        <?php
                            $status = $result['status'];
                            if($status == 1) {
                        ?>
                            <option value="<?=$result['status']?>">Active</option>
                            <option value="0">Inactive</option>
                        <?php
                            } else { 
                        ?> 
                            <option value="<?=$result['status']?>">Inactive</option>
                            <option value="1">Active</option>
                        <?php
                            }
                        ?>
                            
                        </select>
                    </div>
                    
                </div>
                <div class="button">
                    <input type="submit" value="Update" name="updateLocation"/>
                </div>
            </form>
            <?php
                }
            }
            ?>
    </div>
</div>
</body>
</html>