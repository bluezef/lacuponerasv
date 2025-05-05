<?php
    require_once '../../classes/Database.php';
    require_once '../../classes/empresas/Login.php';

    session_start();

    $database = new Database();
    $db = $database->connect();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = new Login($db);
        if($login->recover($_POST['username'])) {
            $success = "Le hemos enviado un enlace al correo asociado a su cuenta.";
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
?>

<!DOCTYPE html5>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV - Password Reset Empresas</title>
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center mt-5">
        <div class="mb-3">
            <h2>Recuperar Contraseña Empresas</h2>
        <div> 
        <div class="mb-3">
            <p>Ingrese su nombre de usuario para recuperar la contraseña</p>
        <div>
        <?php if (isset($success)):?>
        <div class="alert alert-success"><?php echo "<p>$success</p>"; ?></div>
        <?php endif;?>
        <?php if (isset($error)):?>
        <div class="alert alert-danger"><?php echo "<p>$error</p>"; ?></div>
        <?php endif;?>
        <form method="POST" action="passwordreset.php">
            <div class="mb-3">
                <label class="form-label" for="username">Usuario:</label>
                <input class="form-control" type="text" id="username" name="username" required>
            </div>
            <button class="btn btn-primary" type="submit">Recuperar Contraseña</button>
        </form>
        <div><p><a href="login.php">¿Recordaste tu contraseña?</a></p></div>
        </div>
</div>
</body>
</html>