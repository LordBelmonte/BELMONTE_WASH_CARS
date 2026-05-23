<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<section class="hero">
    <div class="container hero-container">
        <div class="hero-content">
            <span class="hero-badge">Agendamento Automotivo</span>
            <h1>Seu carro merece um cuidado premium e fácil de agendar.</h1>
            <p>Sistema de agendamento do lava-rápido Belmonte Wash Car's. Clientes agendam lavagem e higienização, e a equipe do lava-rápido gerencia com agilidade e transparência.</p>
            <div class="hero-buttons">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <a href="dashboard.php" class="btn-primary">Meu Agendamento</a>
                    <a href="agendamento.php" class="btn-secondary">Agendar Serviço</a>
                <?php else: ?>
                    <a href="login-cadastro.php" class="btn-primary">Entrar</a>
                    <a href="login-cadastro.php" class="btn-secondary">Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-image">
            <img src="assets/img/banners/hero.jpg" alt="Agendamento de limpeza automotiva">
        </div>
    </div>
</section>