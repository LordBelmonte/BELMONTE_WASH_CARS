<?php

require_once '../app/middleware/auth.php';
require_once '../app/controllers/User_Controller.php';

$controller = new UserController();
$controller->processar();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
$usuario = $_SESSION['usuario'];

$primeiroNome = explode(' ', $usuario['nome'])[0];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | Belmonte Wash Car's</title>
    <link rel="stylesheet" href="assets/css/base/reset.css">
    <link rel="stylesheet" href="assets/css/base/variables.css">
    <link rel="stylesheet" href="assets/css/base/global.css">
    <link rel="stylesheet" href="assets/css/pages/perfil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <section class="perfil-page">
        <div class="perfil-header">
            <div class="perfil-title">
                <div class="avatar"><?php echo htmlspecialchars(mb_substr($primeiroNome, 0, 1)); ?></div>
                <div>
                    <h1>Meu Perfil</h1>
                    <p>Gerencie seus dados e segurança de acesso.</p>
                </div>
            </div>
            <div class="perfil-actions">
                <a href="dashboard.php" class="btn-secondary">Voltar ao Dashboard</a>
            </div>
        </div>

        <?php if($mensagem): ?>
            <div class="perfil-alert">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <div class="perfil-grid">
            <div class="perfil-card">
                <h2>Dados da Conta</h2>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
                <p><strong>Telefone:</strong> <?php echo htmlspecialchars($usuario['telefone']); ?></p>
                <p><strong>Tipo de usuário:</strong> <?php echo htmlspecialchars($usuario['tipo_usuario']); ?></p>
                <p><strong>Cadastro:</strong> <?php echo htmlspecialchars($usuario['data_criacao']); ?></p>
            </div>

            <div class="perfil-card">
                <h2>Atualizar Perfil</h2>
                <form method="POST">
                    <input type="hidden" name="acao" value="atualizar_perfil">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="<?php echo htmlspecialchars($usuario['telefone']); ?>">
                    <button type="submit" class="btn-submit">Atualizar Perfil</button>
                </form>
            </div>

            <div class="perfil-card">
                <h2>Alterar Senha</h2>
                <form method="POST">
                    <input type="hidden" name="acao" value="alterar_senha">
                    <label>Senha atual</label>
                    <input type="password" name="senha_atual" required>
                    <label>Nova senha</label>
                    <input type="password" name="senha_nova" required>
                    <label>Confirmar nova senha</label>
                    <input type="password" name="confirmar_senha" required>
                    <button type="submit" class="btn-submit">Alterar Senha</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>