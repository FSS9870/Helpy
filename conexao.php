<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "helpy-banco";
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$banco;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $usuario, $senha, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>