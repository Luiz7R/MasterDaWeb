<?php

$host = '172.19.0.5';
$port = '3306';
$database = 'MasterDaWeb';
$username = 'masterdaweb';
$password = 'secreta';



try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    echo 'Conexão com o banco de dados estabelecida com sucesso!';
} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
}