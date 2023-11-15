<?php

    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    
    print_r($_SESSION);

    $lista_carrito = array();

    if($productos != null) {
        foreach($productos as $clave => $cantidad) {
          $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos 
          WHERE id=? AND activo=1");
          $sql->execute([$clave]);
          $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);  
        }
    }

    //$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
    //$sql->execute();
    //$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    //session_destroy();
      
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
        
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
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
                        ?>        
                        <tr>
                            <td><?php echo $nombre; ?></td>
                            <td><?php echo MONEDA . number_format($precio_desc,2, '.', ','); ?></td>
                            <td>
                                <input type="number" min="1" max="10" step="1" value="<?php echo 
                                $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" 
                                onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . 
                                number_format($subtotal,2, '.', ','); ?></div>
                            </td>
                            <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo 
                            $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
                        </tr>
                        <?php } ?>
                        <!-- Agregar -->        
                        <tr>
                            <td colspan="3"></td>   
                            <td colspan="2">
                                <p class="h3" id="total"><?php echo MONEDA . 
                                number_format($total, 2, '.', ','); ?></p>
                            </td>                    
                        </tr>
                        <!-- Agregar -->
                    </tbody>
                   <?php } ?>                 
                </table>
            </div>    

            <?php if($lista_carrito != null) { ?>
            <div class="row">

                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>          
                </div>

            </div>
            <?php } ?> 

    </div>    
</main>

  <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" 
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                    <button type="button" class="btn-close" 
                    data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                    data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" 
                    onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Opción 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" 
    crossorigin="anonymous"></script>
    <!-- Para que funcionen los icones de fontawesome -->
    <script src="https://kit.fontawesome.com/8ce375a5f2.js" crossorigin="anonymous"></script>

    <script>
        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event){
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })


        function actualizaCantidad(cantidad, id) {
            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'agregar')
            formData.append('id', id)
            formData.append('cantidad', cantidad)
            //API que nos proporciona JS
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {

                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub
                        //actualizando el total general
                        let total = 0.00
                        let list = document.getElementsByName('subtotal[]')
                        
                        for(let i = 0; i < list.length; i++){
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''))
                        }

                        total = new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2
                        }).format(total)
                        document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total
                    }
                })
        }

        function eliminar(){

            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value

            let url = 'clases/actualizar_carrito.php'
            let formData = new FormData()
            formData.append('action', 'eliminar')
            formData.append('id', id)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data => {
                if(data.ok){
                location.reload()
                }
            })
        }
    </script>

</body>

</html>