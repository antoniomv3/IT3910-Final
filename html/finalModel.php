<?php
class finalModel {
    public function __construct(){
    //On construction, the model will start the session and if logStatus is not set, meaning the browser is new to this page or the previous session expired, it will set it to false, meaning the user is not logged in. It will also check if there is a log error, if so it will print an error message when it reloads the login screen.
        session_start();
        if(!isset($_SESSION['logStatus'])) $_SESSION['logStatus'] = 'false';
    }
    public function __destruct(){
    }
    
    public function preparePageContent($nav) {
        switch($nav) {
            case "logout":
                $_SESSION['logStatus'] = 'false';
                header('Location: http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=login');
                break;
            case "home":
                $tableData = $this->prepareHomeTable();
                return $tableData;
                break;
            case "newList":
                $giftData = $this->prepareGiftData();
                return $giftData;
                break;
            case "search":
                $searchData = $this->prepareSearchData();
                return $searchData;
                break;
            default:
                break;
        }
    }
    
    public function submitList() {
        $mysqli = $this->initDatabaseConnection();
        
        $name = $mysqli->real_escape_string($_POST['Name']);
        $relation = $mysqli->real_escape_string($_POST['Relation']);
        $address = $mysqli->real_escape_string($_POST['Address']);
        $choice1 = $mysqli->real_escape_string($_POST['Choice1']);
        $choice2 = $mysqli->real_escape_string($_POST['Choice2']);
        $choice3 = $mysqli->real_escape_string($_POST['Choice3']);
    
        $query = $mysqli->prepare("INSERT INTO Recipients VALUES (?, ?, ?)");
        $query->bind_param("sss", $name, $address, $relation);
        $query->execute();
        
        $query = $mysqli->prepare("INSERT INTO Wishlist VALUES (?, ?)");
        if($choice1 != "NA") {
            $query->bind_param("ss", $name, $choice1);
            $query->execute();
        }
        if($choice2 != "NA") {
            $query->bind_param("ss", $name, $choice2);
            $query->execute();
        }
        if($choice3 != "NA") {
            $query->bind_param("ss", $name, $choice3);
            $query->execute();
        }
        $query->close();
        $mysqli->close();
    }
    
    private function prepareSearchData() {
        $mysqli = $this->initDatabaseConnection();
        $search = $mysqli->real_escape_string($_POST['Search']);
        
        $query = $mysqli->prepare("SELECT * FROM Wishlist WHERE Name = ?");
        $query->bind_param("s", $search);
        $query->execute();
        
        $result = $query->get_result();
        
        $tableData = '';
        if(mysqli_num_rows($result) === 0) {
            $tableData .= '<tr><td>No Results Found for '.$_POST['Search'].'</td><td></td></tr>';
        } else {
            while($row = $result->fetch_assoc()) {
                $tableData .= '<tr><td>'.$row["Name"].'</td><td>'.$row["Item"].'</td></tr>';
            }  
        }
        $result->free();
        $query->close();
        $mysqli->close();
        
        return $tableData;
    }
    
    private function prepareGiftData() {
        $mysqli = $this->initDatabaseConnection();
        $giftData = '';
        
        $query = "SELECT Item FROM Gifts";
        $result = $mysqli->query($query);
        while($row = $result->fetch_assoc()) {
                $giftData .= '<option value='.$row['Item'].'>'.$row['Item'].'</option>"';
        }
        $mysqli->close();
        return $giftData;
    }
    
    private function prepareHomeTable() {
        $mysqli = $this->initDatabaseConnection();
        $query = "SELECT * FROM Wishlist";
        $result = $mysqli->query($query);
        
        $tableData = '';
        if(mysqli_num_rows($result) === 0) {
            $tableData .= '<tr><td>Table is currently empty!</td><td></td></tr>';
        } else {
            while($row = $result->fetch_assoc()) {
                $tableData .= '<tr><td>'.$row["Name"].'</td><td>'.$row["Item"].'</td></tr>';
            }
        }
        $mysqli->close();
        return $tableData;
    }
    
    public function processLogin() {
        $mysqli = $this->initDatabaseConnection();
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);
        
        $query = "SELECT * FROM Users WHERE email = ?";
        $query->bind_param("s", $email);
        $query->execute();
        
        $result = $query->get_result();
        
        //$password = password_hash('password', PASSWORD_DEFAULT);
        
        if($result->num_rows === 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            if(password_verify($password, $row['password'])) {
                $_SESSION['logStatus'] = 'true';
                $_SESSION['logError'] = 'No';
                $_SESSION['email'] = $email;
            } else {
                $_SESSION['logStatus'] = 'false';
                $_SESSION['logError'] = 'Yes';
            }
        } else {
            $_SESSION['logStatus'] = 'false';
            $_SESSION['logError'] = 'Yes';
        }
        
        $result->free();
        $query->close();
        $mysqli->close();
    }
    
    private function initDatabaseConnection() {
        $DBServer = 'localhost';
        $DBUser = 'amv7vc';
        $DBPassword = 'password';
        $Database = 'MyDatabase';
        
        $mysqli = new mysqli($DBServer, $DBUser, $DBPassword, $Database);
            
        if ($mysqli->connect_errno){
            echo $mysqli->connect_errno;
            exit;
        } 
        return $mysqli;
    }
}
?>
