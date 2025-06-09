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
    public $usuario;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (titulo, precio_regular, precio_oferta, fecha_inicio, fecha_fin, fecha_canje, cantidad, descripcion, estado, usuario) VALUES (:titulo, :precio_regular, :precio_oferta, :fecha_inicio, :fecha_fin, :fecha_canje, :cantidad, :descripcion, 1, :usuario)';
        
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
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));


        // Enlazar parámetros
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':precio_regular', $this->precio_regular);
        $stmt->bindParam(':precio_oferta', $this->precio_oferta);
        $stmt->bindParam(':fecha_inicio', $this->fecha_inicio);
        $stmt->bindParam(':fecha_fin', $this->fecha_fin);
        $stmt->bindParam(':fecha_canje', $this->fecha_canje);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':usuario', $this->usuario);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function desactivar($id){
        $query = 'UPDATE ' . $this->table . ' SET estado = 0 WHERE id = '. $id;
        
        $stmt = $this->conn->prepare($query);        

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function compra($id, $cantidad){
        $query = 'UPDATE ' . $this->table . ' SET cantidad = (cantidad - ' . $cantidad . ') WHERE id = '. $id;
        
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function readall() {
        $query = 'SELECT id, titulo, precio_regular, precio_oferta, fecha_inicio, fecha_fin, fecha_canje, cantidad, descripcion FROM ' . $this->table . ' WHERE estado = 1 AND CURRENT_DATE() BETWEEN fecha_inicio AND fecha_fin AND cantidad>0' ;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read($id) {
        $query = 'SELECT titulo, precio_regular, precio_oferta, fecha_inicio, fecha_fin, fecha_canje, cantidad, descripcion, nombre_empresa, usuario FROM ' . $this->table . ' JOIN empresas ON ofertas.usuario=empresas.username WHERE estado = 1 AND CURRENT_DATE() BETWEEN fecha_inicio AND fecha_fin AND ofertas.id = ' . $id;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function readallfromuser($usuario) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE usuario = :usuario';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':usuario', $usuario);

        $stmt->execute();

        return $stmt;
    }
}
?>