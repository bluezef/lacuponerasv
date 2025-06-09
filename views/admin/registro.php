<?php
include_once '../../classes/Database.php';
include_once '../../classes/admin/Signup.php';

session_start();

if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

unset($_SESSION['success']);
unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect(); 
    $signup = new Signup($db);
    $signup->username = $_POST['username'];
    $signup->password = $_POST['password'];

    if ($signup->create()) {
        $_SESSION['success']='Usuario registrado correctamente, puede iniciar sesión';
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error']='Hubo un error al registrar al usuario';
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html5>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <title>La Cuponera SV - Registro de Administradores</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</head>
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
                    Reportes
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="gananciasporempresa.php">Ganancias Por Empresa</a></li>
                    <li><a class="dropdown-item" href="ventasporempresa.php">Ventas Por Empresa</a></li>
                </ul>
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
        <div class="container d-flex align-items-center justify-content-center mt-5">
            <div class="mb-3">
                <h2>Registro de Administradores</h2>
            <div>
            <?php if (isset($error)):?>
            <div class="alert alert-danger"><?php echo "<p>$error</p>"; ?></div>
            <?php endif;?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label" for="username">Usuario:</label>
                    <input class="form-control" type="text" id="username" name="username" required>
                </div>  
                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña:</label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>  
                <button class="btn btn-primary" type="submit">Registrar Nuevo Administrador</button>
            </form>
        </div>
    </main>
</body>
</html>