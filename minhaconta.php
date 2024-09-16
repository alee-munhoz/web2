<?php
session_start();
require 'conexao.php';
date_default_timezone_set('America/Sao_Paulo'); 

$session_duration = 60 * 15; 


if (isset($_SESSION['email'])) {
    $emailSessao = $_SESSION['email'];

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $session_duration) {
        session_unset();     
        session_destroy();   
        header("Location: index.php");
        exit();
    }

    $_SESSION['LAST_ACTIVITY'] = time(); 
} else {
    header("Location: index.php");
    exit();
}

try{
    $sql = " SELECT nome,email,cpf FROM aluno WHERE email = :email";    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $emailSessao);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        $nome = htmlspecialchars($usuario['nome']);
        $email = htmlspecialchars($usuario['email']);
        $cpf = htmlspecialchars($usuario['cpf']);
    } else {
        echo "Usuário não encontrado.";
    }
} catch (PDOException $e) {
    echo "Erro ao buscar os dados: " . $e->getMessage();
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição</title>
    <link rel="stylesheet" href="style_mconta.css">
    
        
       
</head>
<body>
    <header>
    <h1>Área do candidato</h1>
    <div class="user-menu">
        <h2>Bem-vindo,</h2>
        <div class="dropdown">
            <button class="dropbtn"><?php echo htmlspecialchars($emailSessao); ?></button>
            <div class="dropdown-content">
                <a href="inscricao.php">Inscrições</a>
                <a href="minhaconta.php">Minha Conta</a>
            </div>
        </div>
        <form action="logout.php"><button>Sair</button></form>
    </div>
        
    </header>

<div class="dados"> 
    <h2>Dados do Usuário</h2>
    <p><span>Nome:</span><br> <?php echo $nome; ?></p>
    <p><span>E-mail:</span> <br><?php echo $email; ?></p>
    <p><span>CPF:</span> <br><?php echo $cpf; ?></p>
</div>
   <div class="btnD">
    <a href="delete.php">Excluir conta</a>
    
   </div>
   <div class="btnA">
   <a href="atualizarSenhapagina.php">Alterar Senha</a>
   </div>
  
</body>
<script>
    // Redireciona o usuário após 15min 
    setTimeout(function(){
        alert('Sua sessão expirou. Você será redirecionado.');
        window.location.href = 'index.php';
    }, 900000); // 15 minutos em milisegundos 
</script>
</html>