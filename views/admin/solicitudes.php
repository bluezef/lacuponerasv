<?php
require_once '../../classes/Database.php';
include_once '../../classes/Solicitudes.php';

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->connect();

$solicitudes = new Solicitud($db);
$result = $solicitudes->readall();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['solicitud']=$_POST['ver'];
    header("Location: review.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV - Solicitudes de Registro</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
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
        <div class="container mt-5">
            <div class="d-flex justify-content-between mb-3">
                <h1>Solicitudes Registradas</h1>
            </div>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
            <?php endif; ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de Empresa</th>
                        <th>Ver a Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->rowCount() > 0){ ?>
                        <?php while ($row = $result->fetch(PDO::FETCH_OBJ)): ?>
                            <tr>
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->nombre_empresa; ?></td>
                                <td class="text-center">
                                    <form method="POST">
                                        <button class="btn btn-primary" id="ver" name="ver" value=<?php echo $row->id; ?>>Ver a Detalle</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php }else{  ?>
                        <tr>
                            <td colspan="3" class="text-center">No hay entradas registradas</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
