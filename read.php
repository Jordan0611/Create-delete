<?php
// read.php

$filename = 'customer.csv';
$rows = array_map('str_getcsv', file($filename));
$header = array_shift($rows); // 移除標題列

$id = $_GET['id'] ?? '';

if ($id === '') {
    // 無 id 時傳回全部資料
    $data = [];
    foreach ($rows as $row) {
        $data[] = array_combine($header, $row);
    }
    echo json_encode($data);
} else {
    // 有 id 時只傳回指定那一筆
    foreach ($rows as $row) {
        if ($row[0] == $id) {
            echo json_encode(array_combine($header, $row));
            exit;
        }
    }
    echo json_encode(["status" => "error", "message" => "Customer not found"]);
}
