<?php
class Cupon {
    private $conn;
    private $table = 'ofertas';

    public $id;
    public $titulo;
    public $precio_regular;
    public $precio_oferta;
    public $fecha_inicio;
    public $fecha_fin;
    public $fecha_canje;
    public $cantidad;
    public $descripcion;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (nombre_empresa, nit_empresa, direccion, telefono, correo_electronico, username, password, aprobado) VALUES (:nombre_empresa, :nit_empresa, :direccion, :telefono, :correo_electronico, :username, SHA1(:password), 0)';
        
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->precio_regular = htmlspecialchars(strip_tags($this->precio_regular));
        $this->precio_oferta = htmlspecialchars(strip_tags($this->precio_oferta));
        $this->fecha_inicio = htmlspecialchars(strip_tags($this->fecha_inicio));
        $this->fecha_fin = htmlspecialchars(strip_tags($this->fecha_fin));
        $this->fecha_canje = htmlspecialchars(strip_tags($this->fecha_canje));        
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));     
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));


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

    public function aprobar($id,$porcentaje){
        $query = 'UPDATE ' . $this->table . ' SET aprobado = 1, porcentaje = ' . $porcentaje . ' WHERE id = '. $id;
        
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