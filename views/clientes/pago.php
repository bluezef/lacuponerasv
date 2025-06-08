<?php
require_once '../../classes/Database.php';
include_once '../../classes/Cupones.php';
include_once '../../classes/Compras.php';
include_once '../../classes/fpdf/fpdf.php';

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
    $compra = new Compra($db);
    $compra->id_oferta = $_SESSION['cupon'];
    $compra->monto = $_SESSION['total'];
    $compra->factura_path = '../../assets/fact/COUP'.$_SESSION['cupon'].$_SESSION['username'].date('Y-m-d').'.pdf';
    $compra->usuario = $_SESSION['username'];
    $compra->empresa = $result->usuario;
    if ($compra->create()) {
        $cupon->compra($_SESSION['cupon'],$_SESSION['cantidad']);
        $pdf->Output('D','COUP'.$_SESSION['cupon'].$_SESSION['username'].date('Y-m-d').'.pdf');
        exit();
    } else {
        $error = "Hubo un problema al crear la solicitud.";
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
            <h3>Precio Unitario:</h3> <p><?php echo $result->precio_oferta; ?></p>
            <h3>Cantidad:</h3> <p><?php echo $_SESSION['cantidad']; ?></p>
            <h3>Total A Pagar:</h3> <p><?php echo $_SESSION['total'] ?></p>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label" for="tarjeta">Número de Tarjeta:</label>
                    <input class="form-control" type="text" pattern="[0-9]{16}" title="4123123412341234" id="tarjeta" name="tarjeta" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="tarjeta">Fecha de Vencimiento:</label>
                    <input class="form-control" type="date" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="cvv">CVV:</label>
                    <input class="form-control" type="password" id="cvv" name="cvv" pattern="[0-9]{3}" required>
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
