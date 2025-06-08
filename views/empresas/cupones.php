<?php
require_once '../../classes/Database.php';
include_once '../../classes/Cupones.php';

session_start();

if (!isset($_SESSION['empresa'])) {
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

$cupones = new Cupon($db);
$result = $cupones->readallfromuser($_SESSION['username']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['desactivar'])) {
    $cupones->desactivar($_POST['desactivar']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV - Cupones Creados</title>
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
                <a class="nav-link" href="cupones.php">Mis Cupones</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="creaciondecupon.php">Crear Cupones</a>
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
                <h1>Cupones Creados</h1>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Precio Regular</th>
                        <th>Precio Oferta</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Fecha de Canje</th>
                        <th>Cantidad</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->rowCount() > 0){ ?>
                        <?php while ($row = $result->fetch(PDO::FETCH_OBJ)): ?>
                            <tr>
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->titulo; ?></td>
                                <td><?php echo $row->precio_regular; ?></td>
                                <td><?php echo $row->precio_oferta; ?></td>
                                <td><?php echo $row->fecha_inicio; ?></td>
                                <td><?php echo $row->fecha_fin; ?></td>
                                <td><?php echo $row->fecha_canje; ?></td>
                                <td><?php echo $row->cantidad; ?></td>
                                <td><?php echo $row->descripcion; ?></td>
                                <td><?php if($row->estado==1 && strtotime($row->fecha_fin)>strtotime(date('Y-m-d'))){echo 'Disponible';}else{echo 'No Disponible';}; ?></td>
                                <td class="text-center">
                                    <form method="POST">
                                        <?php if($row->estado==1 && strtotime($row->fecha_fin)>strtotime(date('Y-m-d'))):?>
                                            <button class="btn btn-danger" id="desactivar" name="desactivar" value=<?php echo $row->id; ?>>Desactivar Cupón</button>
                                        <?php endif;?>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php }else{  ?>
                        <tr>
                            <td colspan="11" class="text-center">No hay entradas registradas</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
