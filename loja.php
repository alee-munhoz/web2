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

$api_url = 'https://fakestoreapi.com/products';

$ch = curl_init($api_url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);
$products = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos da Fake Store API</title>
    <link rel="stylesheet" href="loja.css">

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
                <a href="loja.php">Loja</a>
            </div>
        </div>
        <form action="logout.php"><button>Sair</button></form>
    </div>
        
    </header>
    <div class="container">
        <h1>Produtos da Fake Store API</h1>

        <?php if (is_array($products) && count($products) > 0): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                        <h2><?php echo htmlspecialchars($product['title']); ?></h2>
                        <p>Preço: $<?php echo number_format($product['price'], 2); ?></p>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Não foi possível carregar os produtos.</p>
        <?php endif; ?>
    </div>
</body>
</html>
