<?php
class Signup {
    private $conn;
    private $table = 'clientes';

    public $id;
    public $nombre_completo;
    public $apellidos;
    public $correo_electronico;
    public $fecha_de_nacimiento;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (username, password, correo_electronico, nombre_cliente, apellido_cliente, DUI, fecha_nacimiento) VALUES (:username, SHA1(:password), :correo_electronico, :nombre_cliente, :apellido_cliente, :DUI, :fecha_nacimiento)';
        
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->correo_electronico = htmlspecialchars(strip_tags($this->correo_electronico));
        $this->nombre_cliente = htmlspecialchars(strip_tags($this->nombre_cliente));
        $this->apellido_cliente = htmlspecialchars(strip_tags($this->apellido_cliente));
        $this->DUI = htmlspecialchars(strip_tags($this->DUI));        
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));


        // Enlazar parámetros
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':correo_electronico', $this->correo_electronico);
        $stmt->bindParam(':nombre_cliente', $this->nombre_cliente);
        $stmt->bindParam(':apellido_cliente', $this->apellido_cliente);
        $stmt->bindParam(':DUI', $this->DUI);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read($username) {
        $query = 'SELECT nombre_cliente, apellido_cliente, correo_electronico, DUI, fecha_nacimiento FROM ' . $this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}
?>