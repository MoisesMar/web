<?php

    require 'vendor/autoload.php';
    
    MercadoPago\SDK::setAccessToken('TEST-5640497809852816-081301-d8e93461934105c18dc62d1fd7f093dd-1449929378');
    //Credenciales de Prueba
    //Public Key
    //TEST-36425bd5-6bb2-4fba-884a-11956d9481d3
    //Access Token
    //TEST-5640497809852816-081301-d8e93461934105c18dc62d1fd7f093dd-1449929378
    
    $preference = new MercadoPago\Preference();

    $item = new MercadoPago\Item();
    $item->id = '0001';
    $item->title = 'Calzado Tienda en Línea';
    $item->quantity = 1;
    $item->unit_price = 150.00;
    $item->currency_id = "MXN";

    $preference->items = array($item);

    $preference->back_urls = array(
        "success" => "http://localhost:8080/tienda_en_linea/captura.php",
        "failure" => "http://localhost:8080/tienda_en_linea/fallo.php"
    );
    
    $preference->auto_return = "approved";
    $preference->binary_mode = true;

    $preference->save();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- SDK MercadoPago.js -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>

    <h3>Mercado pago</h3>

    <div class="checkout-btn"></div>

    <script>
        const mp = new MercadoPago('TEST-36425bd5-6bb2-4fba-884a-11956d9481d3',{
            locale: 'es-MX'
        });

        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con MP'
            }
        })
    </script>

</body>

</html>