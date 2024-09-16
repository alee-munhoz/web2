<?php
// Com o require , ele para a execução da aplicação
require 'conexao.php';
// include 'conexao.php'; -- quando ele for chamado , ignora o que deu erro e faz as instruções da linha seguintes 

if (isset($_POST['email']) && isset($_POST['senha'])){
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $senha_digitada = $_POST['senha'];
    if(empty($email) || empty($senha_digitada) || empty($cpf) || empty($nome)){
        echo "Preencha todos os campos.";
        exit;
    }
    // Criptografar a senha
    $senha_cripto = password_hash($senha_digitada,PASSWORD_BCRYPT);
    try{
        $sql = "INSERT INTO aluno (email,senha,nome,cpf) VALUES (:email,:senha,:nome,:cpf)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_cripto);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        

        $stmt->execute();
        header("location: index.php");
    }
    catch(PDOException $e){
        echo "Erro ao cadastrar o  aluno: ". $e->getMessage();
    }
}
else{
    echo "Dados incompletos.";
}
?>