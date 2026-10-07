<?php
include '../inc/auth.php';

if(isset($_POST['update-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);

    // if(isset($_POST['action']) && $_POST['action'] == 'ComputerUpdate') {
    //     $action = mysqli_real_escape_string($db->conn,$_POST['action']);
    $input = [
        'model'        => mysqli_real_escape_string($db->conn,$_POST['model']),
        'serial'       => isset($_POST['serial']) ? mysqli_real_escape_string($db->conn,$_POST['serial']) : '',
        'supplier'     => isset($_POST['supplier']) ? mysqli_real_escape_string($db->conn,$_POST['supplier']) : '',
        'datepurchase' => isset($_POST['dateprchs']) ? mysqli_real_escape_string($db->conn,$_POST['dateprchs']) : '',
        'status'       => isset($_POST['status']) ? mysqli_real_escape_string($db->conn,$_POST['status']) : '',
        'cost'         => isset($_POST['cost']) ? mysqli_real_escape_string($db->conn, str_replace(',', '', $_POST['cost'])) : '',
        'repair-cost'  => isset($_POST['repair']) ? mysqli_real_escape_string($db->conn, str_replace(',', '', $_POST['repair'])) : '',
        'remarks'      => isset($_POST['remarks']) ? mysqli_real_escape_string($db->conn,$_POST['remarks']) : '',

        'cpu'          => isset($_POST['processor']) ? mysqli_real_escape_string($db->conn,$_POST['processor']) : '',
        'ram'          => isset($_POST['memory']) ? mysqli_real_escape_string($db->conn,$_POST['memory']) : '',
        'storage'      => isset($_POST['storage']) ? mysqli_real_escape_string($db->conn,$_POST['storage']) : '',
        'os'           => isset($_POST['os']) ? mysqli_real_escape_string($db->conn,$_POST['os']) : '',

        'dimes'        => isset($_POST['dimes']) ? mysqli_real_escape_string($db->conn,$_POST['dimes']) : '',
        'plan'         => isset($_POST['plan']) ? mysqli_real_escape_string($db->conn,$_POST['plan']) : '',
        'mobile'       => isset($_POST['mobile']) ? mysqli_real_escape_string($db->conn,$_POST['mobile']) : '',

        'datedeployed' => isset($_POST['datedeployed']) ? mysqli_real_escape_string($db->conn,$_POST['datedeployed']) : '',

        'assigned'     => isset($_POST['assigned']) ? mysqli_real_escape_string($db->conn,$_POST['assigned']) : '',
        'lastused'     => mysqli_real_escape_string($db->conn,$_POST['lastused'])
    ];
    // } 
   
    $result = $assetController->update($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.history.back();
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.history.back();
        </script>";
        die();
    }
}


if(isset($_POST['update-assetRef'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);

    $input = [
        'model'        => mysqli_real_escape_string($db->conn,$_POST['model']),
        'serial'       => isset($_POST['serial']) ? mysqli_real_escape_string($db->conn,$_POST['serial']) : '',
        'supplier'     => isset($_POST['supplier']) ? mysqli_real_escape_string($db->conn,$_POST['supplier']) : '',
        'datepurchase' => isset($_POST['dateprchs']) ? mysqli_real_escape_string($db->conn,$_POST['dateprchs']) : '',
        'status'       => isset($_POST['status']) ? mysqli_real_escape_string($db->conn,$_POST['status']) : '',
        'cost'         => isset($_POST['cost']) ? mysqli_real_escape_string($db->conn, str_replace(',', '', $_POST['cost'])) : '',
        'repair-cost'  => isset($_POST['repair']) ? mysqli_real_escape_string($db->conn, str_replace(',', '', $_POST['repair'])) : '',
        'remarks'      => isset($_POST['remarks']) ? mysqli_real_escape_string($db->conn,$_POST['remarks']) : '',

        'cpu'          => isset($_POST['processor']) ? mysqli_real_escape_string($db->conn,$_POST['processor']) : '',
        'ram'          => isset($_POST['memory']) ? mysqli_real_escape_string($db->conn,$_POST['memory']) : '',
        'storage'      => isset($_POST['storage']) ? mysqli_real_escape_string($db->conn,$_POST['storage']) : '',
        'os'           => isset($_POST['os']) ? mysqli_real_escape_string($db->conn,$_POST['os']) : '',

        'dimes'        => isset($_POST['dimes']) ? mysqli_real_escape_string($db->conn,$_POST['dimes']) : '',
        'plan'         => isset($_POST['plan']) ? mysqli_real_escape_string($db->conn,$_POST['plan']) : '',
        'mobile'       => isset($_POST['mobile']) ? mysqli_real_escape_string($db->conn,$_POST['mobile']) : '',

        'datedeployed' => isset($_POST['datedeployed']) ? mysqli_real_escape_string($db->conn,$_POST['datedeployed']) : '',

        'assigned'     => isset($_POST['assigned']) ? mysqli_real_escape_string($db->conn,$_POST['assigned']) : '',
        'lastused'     => mysqli_real_escape_string($db->conn,$_POST['lastused'])
    ];   
    $result = $assetController->updateData($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.history.back();
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.history.back();
        </script>";
        die();
    }
}

// Turnover Item
if(isset($_POST['turnover-asset'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetID']);
    $input = [
        'turnover' => mysqli_real_escape_string($db->conn,$_POST['turnover']),
        'lastused' => mysqli_real_escape_string($db->conn,$_POST['lastused']),
        'reason'   => mysqli_real_escape_string($db->conn,$_POST['reason']),
        'ref_code' => mysqli_real_escape_string($db->conn,$_POST['ref_code'])
    ];
    $result = $assetController->assetTurnover($input, $id);

    if ($result == 1) {
        echo "<script>
                alert('✅Turnover Successful');
                window.location.href='../admin/employeeLists.php';
                </script>";
    } elseif($result == 100) {
        echo "<script>
                alert('⚠️Wrong reference code');
                window.location.href='../admin/employeeLists.php';
                </script>";
    } 
}

// Update employee func
if(isset($_POST['updateEmp'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['empID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'division' => mysqli_real_escape_string($db->conn,$_POST['division']),
        'location' => mysqli_real_escape_string($db->conn,$_POST['location']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->empUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/emp_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/emp_List.php';
        </script>";
        die();
    }
}

// Update Asset item
if(isset($_POST['updateAssetItem'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['assetItemID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->assetItemUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/asset_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/asset_List.php';
        </script>";
        die();
    }
}

// Update division
if(isset($_POST['updateDivision'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['divisionID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->divisionUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/dept_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/dept_List.php';
        </script>";
        die();
    }
}

// Update location
if(isset($_POST['updateLocation'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['locationID']);
    $input = [
        'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
        'status' => mysqli_real_escape_string($db->conn,$_POST['status']),
    ];
    $result = $assetController->locationUpdate($input, $id);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/location_List.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/location_List.php';
        </script>";
        die();
    }
}

// Reference update
// if(isset($_POST['update-reference'])) {
//     $id = mysqli_real_escape_string($db->conn,$_POST['id']);

//     $accFileName = mysqli_real_escape_string($db->conn,$_POST['accountabilityFile']);
//     $trnFileName = mysqli_real_escape_string($db->conn,$_POST['turnoverFile']);

//     if (isset($_FILES['acctfile']) && $_FILES['acctfile']['error'] === UPLOAD_ERR_OK) {

//         // uploaded file details
//         $accFileTmpPath = $_FILES["acctfile"]['tmp_name'];

//         $accFileName = basename($_FILES["acctfile"]['name']);
        
//         $accFileSize = $_FILES['acctfile']['size'];
    
//         $accFileType = $_FILES['acctfile']['type'];
    
//         $accFileNameCmps = explode(".", $accFileName);
    
//         $accFileExtension = strtolower(end($accFileNameCmps));
        
//         $accUploaddir = '../files/accountability/' . $_FILES['acctfile']['name'];
    
//         // file extensions allowed
//         $allowedfileExtensions = array('pdf','docx','pptx','xlsx','jpg','png');
    
//         if (in_array($accFileExtension, $allowedfileExtensions)) {
//             if($accFileSize > 2000000) {
//                 echo "<script> alert('File too large'); window.history.back();</script>";
//                 // die();
//             } else {
//                 move_uploaded_file($accFileTmpPath, $accUploaddir);
//             }
//         } else {
//             $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);
//         }
//     }

//     if (isset($_FILES['trnfile']) && $_FILES['trnfile']['error'] === UPLOAD_ERR_OK) {

//         // uploaded file details
//         $trnFileTmpPath = $_FILES["trnfile"]['tmp_name'];

//         $trnFileName = basename($_FILES["trnfile"]['name']);
        
//         $trnFileSize = $_FILES['trnfile']['size'];
    
//         $trnFileType = $_FILES['trnfile']['type'];
    
//         $trnFileNameCmps = explode(".", $trnFileName);
    
//         $trnFileExtension = strtolower(end($trnFileNameCmps));
        
//         $trnUploaddir = '../files/turnover/' . $_FILES['trnfile']['name'];
    
//         // file extensions allowed
//         $allowedfileExtensions = array('pdf','docx','pptx','xlsx','jpg','png');
    
//         if (in_array($trnFileExtension, $allowedfileExtensions)) {
//             if($trnFileSize > 2000000) {
//                 echo "<script> alert('File too large'); window.history.back();</script>";
//                 // die();
//             } else {
//                 move_uploaded_file($trnFileTmpPath, $trnUploaddir);
//             }
//         } else {
//             $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);
//         }

//     }
    

//     $input = [
//         'name' => mysqli_real_escape_string($db->conn,$_POST['name']),
//         'acctStatus' => mysqli_real_escape_string($db->conn,$_POST['acctStatus']),
//         'acctDate' => mysqli_real_escape_string($db->conn,$_POST['acctDate']),
//         'acctFile' => mysqli_real_escape_string($db->conn,$accFileName),

//         'trnStatus' => mysqli_real_escape_string($db->conn,$_POST['trnStatus']),
//         'trnDate' => mysqli_real_escape_string($db->conn,$_POST['trnDate']),
//         'trnFile' => mysqli_real_escape_string($db->conn,$trnFileName),
//     ];

   
//     $result = $assetController->updateReference($input, $id);

//     if($result) {
//         echo "<script>
//         alert('✅Update Successful');
//         window.location.href='../admin/references.php';
//         </script>";
//         die();
//     } else {
//         echo "<script>
//         alert('⚠️Update Error');
//         window.location.href='../admin/references.php';
//         </script>";
//         die();
//     }
// }

if(isset($_POST['update-acctRef'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['id']);
    $eId = mysqli_real_escape_string($db->conn,$_POST['eId']);

    $accFileName = mysqli_real_escape_string($db->conn,$_POST['accountabilityFile']);

    if (isset($_FILES['acctfile']) && $_FILES['acctfile']['error'] === UPLOAD_ERR_OK) {

        // uploaded file details
        $accFileTmpPath = $_FILES["acctfile"]['tmp_name'];

        $accFileName = basename($_FILES["acctfile"]['name']);
        
        $accFileSize = $_FILES['acctfile']['size'];
    
        $accFileType = $_FILES['acctfile']['type'];
    
        $accFileNameCmps = explode(".", $accFileName);
    
        $accFileExtension = strtolower(end($accFileNameCmps));
        
        $accUploaddir = '../files/accountability/' . $_FILES['acctfile']['name'];
    
        // file extensions allowed
        $allowedfileExtensions = array('pdf','docx','pptx','xlsx','jpg','png');
    
        if (in_array($accFileExtension, $allowedfileExtensions)) {
            if($accFileSize > 2000000) {
                echo "<script> alert('File too large'); window.history.back();</script>";
                // die();
            } else {
                move_uploaded_file($accFileTmpPath, $accUploaddir);
            }
        } else {
            $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);
        }
    }
    $assets = $_POST['assetId'];
    if(is_array($assets)) {
        foreach($assets as $ids) {
            $assetIds[] = $ids;
       }
    } else {
        $assetIds = $assets;
    }

    $input = [
        'assetIds' => $assetIds,
        'acctStatus' => mysqli_real_escape_string($db->conn,$_POST['acctStatus']),
        'acctDate' => mysqli_real_escape_string($db->conn,$_POST['acctDate']),
        'acctFile' => mysqli_real_escape_string($db->conn,$accFileName),
    ];

    $action = mysqli_real_escape_string($db->conn,$_POST['action']);
   
    $result = $assetController->updateReference($input, $id, $eId, $action);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/reference.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/reference.php';
        </script>";
        die();
    }
}

if(isset($_POST['update-trnRef'])) {
    $id = mysqli_real_escape_string($db->conn,$_POST['id']);
    $eId = mysqli_real_escape_string($db->conn,$_POST['eId']);

    $trnFileName = mysqli_real_escape_string($db->conn,$_POST['turnoverFile']);

    if (isset($_FILES['trnfile']) && $_FILES['trnfile']['error'] === UPLOAD_ERR_OK) {

        // uploaded file details
        $trnFileTmpPath = $_FILES["trnfile"]['tmp_name'];

        $trnFileName = basename($_FILES["trnfile"]['name']);
        
        $trnFileSize = $_FILES['trnfile']['size'];
    
        $trnFileType = $_FILES['trnfile']['type'];
    
        $trnFileNameCmps = explode(".", $trnFileName);
    
        $trnFileExtension = strtolower(end($trnFileNameCmps));
        
        $trnUploaddir = '../files/turnover/' . $_FILES['trnfile']['name'];
    
        // file extensions allowed
        $allowedfileExtensions = array('pdf','docx','pptx','xlsx','jpg','png');
    
        if (in_array($trnFileExtension, $allowedfileExtensions)) {
            if($trnFileSize > 2000000) {
                echo "<script> alert('File too large'); window.history.back();</script>";
                // die();
            } else {
                move_uploaded_file($trnFileTmpPath, $trnUploaddir);
            }
        } else {
            $message = 'Upload failed as the file type is not acceptable. The allowed file types are:' . implode(',', $allowedfileExtensions);
        }

    }
    // $assetIds = is_array($_POST['assetId']) ? implode(',', $_POST['assetId']) : $_POST['assetId'];
    
    $assets = $_POST['assetId'];
    if(is_array($assets)) {
        foreach($assets as $ids) {
            $assetIds[] = $ids;
       }
    } else {
        $assetIds = $assets;
    }

    $input = [
        // 'assetId' => is_array($assetId) ? $assetId : explode(',', $assetId), // Convert to array if needed
        'assetIds' => $assetIds,
        // 'assetId' => $_POST['assetId'],
        'trnStatus' => mysqli_real_escape_string($db->conn,$_POST['trnStatus']),
        'trnDate' => mysqli_real_escape_string($db->conn,$_POST['trnDate']),
        'trnFile' => mysqli_real_escape_string($db->conn,$trnFileName),
    ];

    $action = mysqli_real_escape_string($db->conn,$_POST['action']);
    $result = $assetController->updateReference($input, $id, $eId, $action);

    if($result) {
        echo "<script>
        alert('✅Update Successful');
        window.location.href='../admin/reference.php';
        </script>";
        die();
    } else {
        echo "<script>
        alert('⚠️Update Error');
        window.location.href='../admin/reference.php';
        </script>";
        die();
    }
}
?>