<?php

$db = new PDO('mysql:host=localhost; dbname=invoice', 'root', '');

foreach($_POST['product_name'] as $key => $value){
    $sql = 'INSERT INTO items(name, price, quantity) VALUES(:name, :price, :qty)';
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'name' => $value,
        'price' => $_POST['product_price'][$key],
        'qty' => $_POST['product_quantity'][$key]
    ]);
}
echo "Product inserted successfully";
?>