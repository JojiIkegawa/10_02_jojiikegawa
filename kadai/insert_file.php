<?php
include('functions.php');

if (
    !isset($_POST['task']) || $_POST['task']=='' ||
    !isset($_POST['deadline']) || $_POST['deadline']==''
) {
    exit('ParamError');
}

$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];
var_dump($_FILES['upfile']);

if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] ==0) {

    $file_name = $_FILES['upfile']['name']; 
    $tmp_path = $_FILES['upfile']['tmp_name']; 
    $file_dir_path = 'upload/'; 

    $extension = pathinfo($file_name, PATHINFO_EXTENSION); 
    $uniq_name = date('YmdHis').md5(session_id()) . "." . $extension;
    $file_name = $file_dir_path.$uniq_name;
    

    if (is_uploaded_file($tmp_path)) {
        if (move_uploaded_file($tmp_path, $file_name)) { 
            chmod($file_name, 0644);
        } else { 
            exit('Error:アップロードできませんでした.');
        }
    }
}else{
    exit('画像が送信されていません');
}



$pdo = db_conn();


$sql ='INSERT INTO php02_table(id, task, deadline, comment, image, indate)
VALUES(NULL, :a1, :a2, :a3, :image, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $task, PDO::PARAM_STR);
$stmt->bindValue(':a2', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);
$stmt->bindValue(':image', $file_name, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status==false) {
    errorMsg($stmt);
} else {
    header('Location: index.php');
}
