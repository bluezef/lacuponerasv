<?php
include_once '../../classes/Database.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();

    $cupon = new Cupon($db);
    $cupon->titulo = $_POST['titulo'];
    $cupon->precio_regular = $_POST['regular'];
    $cupon->precio_oferta = $_POST['oferta'];
    $cupon->fecha_inicio = $_POST['inicio'];
    $cupon->fecha_fin = $_POST['fin'];
    $cupon->fecha_canje = $_POST['canje'];
    $cupon->cantidad = $_POST['cantidad'];
    $cupon->descripcion = $_POST['descripcion'];
    $cupon->usuario = $_SESSION['username'];

    if ($cupon->create()) {
        header("Location: menu.php");
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
        <div class="container d-flex align-items-center justify-content-center mt-5">
            <div class="mb-3">
                <h2>Formulario de Creación de Cupón</h2>
            <div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="creaciondecupon.php">
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
    </main>
</body>
</html>