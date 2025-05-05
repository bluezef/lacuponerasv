<?php
class Login {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function authenticate($username, $password) {
        $query = "SELECT * FROM clientes WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', sha1($password)); // Encriptación básica
        
        $stmt->execute();
        
        if($stmt->rowCount() == 1) {
            $_SESSION['cliente'] = true;
            $_SESSION['username'] = $username;
            return true;
            print_r("Logged in");
        } else{    
            return false;
            print_r("Error");
        }
    }

    public function recover($username){
        $query = "SELECT correo_electronico FROM clientes WHERE username = :username";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        if ($stmt->execute()) {
            return true;
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>