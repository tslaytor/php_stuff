<?php 
$id = $_POST['id'];

// establish connection
require_once('database.php');

$statment = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statment->bindValue(':id', $id);
$statment->execute();

header('location: index.php');
exit;

?>
