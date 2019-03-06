<?php
include('functions.php');

$pdo = db_conn();

$sql = 'SELECT * FROM php02_table ORDER BY deadline DESC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    $res = [];
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $res[] = $result;
    }
    echo json_encode($res);
}
?>

