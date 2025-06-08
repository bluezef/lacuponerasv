<?php
class Login {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function authenticate($username, $password) {
        $query = "SELECT * FROM administradores WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', sha1($password)); // Encriptación básica
        
        $stmt->execute();
        
        if($stmt->rowCount() == 1) {
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $username;
            return true;
        } else{    
            return false;
        }
    }

    public function recover($username) {
        $query = "SELECT * FROM administradores WHERE username = :username";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':username', $username);
        
        $stmt->execute();
        
        if($stmt->rowCount() == 1) {
            return true;
        } else{    
            return false;
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>