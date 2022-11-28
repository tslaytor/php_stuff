<?php 
$id = $_POST['id'];

$pdo = new PDO('mysql:host=localhost;dbname=products_crud', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statment = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statment->bindValue(':id', $id);
$statment->execute();

header('location: index.php');
exit;

?>
