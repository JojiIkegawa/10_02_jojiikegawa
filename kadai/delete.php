<?php
$id   = $_GET['id'];

include('functions.php');
$pdo = db_conn();

$sql = 'DELETE FROM php02_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: select.php');
    exit;
}
