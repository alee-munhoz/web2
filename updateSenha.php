<?php
session_start();
require 'conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

   
    $emailSessao = $_SESSION['email'];

   
    $senhaAtual = $_POST['senhaAtual'];
    $novaSenha = $_POST['novaSenha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    // Validação simples
    if ($novaSenha !== $confirmaSenha) {
        echo "As novas senhas não coincidem.";
        exit();
    }

    try {
        
     
        
        $sql = "SELECT senha FROM aluno WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $emailSessao);
        $stmt->execute();
        $senhaCripto = $stmt->fetchColumn();

     
        if (!password_verify($senhaAtual, $senhaCripto)) {
            echo "Senha atual incorreta.";
            exit();
        }

       
        $novaSenhaCripto = password_hash($novaSenha, PASSWORD_BCRYPT);
        $sql = "UPDATE aluno SET senha = :novaSenha WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':novaSenha', $novaSenhaCripto);
        $stmt->bindParam(':email', $emailSessao);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header('location:minhaconta.php');
        } else {
            echo "Não foi possível atualizar a senha.";
        }
    } catch (PDOException $e) {
        echo "Erro ao atualizar a senha: " . $e->getMessage();
    }
}
?>