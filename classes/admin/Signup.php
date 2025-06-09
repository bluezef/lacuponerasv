<?php
class Signup {
    private $conn;
    private $table = 'administradores';

    public $id;
    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (username, password) VALUES (:username, SHA1(:password))';
        
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));


        // Enlazar parámetros
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
?>