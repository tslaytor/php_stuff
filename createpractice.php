<?php 

$pdo = new Pdo('mysql:host=localhost;port=8889;dbname=production_crud', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['HTTP_METHOD'] === 'POST') {
    // then get the form data
    $title = $_POST['title'];
}