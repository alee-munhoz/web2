<?php 
require 'conexao.php';
//email
if(isset($_COOKIE["email"])){
    $emailCookie =  $_COOKIE["email"];
}
else{
    $emailCookie = " ";
}
//Senha
if(isset($_COOKIE["password"])){
    $passwordCookie =  $_COOKIE["password"];
}
else{
    $passwordCookie = "";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira+Condensed:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
      body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        form label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
            text-align: left;
        }

        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }
       .checkboxCookie{
        margin:5px;
        display: block;
        font-family: "Saira Condensed", sans-serif;
       }
       .checkboxCookie input{
        margin-top:15px;
        transform: scale(1.5);
        bottom: -10px;
       }
       .checkboxCookie input:hover{
        transform: scale(1.9);
    
       }
       .checkboxCookie h2{
        margin-top:2px;
       }

    </style>
</head>
<body>
<form action="#" method="post">
       <label>E-mail</label> <br>
    <input type="email" name="email" value="<?php echo $emailCookie; ?>"><br> 
        <label>Senha</label> <br>
        <input type="password" name="password" value="<?php echo $passwordCookie; ?>"><br>

        <input type="submit" name="btnS" value="Entrar">
        <div class="checkboxCookie">
        <input type="checkbox" name="btnCookie"> <h3 >Manter conectado?</h3>
        </div>
        <div>
            <span>Não tem cadastro? <a href="cadastro.php">Cadastre-se</a></span>
        </div>
        
    </form>
   
    
</body>
</html>
<?php
if($_POST){
$email = $_POST['email'];
$password = $_POST['password'];

if($email=="aluno@fatec.com" && $password=="Aluno123"){
    header("location: inscricao.php");
}
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    session_start();
    if(isset($_POST["btnCookie"])){
        $nm_email = "email";
        $valor_email = $_POST['email'];
        // Time retorna quantos segundos vai durar o cookie,3600 dura 1h
        $duracao_email = time()+3600;
        // Poderia ser direto
        setcookie($nm_email,$valor_email,$duracao_email);
    }
    if(isset($_POST["btnCookie"])){
        $nm_password = "password";
        $valor_password = $_POST['password'];
        // Time retorna quantos segundos vai durar o cookie,3600 dura 1h
        $duracao_password = time()+3600;
        // Poderia ser direto
        setcookie($nm_password,$valor_password,$duracao_password);
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['email'] = $email;
    if (empty($email) || empty($password)) {
        echo "Por favor, preencha todos os campos.";
        exit;
    }
    try {
        // Preparar e executar a consulta para verificar as credenciais
        $sql = "SELECT senha FROM aluno WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['senha'])) {
            // Se as credenciais forem válidas
            $_SESSION['email'] = $email;

            if (isset($_POST['btnCookie'])) {
                // Definir cookies se a opção "Manter conectado" estiver marcada
                setcookie('email', $email, time() + 3600); // 1 hora
                setcookie('password', $password, time() + 3600); // 1 hora
            }

            header("Location: inscricao.php");
            exit;
        } else {
            echo "E-mail ou senha incorretos.";
        }
    } catch (PDOException $e) {
        echo "Erro ao verificar as credenciais: " . $e->getMessage();
    }

}
?>
<?php 

?>