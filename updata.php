<?php
// update.php

// 從 PUT 讀取輸入
parse_str(file_get_contents("php://input"), $_PUT);

$id = $_PUT['id'] ?? '';
$name = $_PUT['name'] ?? '';
$phone = $_PUT['phone'] ?? '';
$address = $_PUT['address'] ?? '';
$age = $_PUT['age'] ?? '';

$filename = 'customer.csv';
$rows = array_map('str_getcsv', file($filename));
$header = array_shift($rows);

$updated = false;
foreach ($rows as &$row) {
    if ($row[0] == $id) {
        $row[1] = $name;
        $row[2] = $phone;
        $row[3] = $address;
        $row[4] = $age;
        $updated = true;
        break;
    }
}

if ($updated) {
    $fp = fopen($filename, 'w');
    fputcsv($fp, $header);
    foreach ($rows as $r) {
        fputcsv($fp, $r);
    }
    fclose($fp);
    echo json_encode(["status" => "success", "message" => "Customer updated"]);
} else {
    echo json_encode(["status" => "error", "message" => "Customer not found"]);
}
