<?php
include_once '../../classes/Database.php';
include_once '../../classes/Solicitudes.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();

    $signup = new Solicitud($db);
    $signup->nombre_empresa = $_POST['nombre_empresa'];
    $signup->nit_empresa = $_POST['nit_empresa'];
    $signup->direccion = $_POST['direccion'];
    $signup->telefono = $_POST['telefono'];
    $signup->correo_electronico = $_POST['correo_electronico'];
    $signup->username = $_POST['username'];
    $signup->password = $_POST['password'];

    if ($signup->create()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Hubo un problema al crear la solicitud.";
    }
}
?>

<!DOCTYPE html5>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV - Registro de Empresas</title>
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center mt-5">
        <div class="mb-3">
            <h2>Formulario de Registro para Empresas</h2>
        <div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="signup.php">
            <div class="mb-3">
                <label class="form-label" for="titulo">Título del Cupón:</label>
                <input class="form-control" type="text" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="regular">Precio Regular:</label>
                <input class="form-control" type="number" id="regular" name="regular" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="oferta">Precio Oferta:</label>
                <input class="form-control" type="number" id="oferta" name="oferta" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="inicio">Fecha de Inicio:</label>
                <input class="form-control" type="date" id="inicio" name="inicio" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="fin">Fecha de Fin:</label>
                <input class="form-control" type="date" id="fin" name="fin" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="canje">Fecha de Canje:</label>
                <input class="form-control" type="date" id="canje" name="canje" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="cantidad">Cantidad:</label>
                <input class="form-control" type="number" id="cantidad" name="cantidad" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="descripcion">Descripcion:</label>
                <input class="form-control" type="textbox" id="descripcion" name="descripcion" required>
            </div>
            <button class="btn btn-primary" type="submit">Registrar Oferta</button>
        </form>
    </div>
</div>
</body>
</html>