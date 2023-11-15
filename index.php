<?php

    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    //session_destroy();

    //print_r($_SESSION);
    
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
    <link rel="stylesheet" href="css/styleWhatsapp.css"> <!-- quitar -->
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <!-- funcionamiento whatsapp opcional se puede omitir -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a
      href="https://api.whatsapp.com/send?phone=2722628019&text=Hola!%20gracias%20por%20comunicarte%20con%20B%C3%BAho-Shop%20Online."
      class="float"
      target="_blank">
      <i class="fa fa-whatsapp my-float"></i>
    </a>
    <!-- cierre -->

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
                                <li><a href="https://www.facebook.com/profile.php?id=61553392169245&mibextid=ZbWKwL" class="text-white"><i class="fa-regular fa-thumbs-up"></i> Denle me gusta en Facebook</a></li>
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
                            <a href="inicio.php" class="nav-link">Inicio</a>
                        </li>
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

    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach($resultado as $row) { ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <!-- Ocupando imagenes guardadas en disco -->
                            <?php

                            $id = $row['id'];
                            $imagen = "images/Productos/Calzado/" . $id . "/principal.jpg";

                            if(!file_exists($imagen)){
                                $imagen = "images/no-photo.jpg";
                            }

                            ?>
                            <img src="<?php echo $imagen; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                <p class="card-text">$ <?php echo 
                                number_format($row['precio'], 2, '.',  ','); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo 
                                        hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn 
                                        btn-primary">Detalles</a>
                                    </div>
                                    <button class="btn btn-outline-success" type="button" onClick="addProducto(<?php echo
                                    $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">
                                    Agregar al Carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
        function addProducto(id, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)
            //API que nos proporciona JS
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

</body>

</html>