<?php 
$host = 'localhost';
$dbname = 'fatec';
$username = 'root';
$password = '';

try{
    // função que cria o objeto de conexão com o bd
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // define o modo de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
    // exibe o erro encontrado em caso de falha na conexão
    echo "Erro de conexão: ". $e->getMessage();
}
?>