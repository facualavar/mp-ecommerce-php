<?php

MercadoPago\SDK::setAccessToken("APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398");

switch($_POST["type"]) {
    case "payment":
        $payment = MercadoPago\Payment.find_by_id($_POST["id"]);
        $archivo = fopen("json_notifications_payment.txt", "a");
        fputs($archivo, $payment);
        fclose($archivo);

        //Guardar datos del pago
        break;
    case "plan":
        $plan = MercadoPago\Plan.find_by_id($_POST["id"]);
        $archivo = fopen("json_notifications_plan.txt", "a");
        fputs($archivo, $plan);
        fclose($archivo);
        break;
    case "subscription":
        $plan = MercadoPago\Subscription.find_by_id($_POST["id"]);
        $archivo = fopen("json_notifications_subscription.txt", "a");
        fputs($archivo, $plan);
        fclose($archivo);
        break;
    case "invoice":
        $plan = MercadoPago\Invoice.find_by_id($_POST["id"]);
        $archivo = fopen("json_notifications_invoice.txt", "a");
        fputs($archivo, $plan);
        fclose($archivo);
        break;
}

?>