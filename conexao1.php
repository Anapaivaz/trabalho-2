<?php

session_start();

$localhost = "localhost";
$user = "root";
$passw = "";
$banco = "trabalho";

global $pdo;

try {
    // orientada a objetos com pdo
    $pdo = new PDO("mysql:dbname=".$banco."; host=".$localhost, $user, $passw);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "ERRO: " . $e->getMessage();
    exit;
}
?>
