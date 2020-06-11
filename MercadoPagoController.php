<?php
require __DIR__  . '/vendor/autoload.php';

class MercadoPago
{
    private $public_key;
    private $access_token;

    public function __construct(){
        $this->public_key = 'TEST-81f4bb8b-fb38-4610-9f41-60f97269f731';
        $this->access_token = 'TEST-7177152224456365-121915-8be8fce1c791b75f448b32e8f08cdcee-419365105';
    }

    public function cartPreference($productos){
        
        $public_key = $this->public_key;
        $access_token = $this->access_token;

        MercadoPago\SDK::setAccessToken($access_token);

        // Crea ítems de la preferencia
        $items = array();
        foreach ($productos as $producto){
            $item = new MercadoPago\Item();
            $item->title = $producto['titulo'];
            $item->unit_price = $producto['precio'];
            $item->quantity = $producto['cantidad'];
            $item->picture_url = 'https://facualavar-mp-ecommerce-php.herokuapp.com'.$producto['img'];
            $item->description = $producto['descripcion'];

            array_push($items, $item);
        }

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();
        $preference->items = $items;
        $preference->external_reference = 'facualavar@gmail.com';
        $preference->save();
        
        //header('Location: '. $preference->init_point);
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
