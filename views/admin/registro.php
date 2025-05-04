<?php
include_once '../../classes/Database.php';
include_once '../../classes/admin/Signup.php';



if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect(); 
    $signup = new Signup($db);
    $signup->username = $_SESSION['username'];
    $signup->password = $_SESSION['password'];

    if ($signup->create()) {
        header("Location: menu.php");
        exit();
    } else {
        $error = "Hubo un problema al crear la entrada.";
    }
}
?>

<!DOCTYPE html5>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV - Registro de Empresas</title>
    <link rel="icon" type="image/x-icon" href="assets/cuponera.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center mt-5">
        <div class="mb-3">
            <h2>Registro de Administradores</h2>
        <div>
        <form method="POST" action="signup.php">
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
        </div>
</div>
</body>
</html>