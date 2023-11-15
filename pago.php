<?php

    require 'config/config.php';
    require 'config/database.php';
    require 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken(TOKEN_MP);

    $preference = new MercadoPago\Preference();
    $productos_mp = array();

    $db = new Database();
    $con = $db->conectar();

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    
    //print_r($_SESSION);

    $lista_carrito = array();

    if($productos != null) {
        foreach($productos as $clave => $cantidad) {
          $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos 
          WHERE id=? AND activo=1");
          $sql->execute([$clave]);
          $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);  
        }
    } else {
        header("Location: index.php");
        exit;
    }
         
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda en Linea</title>
    <!-- Incluir a través de CDN
    Cuando solo necesite incluir CSS o JS compilado de Bootstrap, puede usar jsDelivr. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" 
    crossorigin="anonymous">

    <link href="css/styles.css" rel="stylesheet">

    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <!-- Barra de navegación menú -->
    <header data-bs-theme="dark">

        <div class="collapse text-bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">

                        <div class="col-sm-8 col-md-7 py-4">
                            <h4>Acerca de</h4>
                            <p class="text-body-secondary">Bienvenido/a a nuestra tienda online, 
                                el destino ideal para encontrar productos de calidad y satisfacer todas tus necesidades. 
                                Nuestro objetivo es ofrecerte una experiencia de compra fácil, conveniente y gratificante 
                                desde la comodidad de tu hogar.</p>
                        </div>

                        <div class="col-sm-4 offset-md-1 py-4">
                            <h4>Contáctenos</h4>
                            <ul class="list-unstyled">
                                <li><a href="#" class="text-white"><i class="fa-brands fa-twitter"></i> Siguenos en Twitter</a></li>
                                <li><a href="#" class="text-white"><i class="fa-regular fa-thumbs-up"></i> Denle me gusta en Facebook</a></li>
                                <li><a href="#" class="text-white"><i class="fa-solid fa-envelope"></i> Envienos un Email</a></li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
        <!-- <div class="navbar navbar-dark bg-dark shadow-sm" -->
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container"> <!-- navbar-brand copiar y pegar este-->
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <strong><i class="fa-solid fa-store"></i> Tienda en Linea</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarHeader" aria-controls="navbarHeader" 
                aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>

                    <a href="carrito.php" class="btn btn-primary">
                        Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>

                </div>
            </div>
        </div>

    </header>

    <!-- Contenido -->
<main>
    <div class="container">

        <div class="row">
            <div class="col-6">
                <h4>Detalles de pago</h4>
                <div class="row">
                    <div class="col-12">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="checkout-btn"></div>
                    </div>
                </div>
            </div>    
        
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($lista_carrito == null){
                                echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                            } else {

                                $total = 0;
                                foreach($lista_carrito as $producto){
                                    $_id = $producto['id'];
                                    $nombre = $producto['nombre'];
                                    $precio = $producto['precio'];
                                    $descuento = $producto['descuento'];
                                    $cantidad = $producto['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento) / 100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;

                                    $item = new MercadoPago\Item();
                                    $item->id = $_id;
                                    $item->title = $nombre;
                                    $item->quantity = $cantidad;
                                    $item->unit_price = $precio_desc;
                                    $item->currency_id = "MXN";

                                    array_push($productos_mp, $item);
                                    unset($item);
                               
                            ?>        
                            <tr>
                                <td><?php echo $nombre; ?></td>
                                <td>
                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . 
                                    number_format($subtotal,2, '.', ','); ?></div>
                                </td>
                            </tr>
                            <?php } ?>
                            <!-- Agregar -->        
                            <tr>  
                                <td colspan="2">
                                    <p class="h3 text-end" id="total"><?php echo MONEDA . 
                                    number_format($total, 2, '.', ','); ?></p>
                                </td>                    
                            </tr>
                            <!-- Agregar -->
                        </tbody>
                        <?php } ?>                 
                    </table>
                </div>    
            </div>         
            
        </div>                        
    </div>    
</main>

<?php

$preference->items = $productos_mp;
$preference->back_urls = array(
    "success" => "http://localhost:8080/tienda_en_linea/captura.php",
    "failure" => "http://localhost:8080/tienda_en_linea/fallo.php"
);

$preference->auto_return = "approved";
$preference->binary_mode = true;

$preference->save();

?>

    <!-- Opción 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
    crossorigin="anonymous"></script>
    <!-- Para que funcionen los icones de fontawesome -->
    <script src="https://kit.fontawesome.com/8ce375a5f2.js" crossorigin="anonymous"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>
    <!--Checkout-Paypal-->

    <!-- dando estilos a button Paypal -->
    <script>
        paypal.Buttons({
            
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total; ?>
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                let URL = 'clases/captura.php'
                actions.order.capture().then(function(detalles) {
                    console.log(detalles)
                    //window.location.href = "completado.html"
                    let url = 'clases/captura.php'

                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response){
                        window.location.href = "completado.php?key=" + detalles['id']; //$datos['detalles']['id']
                    })
                });
            },

            onCancel: function(data) {
                alert("Pago Cancelado");
                console.log(data);
            }

        }).render('#paypal-button-container');

        const mp = new MercadoPago('TEST-36425bd5-6bb2-4fba-884a-11956d9481d3',{
            locale: 'es-MX'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con Mercado Pago'
            }
        })
    </script>

    <!--
        Moises Martinez Flores
        Instituto Tecnológico de Orizaba
        2023.                
    -->

</body>

</html>