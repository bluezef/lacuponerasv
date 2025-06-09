<?php
require_once '../../classes/Database.php';
include_once '../../classes/Cupones.php';

session_start();

if (!isset($_SESSION['cliente'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->connect();

$cupon = new Cupon($db);
$result = $cupon->read($_SESSION['cupon']);
$result = $result->fetch(PDO::FETCH_OBJ);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->connect();

    if(isset($_POST['compra'], $_POST['cantidad'])){
        $_SESSION['total']=$_POST['cantidad']*$result->precio_oferta;
        $_SESSION['cantidad']=$_POST['cantidad'];
        $_SESSION['empresa']=$result->usuario;
        header('Location:pago.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="../../assets/cuponera.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV - Solicitudes de Registro</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
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
                <?php if($_SESSION['clientelogin']):?>
                    <li class="nav-item">
                        <a class="nav-link" href="pedidos.php">Mis Pedidos</a>
                    </li>
                <?php endif;?>
                <li class="nav-item">
                    <a class="nav-link" href="ofertas.php">Ofertas</a>
                </li>
                <?php if($_SESSION['clientelogin']){?>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['username']?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="?logout=true">Cerrar Sesión</a></li>
                    </ul>
                    </li>
                <?php }else{?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                <?php }?>
            </ul>
            </div>
        </div>
        </nav>
    </header>
    <main>
        <div class="container mt-5">
        <div class="container d-flex align-items-center justify-content-center mt-5">
            <h1>Compra de Cupón</h1>
        </div>
        <div class="mb-3">
            <h3>Cupón: <?php echo $result->titulo; ?></h3>
            <h4>Nombre de la Empresa:</h4> <p><?php echo $result->nombre_empresa; ?></p>
            <h4>Precio Regular: </h4> <p>$<?php echo $result->precio_regular; ?></p>
            <h4>Precio en Oferta: </h4> <p>$<?php echo $result->precio_oferta; ?></p>
            <h4>Fecha Máxima de Compra:</h4> <p><?php echo $result->fecha_fin; ?></p>
            <h4>Fecha Máxima de Canje:</h4> <p><?php echo $result->fecha_canje; ?></p>
            <h4>Cantidad en Stock:</h4> <p><?php echo $result->cantidad; ?></p>
            <h4>Descripción:</h4> <p><?php echo $result->descripcion; ?></p>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label" for="cantidad">Cantidad de Cupones:</label>
                    <input class="form-control" type="number" id="cantidad" name="cantidad" min = 1 max = <?php if ($result->cantidad < 5){echo $result->cantidad;}else{echo 5;}?> required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success btn-sm" id="compra" name="compra" value=<?php echo $_SESSION['cupon']; ?>>Finalizar Compra</button>
                </div>
            </form>
        </div>
    </div>
    </main>
</body>
</html>
