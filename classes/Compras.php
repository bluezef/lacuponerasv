<?php
class Compra {
    private $conn;
    private $table = 'compras';

    public $id;
    public $id_oferta;
    public $monto;
    public $fecha;
    public $factura_path;
    public $usuario;
    public $empresa;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (id_oferta, monto, fecha, factura_path, usuario, empresa) VALUES (:id_oferta, :monto, CURRENT_DATE(), :factura_path, :usuario, :empresa)';
        
        $stmt = $this->conn->prepare($query);

        // Limpiar los datos
        $this->id_oferta = htmlspecialchars(strip_tags($this->id_oferta));
        $this->monto = htmlspecialchars(strip_tags($this->monto));
        $this->factura_path = htmlspecialchars(strip_tags($this->factura_path));
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $this->empresa = htmlspecialchars(strip_tags($this->empresa));


        // Enlazar parámetros
        $stmt->bindParam(':id_oferta', $this->id_oferta);
        $stmt->bindParam(':monto', $this->monto);
        $stmt->bindParam(':factura_path', $this->factura_path);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':empresa', $this->empresa);

        if ($stmt->execute()) {
            return true;
        }

        // Si algo sale mal, imprimir error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function readall() {
        $query = 'SELECT * FROM ' . $this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function readallfromcliente($usuario) {
        $query = 'SELECT compras.id AS id, ofertas.titulo AS titulo, compras.monto AS monto, compras.fecha AS fecha, compras.factura_path AS factura_path  FROM ' . $this->table . ' LEFT JOIN ofertas ON compras.id_oferta=ofertas.id WHERE compras.usuario = :usuario';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':usuario', $usuario);

        $stmt->execute();

        return $stmt;
    }

    public function porempresa() {
        $query = 'SELECT nombre_empresa, empresas.porcentaje AS porcentaje, COUNT(compras.id) AS ventas, SUM(monto) AS montoventas FROM ' . $this->table . ' JOIN empresas ON compras.empresa=empresas.username GROUP BY nombre_empresa, porcentaje';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

}
?>