<?php include '../inc/auth.php';  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Update</title>
</head>
<style>
.return {
    transition: all .3s;
    border: 1px solid white;
    padding: 5px 20px;
    border-radius: 15px;
    background-color: var(--sec-color);
    font-weight: 700;
}
.return:hover {
    background-color: white;
    border: 1px solid black;
    color: var(--main-color);
    transition: all .3s;
}

</style>
<body>
<?php include '../inc/header.php'; ?>

<div class="container">
    <div class="add-form">
        <a href="../admin/asset_List.php" class="return">Back</a>

        <div class="title">Asset Update</div>
        <?php
        if(isset($_GET['assetItemID'])) {
            $assetItemID = mysqli_real_escape_string($db->conn, $_GET['assetItemID']);
            $asset = new assetsController;
            $result = $asset->assetItemEdit($assetItemID);

            if($result) {
        ?>
            <form action="../admin/update-selected.php" method="POST">
                <div class="asset-details">
                    <input type="hidden" name="assetItemID" value="<?=$result['id']?>">

                    <div class="input-box">
                        <span class="details">Name</span>
                        <input type="text" name="name" value="<?=$result['assetType']?>" required>
                    </div>
                    
                    <div class="input-box">
                        <span class="details" >Status</span>
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
                    <input type="submit" value="Update" name="updateAssetItem"/>
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