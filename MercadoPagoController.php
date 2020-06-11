<?php
require __DIR__  . '/vendor/autoload.php';

class MercadoPago
{
    private $public_key;
    private $access_token;
    private $integrator_id;

    public function __construct(){
        $this->public_key = 'TEST-81f4bb8b-fb38-4610-9f41-60f97269f731';
        $this->access_token = 'APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398';
        $this->integrator_id = 'dev_24c65fb163bf11ea96500242ac130004';
    }

    public function cartPreference($productos){
        
        $public_key = $this->public_key;
        $access_token = $this->access_token;
        $integrator_id = $this->integrator_id;

        MercadoPago\SDK::setAccessToken($access_token);
        MercadoPago\SDK::setIntegratorId($integrator_id);

        // Crea ítems de la preferencia
        $items = array();
        foreach ($productos as $producto){
            $item = new MercadoPago\Item();
            $item->title = $producto['titulo'];
            $item->unit_price = $producto['precio'];
            $item->quantity = $producto['cantidad'];
            $item->picture_url = 'https://facualavar-mp-ecommerce-php.herokuapp.com/'.$producto['img'];
            $item->description = $producto['descripcion'];

            array_push($items, $item);
        }

        $payer = new MercadoPago\Payer();
        $payer->name = "Lalo Landa";
        $payer->email = "test_user_63274575@testuser.com";
        $payer->phone = array("area_code" => "11", "number" => "222233333");
        $payer->identification = array(
            "type" => "DNI",
            "number" => "12345678"
        );
        $payer->address = array(
            "street_name" => "False",
            "street_number" => 123,
            "zip_code" => "1111"
        );

        

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();
        $preference->items = $items;
        $preference->payer = $payer;
        $preference->back_urls = array(
            "success" => "https://facualavar-mp-ecommerce-php.herokuapp.com/success.php",
            "failure" => "https://facualavar-mp-ecommerce-php.herokuapp.com/failure.php",
            "pending" => "https://facualavar-mp-ecommerce-php.herokuapp.com/pending.php"
        );
        $preference->notification_url = "https://facualavar-mp-ecommerce-php.herokuapp.com/notificaciones.php";
        $preference->payment_methods = array(
            "excluded_payment_methods" => array(
                array("id" => "amex")
            ),
            "excluded_payment_types" => array(
                array("id" => "atm")
            ),
            "installaments" => 6
        );
        $preference->auto_return = "approved";
        $preference->external_reference = 'facualavar@gmail.com';
        $preference->save();
        
        header('Location: '. $preference->init_point);
    }
}

$items = array();
$item = array(
    'id' => 1234,
    'titulo' => $_POST['title'],
    'img' => $_POST['img'],
    'precio' => $_POST['precio'],
    'cantidad' => $_POST['cantidad'],
    'descripcion' => 'Dispositivo movil de tienda  e-commerce'
);

array_push($items, $item);

$mercadoPago = new MercadoPago();
$mercadoPago->cartPreference($items);
