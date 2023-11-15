<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Primer paso agregar el código de la API -->
    <!-- Reemplazar "prueba" con su propio ID de cliente de la aplicación de la cuenta de Sandbox Business -->
    <script src="https://www.paypal.com/sdk/js?client-id=AaUX2tlZYgKSb-NFbM2E387JGpEGIokLvIvTFQ7OwQK_CfMBa7l7y8X7EA5kbTuiMND67WezkVHvt00r&currency=MXN"></script>
    <!-- Pasar a producción: AYgpL4xq9bYn_BwvoKcLkVsvZLkIPKtirRTAuPNdReSldGIqPW2Xxhq1G7Aiv8JHxFHDKXeMjo5jLsE4 -->
    <!-- sb-goodr26873307@business.example.com -->
    <!-- 201019@Tania -->
    <!-- prueba: AaUX2tlZYgKSb-NFbM2E387JGpEGIokLvIvTFQ7OwQK_CfMBa7l7y8X7EA5kbTuiMND67WezkVHvt00r -->
    <!-- sb-805c326872893@personal.example.com -->
    <!-- x(9dMcn+ estar en modo sandbox e inicar sesión desde mi app ya sea con cuenta personal o bussines-->
</head>

<body>

    <div id="paypal-button-container"></div>
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
                            value: 100
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                actions.order.capture().then(function(detalles) {
                    //console.log(detalles);
                    window.location.href = "completado.html"
                });
            },
            onCancel: function(data) {
                alert("Pago Cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>

</body>

</html>