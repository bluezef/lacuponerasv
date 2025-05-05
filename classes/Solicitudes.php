<?php
class Solicitud {
    private $conn;
    private $table = 'empresas';

    public $id;
    public $nombre_empresa;
    public $nit_empresa;
    public $direccion;
    public $telefono;
    public $correo_electronico;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (nombre_empresa, nit_empresa, direccion, telefono, correo_electronico, username, password, aprobado) VALUES (:nombre_empresa, :nit_empresa, :direccion, :telefono, :correo_electronico, :username, SHA1(:password), 0)';
        
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->nombre_empresa = htmlspecialchars(strip_tags($this->nombre_empresa));
        $this->nit_empresa = htmlspecialchars(strip_tags($this->nit_empresa));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->correo_electronico = htmlspecialchars(strip_tags($this->correo_electronico));
        $this->username = htmlspecialchars(strip_tags($this->username));        
        $this->password = htmlspecialchars(strip_tags($this->password));


        // Enlazar parámetros
        $stmt->bindParam(':nombre_empresa', $this->nombre_empresa);
        $stmt->bindParam(':nit_empresa', $this->nit_empresa);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':correo_electronico', $this->correo_electronico);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function aprobar($id){
        $query = 'UPDATE ' . $this->table . ' SET aprobado = 1 WHERE id = '. $id;
        
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function rechazar($id){
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = '. $id;
        
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read() {
        $query = 'SELECT id, nombre_empresa, nit_empresa, direccion, telefono, correo_electronico FROM ' . $this->table . ' WHERE aprobado = 0';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}
?>