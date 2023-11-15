<?php
    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if ($id == '' || $token == '') {
        echo 'Error al procesar la petición';
        exit;
    } else {
    
            $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    
            if ($token == $token_tmp) {
    
            $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);
            if ($sql->fetchColumn() > 0) {
    
                $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id=? 
                AND activo=1 LIMIT 1");
                $sql->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $precio = $row['precio'];
                $descuento = $row['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);
                $dir_images = 'images/Productos/Calzado/' . $id . '/';
    
                $ruta_Img = $dir_images . 'principal.jpg';
    
                if (!file_exists($ruta_Img)) {
                    $ruta_Img = 'images/no-photo.jpg';
                }
    
                $imagenes = array();
                if (file_exists($dir_images)) {
                    $dir = dir($dir_images);
    
                    while (($archivo = $dir->read()) != false) {
                        if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                            $imagenes[] = $dir_images . $archivo;
                        }
                    }
                    $dir->close();
                }

                $sqlCaracter = $con->prepare("SELECT DISTINCT(det.id_caracteristica) AS idCat, cat.
                caracteristica FROM det_prod_caracter AS det INNER JOIN caracteristicas AS cat ON
                det.id_caracteristica=cat.id WHERE det.id_producto=?");
                $sqlCaracter->execute([$id]);

            }
        } else {
            echo 'Error al procesar la petición';
            exit;
        }
    }
   
    //$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
    //$sql->execute();
    //$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

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

                    <a href="checkout_v2.php" class="btn btn-primary">
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
                <div class="col-md-6 order-md-1">

                    <div id="carouselImages" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $ruta_Img; ?>" class="d-block w-100">
                            </div>

                            <?php foreach ($imagenes as $img) { ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img; ?>" class="d-block w-100">
                                </div>
                            <?php } ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>

                <div class="col-md-6 order-md-2">
                    <h2><?php echo  $nombre; ?></h2>

                    <?php if ($descuento > 0) { ?>
                        <p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p>
                        <h2>
                            <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                            <small class="text-success"><?php echo $descuento; ?>% descuento</small>
                        </h2>

                    <?php } else { ?>

                        <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>

                    <?php } ?>

                    <p class="lead">
                        <?php echo $descripcion; ?>
                    </p>

                    <div class="col-3 my-3">

                        <?php

                        while($row_cat = $sqlCaracter->fetch(PDO::FETCH_ASSOC)){
                            $idCat = $row_cat['idCat'];
                            echo $row_cat['caracteristica'] . ": ";

                            echo "<select class='form-select' id='cat_$idCat'>"; //QUITAR EL id

                            $sqlDet = $con->prepare("SELECT id, valor, stock FROM
                            det_prod_caracter WHERE id_producto=? AND id_caracteristica=?");
                            $sqlDet->execute([$id, $idCat]);
                            while($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)){
                                echo "<option id='" . $row_det['id'] . "'>" . $row_det['valor'] 
                                . "</option>";
                            }
                            
                            echo "</select>";
                        }

                        ?>

                    </div>

                    <div class="col-3 my-3">
                        <b>Cantidad:</b> <input class="form-control" id="cantidad" name="cantidad"
                        type="number" min="1" max="10" value="1">
                    </div>

                    <!-- Funcionamiento botón agregar al carrito --> 
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar Ahora</button>
                        <button class="btn btn-outline-primary" type="button" onClick="addProducto(<?php echo
                        $id; ?>, cantidad.value, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
                    </div>

                    <!-- Funcionamiento botón agregar al carrito versión 2.0 
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar Ahora</button>
                        <button class="btn btn-outline-primary" id="btnAgregar" type="button"
                        >Agregar al carrito</button>
                    </div> -->

                </div>

            </div>

        </div>    
    </main>

    <!-- Opción 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
    crossorigin="anonymous"></script>
    <!-- Para que funcionen los icones de fontawesome -->
    <script src="https://kit.fontawesome.com/8ce375a5f2.js" crossorigin="anonymous"></script>

    <script>
        //Funcionamiento JavaScript botón agregar al carrito Versión 2.0
        /* let btnAgregar = document.getElementById("btnAgregar")
        let inputCantidad = document.getElementById("cantidad").value
        btnAgregar.onclick = addProducto(<?php echo $id; ?>, inputCantidad, '<?php echo 
        $token_tmp; ?>') */

        function addProducto(id, cantidad, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('cantidad', cantidad)
            formData.append('token', token)
            //API que nos proporciona JS / Petición de AJAX con fetch
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let elemento = document.getElementById("num_cart")
                        elemento.innerHTML = data.numero
                    }
                })
        }
    </script>

    <!--
        Moises Martinez Flores
        Instituto Tecnológico de Orizaba
        2023.                
    -->

</body>

</html>