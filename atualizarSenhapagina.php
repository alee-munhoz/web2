<?php
session_start();
require 'conexao.php';


if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}


$emailSessao = $_SESSION['email'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
    <link rel="stylesheet" href="style_mconta.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-top: 0;
            color: #333;
        }
        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <header>
        <h1>Área do candidato</h1>
        <div class="user-menu">
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

    <div class="form-container">
        <h2>Alterar Senha</h2>
        <form action="updateSenha.php" method="post">
            <label for="senhaAtual">Senha Atual</label>
            <input type="password" id="senhaAtual" name="senhaAtual" required>

            <label for="novaSenha">Nova Senha</label>
            <input type="password" id="novaSenha" name="novaSenha" required>

            <label for="confirmaSenha">Confirmar Nova Senha</label>
            <input type="password" id="confirmaSenha" name="confirmaSenha" required>

            <input type="submit" value="Atualizar Senha">
        </form>
    </div>
</body>
</html>