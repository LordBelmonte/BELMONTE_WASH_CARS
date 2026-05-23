<?php

session_start();

require_once '../app/controllers/Auth_Controller.php';

if(isset($_SESSION['usuario'])){
    header('Location: dashboard.php');
    exit;
}

$controller = new AuthController();
$controller->processar();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Belmonte Wash Car's</title>
    <link rel="stylesheet" href="assets/css/base/reset.css">
    <link rel="stylesheet" href="assets/css/base/variables.css">
    <link rel="stylesheet" href="assets/css/base/global.css">
    <link rel="stylesheet" href="assets/css/components/buttons.css">
    <link rel="stylesheet" href="assets/css/pages/login-cadastro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <section class="login-container">
        <div class="login-left">
            <div class="overlay"></div>
            <div class="left-content">
                <a href="index.php">
                    <img src="assets/img/logo.png" alt="Logo Belmonte">
                </a>
                <h1>Belmonte Wash Car's</h1>
                <p>Agende a lavagem do seu carro no lava-rápido Belmonte Wash Car's de forma rápida e segura.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="form-container glass">
                <?php if($mensagem): ?>
                    <div class="form-alert"><?php echo htmlspecialchars($mensagem); ?></div>
                <?php endif; ?>

                <div class="tabs">
                    <button type="button" class="tab active">Entrar</button>
                    <button type="button" class="tab">Cadastrar</button>
                </div>

                <form class="login-form" method="POST">
                    <input type="hidden" name="acao" value="login">
                    <h2>Entrar na plataforma</h2>
                    <div class="input-group">
                        <label>E-mail</label>
                        <input type="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="input-group">
                        <label>Senha</label>
                        <input type="password" name="senha" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn-login">Entrar</button>
                </form>

                <form class="register-form" method="POST">
                    <input type="hidden" name="acao" value="cadastro">
                    <h2>Criar conta</h2>
                    <div class="input-group">
                        <label>Nome Completo</label>
                        <input type="text" name="nome" placeholder="Digite seu nome" required>
                    </div>
                    <div class="input-group">
                        <label>E-mail</label>
                        <input type="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="input-group">
                        <label>Telefone</label>
                        <input type="text" name="telefone" placeholder="(11) 99999-9999">
                    </div>
                    <div class="input-group">
                        <label>Senha</label>
                        <input type="password" name="senha" placeholder="Crie uma senha" required>
                    </div>
                    <div class="input-group">
                        <label>Confirmar Senha</label>
                        <input type="password" name="confirmar_senha" placeholder="Confirme sua senha" required>
                    </div>
                    <button type="submit" class="btn-register">Criar Conta</button>
                </form>
            </div>
        </div>
    </section>

    <script src="assets/js/login-cadastro.js"></script>
</body>
</html>