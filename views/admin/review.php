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

$solicitud = new Solicitud($db);
$result = $solicitud->read($_SESSION['solicitud']);


unset($_SESSION['success']);
unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $entrada = new Solicitud($db);

    if(isset($_POST['aprobar'], $_POST['porcentaje'])){
        if($entrada->aprobar($_POST['aprobar'], $_POST['porcentaje'])){
            $_SESSION['success'] = "Solicitud aprobada con éxito";
            header("Location: solicitudes.php");
        } else{
            $error = "Ocurrio un error al aprobar la solicitud";
        }
    }

    if(isset($_POST['rechazar'])){
        if($entrada->rechazar($_POST['rechazar'])){
            $_SESSION['error'] = "Solicitud rechazada con éxito";
            header("Location: solicitudes.php");
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
    <title>La Cuponera SV - Solicitudes de Registro</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LaCuponeraSV</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="registro.php">Registro de Administradores</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="solicitudes.php">Revisión de Solicitudes</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo $_SESSION['username']?>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="?logout=true">Cerrar Sesión</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
        </nav>
    </header>
    <main>
        <div class="container mt-5">
        <div class="container d-flex align-items-center justify-content-center mt-5">
            <h1>Solicitud de Registro</h1>
        </div>
        <div class="mb-3">
        <?php if ($result->rowCount() > 0){ $result = $result->fetch(PDO::FETCH_OBJ); ?>
            <h3>Número de Solicitud: <?php echo $result->id; ?></h3>
            <h3>Nombre de la Empresa: <?php echo $result->nombre_empresa; ?></h3>
            <h3>NIT de la Empresa: <?php echo $result->nit_empresa; ?></h3>
            <h3>Dirección de la Empresa: <?php echo $result->direccion; ?></h3>
            <h3>Teléfono de la Empresa: <?php echo $result->telefono; ?></h3>
            <h3>Correo Electrónico de la Empresa: <?php echo $result->correo_electronico; ?></h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label" for="porcentaje">Porcentaje de ganancia:</label>
                    <input class="form-control" type="number" step="0.5" value="15" id="porcentaje" name="porcentaje" required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success btn-sm" id="aprobar" name="aprobar" value=<?php echo $result->id; ?>>Aprobar</button>
                    <button class="btn btn-danger btn-sm" id="rechazar" name="rechazar" value=<?php echo $result->id; ?>>Rechazar</button>
                </div>
            </form>
        <?php }else{  ?>
            <h3>No se encontró una solicitud con este Número</h3>
        <?php } ?> 
        </div>
        <div class="mb-3">
            <a href="solicitudes.php"><button class="btn btn-primary">Regresar a Solicitudes de Registro</button></a>
        </div>
    </div>
    </main>
</body>
</html>
