<?php
// delete.php

// 從 DELETE 讀取輸入
parse_str(file_get_contents("php://input"), $_DELETE);
$id = $_DELETE['id'] ?? '';

$filename = 'customer.csv';
$rows = array_map('str_getcsv', file($filename));
$header = array_shift($rows);

$found = false;
$new_rows = [];
foreach ($rows as $row) {
    if ($row[0] == $id) {
        $found = true;
        // 不將此列加入 new_rows 表示刪除
    } else {
        $new_rows[] = $row;
    }
}

if ($found) {
    $fp = fopen($filename, 'w');
    fputcsv($fp, $header);
    foreach ($new_rows as $r) {
        fputcsv($fp, $r);
    }
    fclose($fp);
    echo json_encode(["status" => "success", "message" => "Customer deleted"]);
} else {
    echo json_encode(["status" => "error", "message" => "Customer not found"]);
}
