<?php
include('functions.php');

if (
    !isset($_POST['task']) || $_POST['task']=='' ||
    !isset($_POST['deadline']) || $_POST['deadline']==''
) {
    exit('ParamError');
}

$id     = $_POST['id'];
$task   = $_POST['task'];
$deadline  = $_POST['deadline'];
$comment = $_POST['comment'];

$pdo = db_conn();

$sql = 'UPDATE php02_table SET task=:a1, deadline=:a2, comment=:a3 WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $task, PDO::PARAM_STR);
$stmt->bindValue(':a2', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: select.php');
    exit;
}
