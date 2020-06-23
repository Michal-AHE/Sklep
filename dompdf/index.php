<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../model/orders.php';
require_once 'autoload.inc.php';

$ordersModel = new OrdersModel();

$orderId = $_GET['orderId'];

$details = $ordersModel->getOrderDetails($orderId);

$html = "<html>"
        . "<head>"
        . "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>"
        . "<style>"
        . "body { font-family: DejaVu Sans, sans-serif; }"
        . "</style>"
        . "</head><body>";

$html .= "<h2>Faktura nr $orderId</h2>"
        . "<p>Sprzedający:</p>"
        . "<p>Sklep Medyczny</p>"
        . "<p>Adresat:</p>"
        . "<p>".$details['firstName'] . " " . $details['lastName'] . "</p>"
        . "<p>ulica ".$details['street'] . " " . $details['buildingNo'] . "/" . $details['apartmentNo'] . "</p>"
        . "<p>".$details['postalCode'] . " " . $details['city'] . "</p>";

$html .= "<table><thead><tr>"
        . "<th>Produkt</th>"
        . "<th>Ilość</th>"
        . "<th>Cena</th>"
        . "<th>Łącznie</th></tr>"
        . "</thead><tbody>";
foreach ($details['products'] as $product)
{
    $html .= "<tr><td>".$product['name']."</td><td>".$product['amount']."</td><td>".$product['price']." PLN</td><td>".$product['totalPrice']." PLN</td></tr>";
}

$html .= "<tr><td colspan='4' style='text-align: right;'>Razem: ".$details['totalPrice']." PLN</td></tr></tbody></table></body></html>";

$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');


// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("sklep_medyczny_faktura_".$orderId);