<?php 
    require_once '../../classes/Database.php';
    
    session_start();

    $database = new Database();
    $db = $database->connect();

    if(!isset($_SESSION['empresa'])) {
        header("Location: login.php");
        exit();
    }

    if(isset($_GET['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <title>La Cuponera SV - Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center mt-5">
        <div class="mb-3">
        <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
        <div class="mb-3">
        <div class="mb-3">
            <a href="creaciondecupon.php"><button class="btn btn-primary">Crear un nuevo cupón</button></a>
        </div>
        <div class="mb-3">   
            <a href="?logout=true"><button class="btn btn-primary" type="submit">Cerrar Sesión</button></a>
        </div>
    </div>
</body>
</html>