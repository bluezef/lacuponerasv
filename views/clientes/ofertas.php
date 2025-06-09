<?php
require_once '../../classes/Database.php';
include_once '../../classes/Cupones.php';

session_start();

$database = new Database();
$db = $database->connect();

$cupones = new Cupon($db);
$result = $cupones->readall();

unset($_SESSION['success']);
unset($_SESSION['error']);

if (isset($_SESSION['username']) && $_SESSION['cliente']) {
    $_SESSION['clientelogin'] = true;
}

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['cupon']=$_POST['comprar'];
    header("Location: compra.php");
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
        <div class="d-flex justify-content-between mb-3">
            <div class="mb-3">
                <h1>Cupones Para Ti:</h1>
            <?php if ($result->rowCount() > 0){ $i=0; ?>
                        <?php while ($row = $result->fetch(PDO::FETCH_OBJ)): ?>
                            <?php if($i=0):?>
                                <div class ="row">
                            <?php endif;?>
                                <div class="col">
                                    <div class="mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class = "card-title"><?php echo $row->titulo; ?></h5>
                                                <p class="card-text">
                                                    <s>Precio Regular: $<?php echo $row->precio_regular; ?></s><br>
                                                    <b>Precio Oferta: $<?php echo $row->precio_oferta; ?></b>
                                                </p>
                                                <form method="POST">
                                                        <button class="btn btn-success btn-sm" id="comprar" name="comprar" value=<?php echo $row->id; ?>>Comprar Cupón</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $i=$i+1; if($i=5):?>
                            </div>
                        <?php $i=0;endif;endwhile; ?>
                </div>
            <?php }else{  ?>
                </h2>No hay ofertas disponibles por el momento</h2>
            <?php } ?>
            </div>
        </div>
    </div>
    </main>
    <footer>

    </footer>
</body>
</html>
