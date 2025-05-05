<?php
require_once '../../classes/Database.php';
include_once '../../classes/Solicitudes.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->connect();

$entrada = new Solicitud($db);
$result = $entrada->read();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $entrada = new Solicitud($db);

    if(isset($_POST['aprobar'])){
        if($entrada->aprobar($_POST['aprobar'])){
            $success = "Solicitud aprobada con éxito";
        } else{
            $error = "Ocurrio un error al aprobar la solicitud";
        }
    }

    if(isset($_POST['rechazar'])){
        if($entrada->rechazar($_POST['rechazar'])){
            $success = "Solicitud rechazada con éxito";
        } else{
            $error = "Ocurrio un error al rechazar la solicitud";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV - Solicitudes de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h1>Solicitudes Registradas</h1>
        </div>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Empresa</th>
                    <th>NIT</th>
                    <th>Direccion</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Aprobar/Rechazar Solicitud</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->rowCount() > 0){ ?>
                    <?php while ($row = $result->fetch(PDO::FETCH_OBJ)): ?>
                        <tr>
                            <td><?php echo $row->id; ?></td>
                            <td><?php echo $row->nombre_empresa; ?></td>
                            <td><?php echo $row->nit_empresa; ?></td>
                            <td><?php echo $row->direccion; ?></td>
                            <td><?php echo $row->telefono; ?></td>
                            <td><?php echo $row->correo_electronico; ?></td>
                            <td class="text-center"><form method="POST"><button class="btn btn-success btn-sm" id="aprobar" name="aprobar" value=<?php echo $row->id; ?>>Aprobar</button><button class="btn btn-danger btn-sm" id="rechazar" name="rechazar" value=<?php echo $row->id; ?>>Rechazar</button></form></td>
                        </tr>
                    <?php endwhile; ?>
                <?php }else{  ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay entradas registradas</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
