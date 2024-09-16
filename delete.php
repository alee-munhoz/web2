<?php
session_start();
require 'conexao.php';
date_default_timezone_set('America/Sao_Paulo'); 




if (isset($_SESSION['email'])) {
    $emailSessao = $_SESSION['email'];
}
try{
    $sql = "DELETE FROM aluno WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $emailSessao);
    $stmt->execute();
    if($stmt->rowCount()>0){
        header('location: index.php');
    }
    else{
        echo "Não foi possível excluir o usuário.";
    }
}
catch(PDOException $e){
    echo "Erro ao excluir o usuário: ". $e->getMessage();
}


?>