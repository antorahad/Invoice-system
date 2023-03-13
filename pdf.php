<?php
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

$db = new PDO('mysql:host=localhost; dbname=invoice', 'root', '');
$sql = 'SELECT * FROM items';
$stmt = $db->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$at = 0;
$i = 1;
$html = '?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System</title>
    <style>
        h2{
            text-align:center;
        } 
            
        table{
            width:100%;
        }
            
        td, th{
            padding:8px;
            text-align:center;
        }  
        
        .my-table{
            text-align:right;
        }    

        #sign{
            padding-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
                    <h2>Invoice</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>S.NO</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>';

foreach ($rows as $row) {
    $html .= ' <tr>
    <td>' . $i . '</td>
     <td>' . $row['name'] . '</td>
     <td>' . number_format($row['price'], 2) . '</td>
     <td>' . $row['quantity'] . '</td>
     <td>' . number_format($row['price'] * $row['quantity']) . '</td>
 </tr>';

    $at += $row['price'] * $row['quantity'];
    $i++;
}
$html .= '  </tbody>
<tr>
    <th colspan="4" class="my-table">Tax (15%)</th>
    <th>' . number_format(($at * 15) / 100) . '</th>
</tr>
<tr>
    <th colspan="4" class="my-table">All Total</th>
    <th>' . number_format($at + ($at * 15) / 100, 2) . '</th>
</tr>
<tr>
    <th colspan="4" class="my-table">Round Total</th>
    <th>' . number_format(round($at + ($at * 15) / 100), 2) . '</th>
</tr>
<tr>
    <td colspan="5" id="sign">Signature</td>
</tr>
</table>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('invoice.pdf');
