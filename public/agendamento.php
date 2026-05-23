<?php

require_once '../app/middleware/auth.php';
require_once '../app/controllers/Agendamento_Controller.php';
require_once '../app/services/Servico_Service.php';

if($_SESSION['usuario']['tipo_usuario'] !== 'cliente'){
    header('Location: dashboard.php');
    exit;
}

$controller = new AgendamentoController();
$controller->criar();

$servicoService = new ServicoService();
$servicos = $servicoService->listar();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Agendamento | Belmonte Wash Car's</title>
    <link rel="stylesheet" href="assets/css/base/reset.css">
    <link rel="stylesheet" href="assets/css/base/variables.css">
    <link rel="stylesheet" href="assets/css/base/global.css">
    <link rel="stylesheet" href="assets/css/pages/agendamento.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <section class="agendamento-page">
        <div class="agendamento-container">
            <div class="top">
                <div>
                    <h1>Novo Agendamento</h1>
                    <p>Agende o serviço ideal para o seu carro e acompanhe o status em tempo real.</p>
                </div>
                <a href="dashboard.php" class="btn-back">Voltar</a>
            </div>

            <?php if($mensagem): ?>
                <div class="form-alert"><?php echo htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>

            <form method="POST" class="agendamento-form">
                <div class="input-group">
                    <label>Serviço</label>
                    <select name="servico_id" required>
                        <option value="">Selecione um serviço</option>
                        <?php foreach($servicos as $servico): ?>
                            <option value="<?php echo $servico['id']; ?>"><?php echo htmlspecialchars($servico['nome']); ?> - R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="input-group">
                    <label>Data do agendamento</label>
                    <input type="date" name="data_agendamento" required>
                </div>

                <div class="input-group">
                    <label>Observações</label>
                    <textarea name="observacoes" rows="4" placeholder="Descreva detalhes adicionais"></textarea>
                </div>

                <button type="submit" class="btn-submit">Confirmar Agendamento</button>
            </form>
        </div>
    </section>
</body>

</html>