<?php

define("CLIENT_ID", "AaUX2tlZYgKSb-NFbM2E387JGpEGIokLvIvTFQ7OwQK_CfMBa7l7y8X7EA5kbTuiMND67WezkVHvt00r");
define("TOKEN_MP", "TEST-5640497809852816-081301-d8e93461934105c18dc62d1fd7f093dd-1449929378");
define("CURRENCY", "MXN");
define("KEY_TOKEN", "Anonymous.20119@M&T0*");
define("MONEDA", "$");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>
