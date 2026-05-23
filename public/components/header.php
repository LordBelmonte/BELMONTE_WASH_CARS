<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<header class="header">
    <div class="container header-container">
        <div class="logo">
            <a href="index.php">
                <img src="assets/img/logo.png" alt="Belmonte Wash Car's">
            </a>
        </div>

        <nav class="menu">
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="index.php#servicos">Serviços</a></li>
                <li><a href="index.php#contato">Contato</a></li>
            </ul>
        </nav>

        <div class="header-buttons">
            <?php if(isset($_SESSION['usuario'])): ?>
                <?php $primeiroNome = explode(' ', $_SESSION['usuario']['nome'])[0]; ?>
                <span class="usuario-logado">Olá, <?php echo htmlspecialchars($primeiroNome); ?></span>
                <a href="dashboard.php" class="btn-login">Dashboard</a>
                <a href="perfil.php" class="btn-secondary">Perfil</a>
                <a href="logout.php" class="btn-secondary">Sair</a>
            <?php else: ?>
                <a href="login-cadastro.php" class="btn-login">Entrar</a>
                <a href="login-cadastro.php" class="btn-secondary">Cadastrar</a>
            <?php endif; ?>
        </div>
    </div>
</header>