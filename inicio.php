<?php

    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    //session_destroy();
    //este código permite el fucnionamiento del botón carrito
    //print_r($_SESSION);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Attachment - Moises Martinez Flores</title>
    <!-- Incluir a través de CDN
    Cuando solo necesite incluir CSS o JS compilado de Bootstrap, puede usar jsDelivr. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="css/styleWhatsapp.css">
    <link rel="stylesheet" href="css/stylesinicio.css">
    <link href="css/styles.css" rel="stylesheet"> 
</head>
<body>
    
    <!-- funcionamiento whatsapp -->
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

    <div class="content__1">
    
        <h1>Bienvenidos a nuestra Tienda<br> Búho-Shop Online</h1>

        <div class="content__icon-all">

            <div class="content__icon"><img src="images/Inicio/icon-1.png">
                <h4>Tiempo Real</h4>
                <p>Esto permite a los comerciantes tomar decisiones informadas sobre la marcha y mejorar la experiencia del cliente.
                </p>
            </div>

            <div class="content__icon"><img src="images/Inicio/icon-2.png">
                <h4>Compartir en las redes</h4>
                <p>Aumentar la visibilidad de la marca, generar interés en los productos y servicios, y aumentar las ventas.</p>
            </div>

            <div class="content__icon"><img src="images/Inicio/icon-3.png">
                <h4>Innovación</h4>
                <p>La introducción de nuevas tecnologías, como la realidad virtual o la inteligencia artificial, para mejorar la experiencia de compra</p>
            </div>

            <div class="content__icon"><img src="images/Inicio/icon-4.png">
                <h4>Métodos de pago</h4>
                <p>Facilitar y agilizar el proceso de compra para los clientes. Para ello, deben ser seguros, confiables y fáciles de usar.</p>
            </div>

            <div class="content__icon"><img src="images/Inicio/icon-5.png">
                <h4>Calidad en Imágenes</h4>
                <p>Las imágenes de alta calidad permiten a los clientes ver los detalles del producto, como el tamaño, el color, la forma y los materiales.</p>
            </div>

        </div> <!-- Cierre de content__icon-all -->

        <hr>

        <p class="parrafo1"><br><b>Sobre nosotros:</b><br>En Búoh-Shop Online, creemos que todos merecen tener acceso a productos de
            calidad a precios accesibles. Por eso, nos dedicamos a ofrecer una amplia selección de productos
            de las mejores marcas del mercado, a precios que no te dejarán indiferente.
            Nuestro equipo está formado por personas apasionadas por el comercio electrónico y la
            satisfacción del cliente. Estamos comprometidos a ofrecerte una experiencia de compra online
            rápida, sencilla y segura.</p>

    </div>

    <div class="content__2">
        <div class="content__item-1">
            <img src="images/Inicio/LogoTiendaO.jpg">

            <h1>Nuestra Historia</h1>

            <p>Búoh-Shop Online fue fundada en 2023 por Moises Martinez Flores, Kevin Óscar Ramírez Camarena,
                Miguel Ángel Trujillo Castañeda y Luis Alberto de Rosas Mejía. La idea surgió
                de la pasión de MR - Códigos de Programación por el comercio electrónico y su deseo de ofrecer
                a los clientes productos de calidad a precios accesibles, a través de la realización de páginas y
                plataformas web para convertir un negocio o idea de negocio en un ecommerce.</p>

            <h1>Nuestra Misión</h1>
                
            <p>Es ofrecer a nuestros clientes una experiencia de compra online excepcional. Nos
                comprometemos a ofrecer:
                <ul>
                    <li>Una amplia selección de productos de las mejores marcas del mercado</li>
                    <li>Precios accesibles</li>
                    <li>Un servicio al cliente rápido, seguro y eficiente</li>
                </ul>
            </p>

            <h1>Nuestra visión</h1>

            <p>Nuestra visión es ser la tienda online de referencia para los clientes de todo el país. Queremos ser
            el lugar donde los clientes puedan encontrar todo lo que necesitan, a precios que no pueden
            rechazar.</p>
            
        </div>
    </div>

    <div class="content__3"></div>

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