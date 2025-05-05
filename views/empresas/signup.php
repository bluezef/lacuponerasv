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
                <label class="form-label" for="nombre_empresa">Nombre de la Empresa:</label>
                <input class="form-control" type="text" id="nombre_empresa" name="nombre_empresa" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="nit_empresa">NIT (sin guión):</label>
                <input class="form-control" type="text" id="nit_empresa" name="nit_empresa" pattern="[0-9]{14}" title="1231234561231" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="direccion">Dirección:</label>
                <input class="form-control" type="text" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="telefono">Número de Teléfono (sin guión):</label>
                <input class="form-control" type="text" id="telefono" name="telefono" pattern="[0-9]{8}" title="12345678" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="correo_electronico">Correo Electrónico:</label>
                <input class="form-control" type="text" id="correo_electronico" name="correo_electronico" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="ejemplo@email.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="username">Usuario:</label>
                <input class="form-control" type="text" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>   
            <button class="btn btn-primary" type="submit">Registrarse</button>
        </form>
        
    <div><p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p></div>
    <div><p>¿Eres un usuario natural y no una empresa? <a href="../clientes/signup.php">Regístrate aquí</a></p></div>
    </div>
</div>
</body>
</html>