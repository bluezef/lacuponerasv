<?php
    require_once '../../classes/Database.php';
    require_once '../../classes/empresas/Login.php';

    session_start();

    $database = new Database();
    $db = $database->connect();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = new Login($db);
        if($login->authenticate($_POST['username'], $_POST['password'])) {
            header("Location: menu.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
?>

<!DOCTYPE html5>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV - Login Empresas</title>
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<div class="container d-flex align-items-center justify-content-center mt-5">
        <div class="mb-3">
            <h2>Inicio de Sesión de Empresas</h2>
        <div>
        <?php if (isset($error)):?>
        <div class="alert alert-danger"><?php echo "<p>$error</p>"; ?></div>
        <?php endif;?>
        <form method="POST" action="login.php">
                <label class="form-label" for="username">Usuario:</label>
                <input class="form-control" type="text" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Contraseña:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>   
            <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
        </form>
        
    <div><p>¿No tienes una cuenta? <a href="signup.php">Registrate aquí</a></p></div>
    <div><p>¿Eres un cliente? <a href="../clientes/login.php">Inicia sesión aquí</a></p></div>
    <div><p><a href="passwordreset.php">¿Olvidaste tu contraseña?</a></p></div>
    </div>
</div>
</body>
</html>