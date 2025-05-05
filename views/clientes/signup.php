<?php
include_once '../../classes/Database.php';
include_once '../../classes/clientes/Signup.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect(); 
    $fechadenacimiento = date_create($_POST['fecha_nacimiento']);
    $hoy = date_create("now");
    if(date_diff($fechadenacimiento,$hoy)->format('%y')>=18){
        $signup = new Signup($db);
        $signup->nombre_cliente = $_POST['nombre_cliente'];
        $signup->correo_electronico = $_POST['correo_electronico'];
        $signup->apellido_cliente = $_POST['apellido_cliente'];
        $signup->DUI = $_POST['DUI'];
        $signup->correo_electronico = $_POST['correo_electronico'];
        $signup->fecha_nacimiento = $_POST['fecha_nacimiento'];
        $signup->username = $_POST['username'];
        $signup->password = $_POST['password'];
        if ($signup->create()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Hubo un problema al crear el usuario.";
        }
    }
    else{
        $error = "Debes ser mayor a 18 años para registrarte.";
    }
}
?>

<!DOCTYPE html5>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV - Registro de Clientes</title>
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center mt-5">
        <div class="mb-3">
            <h2>Registro de Clientes</h2>
        <div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="signup.php">
            <div class="mb-3">
                <label class="form-label" for="username">Usuario:</label>
                <input class="form-control" type="text" id="username" name="username" required>
            </div>  
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>  
            <div class="mb-3">
            <div class="mb-3">
                <label class="form-label" for="correo_electronico">Correo Electrónico:</label>
                <input class="form-control" type="text" id="correo_electronico" name="correo_electronico" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="ejemplo@email.com" required>
            </div>  
            <div class="mb-3">
                <label class="form-label" for="nombre_cliente">Nombres:</label>
                <input class="form-control" type="text" id="nombre_cliente" name="nombre_cliente" required>
            </div>  
            <div class="mb-3">
                <label class="form-label" for="apellido_cliente">Apellidos:</label>
                <input class="form-control" type="text" id="apellido_cliente" name="apellido_cliente" required>
            </div> 
            <div class="mb-3">
                <label class="form-label" for="DUI">DUI (sin guión):</label>
                <input class="form-control" type="text" id="DUI" name="DUI" pattern="[0-9]{9}" title="123456789" required>
            </div> 
            <div class="mb-3">
                <label class="form-label" for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div> 
            <button class="btn btn-primary" type="submit">Registrarse</button>
        </form>
        
    <div><p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p></div>
    <div><p>¿Necesitas una cuenta de empresa? <a href="../empresas/signup.php">Regístrate aquí</a></p></div>
    </div>
</div>
</body>
</html>