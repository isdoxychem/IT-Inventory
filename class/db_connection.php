<?php
session_start();

// include 'functions.php';
// include 'assetsController.php';
// NOTE: don't include files that instantiate or depend on classes
// before those classes are declared. We'll include them after
// the classes are defined and after creating the connection
// instances to avoid fatal errors during include-time.

class Connection {
    public $db_host = "localhost";
    public $db_user = "root";
    public $db_pass = "";
    public $db_name = "db_oxyche";
    public $conn;

    public function __construct() {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        // $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if(mysqli_connect_error()) {
            die ("Connection Failed: ".mysqli_error($this->conn));
        }
    }
}

class AddItems extends Connection {
    public function addEmployee($name, $division, $location) { 
        $duplicate = mysqli_query($this->conn, "SELECT * FROM employee_tbl WHERE name LIKE '%$name' AND name LIKE '$name%' AND name LIKE '%$name%'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO employee_tbl (id, name, division, location, empStatus)
                                VALUES ('','$name', '$division', '$location', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }

    // Add Asset Item
    public function addAssetItem($name) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM category_tbl WHERE assetType LIKE '%$name%'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO category_tbl (id, assetType, status)
                                VALUES ('','$name', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }

    // Add Division
    public function addDivision($name) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM dept_tbl WHERE name LIKE '$name'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO dept_tbl (id, name, status)
                                VALUES ('','$name', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }

    // Add Location
    public function addLocation($name) {
        $duplicate = mysqli_query($this->conn, "SELECT * FROM loc_tbl WHERE name LIKE '$name'");
        
        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            $query = "INSERT INTO loc_tbl (id, name, status)
                                VALUES ('','$name', 1)";

            $result = mysqli_query($this->conn, $query);
            if($result) { 
                return 1; //Success
            } else {
                return 100; //Store Failed
            }
        }
    }
}
class Register extends Connection {
    public function register($role, $user, $email, $pass, $conf_pass) {

        $duplicate = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE username='$user' OR email='$email' ");

        if (mysqli_num_rows($duplicate) > 0) {
            return 10; // Duplicate Record
        } else {
            if($pass == $conf_pass) {
                $sql = "INSERT INTO users_tbl VALUES('', '$user', '$email', '$pass', '$role', 1)";
                mysqli_query($this->conn, $sql);
                return 1; // Registration Successs
            } 
            else {
                return 100; // passwords doesn't match
            }
        }

    }

}

class Login extends Connection {
    public $id;
    
    public function login($usernameemail, $password) {
        $result = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE username = '$usernameemail' OR email = '$usernameemail'");
        $row = mysqli_fetch_assoc($result);

        if(mysqli_num_rows($result) > 0) {
            if($password == $row["password"]) {
                $this->id = $row["id"];
                $role = $row["role"];
                
                if($role == 'admin') {
                    return 1; // Login as admin
                } elseif ($role == 'utilities') {
                    return 2; // Login as utilities
                } else {
                    return 3;
                }
            } else {
                return 10; // Wrong password
            }
        } else {
            return 100; // User not registered
        }
    }
    
    public function idUser() {
        return $this->id;
    }
}
  
class Select extends Connection {
    public function selectUserById($id) {
        $result = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }

    public function getAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status!='Sold' AND status!='Missing' AND status!='Sell' AND status!='Archive' AND status!='Defective' AND status!='For repair'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getDeployedAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status = 'Deployed'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getAvailableAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status = 'To be deploy'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getDefectAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status = 'Defective'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getRepairAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status = 'For repair'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getForSellAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status = 'Sell'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getUserNoAccountability() {
        // $result = mysqli_query($this->conn, "SELECT COUNT(DISTINCT name) AS count 
        //                                     FROM reference_tbl 
        //                                     WHERE name != '' 
        //                                     AND accountabilityStatus = '0' 
        //                                     AND referenceStatus = '1'");
        $result = mysqli_query($this->conn, "SELECT COUNT(DISTINCT e.id) AS count
                                            FROM employee_tbl AS e
                                            WHERE e.empStatus = 1 
                                            AND e.id NOT IN (SELECT empId FROM assets_tbl WHERE empId != 0)");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
    public function getForMissingAssetCount() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) AS count FROM assets_tbl WHERE status = 'Missing'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        return $count;
    }
}

// Select All***
class get_All_User extends Connection {
    public function selectAllUser() {
        $sql = mysqli_query($this->conn, "SELECT * FROM users_tbl WHERE status=1");
        while($res = mysqli_fetch_assoc($sql)) {
            $users[] = $res;
        }
        return $users;
    }
    public function selectAllEmp() {
        $sql = mysqli_query($this->conn, "SELECT * FROM employee_tbl WHERE empStatus=1 ORDER BY name ASC");
        while($res = mysqli_fetch_assoc($sql)) {
            $users[] = $res;
        }
        return $users;
    }
    public function selectAllLoc() {
        $sql = mysqli_query($this->conn, "SELECT * FROM loc_tbl WHERE status=1 ORDER BY name ASC");
        while($res = mysqli_fetch_assoc($sql)) {
            $location[] = $res;
        }
        return $location;
    }
}

// Instantiate core objects so code that relies on them can use globals
$db = new Connection();

// Optionally create helper objects for convenience (not required everywhere)
$addItems = new AddItems();
$register = new Register();
$login = new Login();
$select = new Select();
$get_all_user = new get_All_User();

// Now include helper files that may use the classes/instances above.
// Including them earlier caused class-not-found / fatal errors (HTTP 500).
include 'functions.php';
include 'assetsController.php';
// include 'fetch_data.php';

?>