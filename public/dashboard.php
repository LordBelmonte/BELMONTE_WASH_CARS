<?php

require_once '../app/middleware/auth.php';
require_once '../app/controllers/Agendamento_Controller.php';

$agendamentoController = new AgendamentoController();
$agendamentos = $agendamentoController->listar();
$estatisticas = $agendamentoController->estatisticas();
$usuario = $_SESSION['usuario'];

function criarLinkWhatsApp($telefone){
    $telefoneLimpo = preg_replace('/\D+/', '', $telefone);
    return 'https://wa.me/55' . $telefoneLimpo;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        Dashboard | Belmonte Wash Car's
    </title>

    <!-- CSS -->

    <link
    rel="stylesheet"
    href="assets/css/base/reset.css">

    <link
    rel="stylesheet"
    href="assets/css/base/variables.css">

    <link
    rel="stylesheet"
    href="assets/css/base/global.css">

    <link
    rel="stylesheet"
    href="assets/css/layout/container.css">

    <link
    rel="stylesheet"
    href="assets/css/pages/dashboard.css">

    <!-- GOOGLE -->

    <link
    rel="preconnect"
    href="https://fonts.googleapis.com">

    <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

</head>

<body>

    <section class="dashboard">

        <!-- SIDEBAR -->

        <aside class="sidebar">

            <div class="logo">

                <h2>
                    Belmonte
                </h2>

            </div>

            <nav class="sidebar-menu">
                <a href="index.php">Home</a>
                <a href="dashboard.php">Dashboard</a>
                <?php if($usuario['tipo_usuario'] === 'cliente'): ?>
                    <a href="agendamento.php">Novo Agendamento</a>
                <?php endif; ?>
                <a href="perfil.php">Perfil</a>
                <a href="logout.php">Sair</a>
            </nav>

        </aside>

        <!-- CONTENT -->

        <main class="dashboard-content">

            <!-- TOPBAR -->

            <header class="topbar">

                <div>

                    <h1>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?></h1>

                    <p>

                        Gerencie seus agendamentos
                        e acompanhe seus serviços.

                    </p>

                </div>

            </header>

            <!-- CARDS -->

            <div class="dashboard-cards">
                <div class="card">
                    <h3><?php echo $usuario['tipo_usuario'] === 'administrador' ? 'Total de Agendamentos' : 'Meus Agendamentos'; ?></h3>
                    <strong><?php echo $estatisticas['total']['total']; ?></strong>
                </div>
                <div class="card">
                    <h3>Pendentes</h3>
                    <strong><?php echo $estatisticas['pendentes']['total']; ?></strong>
                </div>
                <?php if($usuario['tipo_usuario'] === 'administrador'): ?>
                    <div class="card">
                        <h3>Aprovados</h3>
                        <strong><?php echo $estatisticas['aprovados']['total']; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <h3>Concluídos</h3>
                    <strong><?php echo $estatisticas['concluidos']['total']; ?></strong>
                </div>
                <div class="card">
                    <h3>Cancelados</h3>
                    <strong><?php echo $estatisticas['cancelados']['total']; ?></strong>
                </div>
            </div>

            <!-- TABLE -->

            <div class="table-container">

                <div class="table-header">

                    <h2>Últimos Agendamentos</h2>

                    <?php if($usuario['tipo_usuario'] === 'cliente'): ?>
                        <a href="agendamento.php">Novo Agendamento</a>
                    <?php endif; ?>

                </div>

                <table>
                    <thead>
                        <tr>
                            <?php if($usuario['tipo_usuario'] === 'administrador'): ?>
                                <th>Cliente</th>
                                <th>Telefone</th>
                            <?php endif; ?>
                            <th>Serviço</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($agendamentos)): ?>
                            <tr>
                                <td colspan="<?php echo $usuario['tipo_usuario'] === 'administrador' ? 6 : 4; ?>">Nenhum agendamento encontrado.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach($agendamentos as $agendamento): ?>
                            <tr>
                                <?php if($usuario['tipo_usuario'] === 'administrador'): ?>
                                    <td><?php echo htmlspecialchars($agendamento['usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($agendamento['telefone']); ?></td>
                                <?php endif; ?>
                                <td><?php echo htmlspecialchars($agendamento['servico']); ?></td>
                                <td><?php echo htmlspecialchars($agendamento['data_agendamento']); ?></td>
                                <td><span class="status <?php echo strtolower($agendamento['status_agendamento']); ?>"><?php echo htmlspecialchars($agendamento['status_agendamento']); ?></span></td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if($usuario['tipo_usuario'] === 'administrador'): ?>
                                            <?php if($agendamento['status_agendamento'] === 'pendente'): ?>
                                                <a class="btn-action btn-approve" href="cancelar-agendamento.php?id=<?php echo $agendamento['id']; ?>&action=aprovar">Aprovar</a>
                                            <?php endif; ?>
                                            <?php if($agendamento['status_agendamento'] === 'aprovado'): ?>
                                                <a class="btn-action btn-complete" href="cancelar-agendamento.php?id=<?php echo $agendamento['id']; ?>&action=concluir">Concluir</a>
                                            <?php endif; ?>
                                            <?php if($agendamento['status_agendamento'] !== 'cancelado' && $agendamento['status_agendamento'] !== 'concluido'): ?>
                                                <a class="btn-action btn-cancel" href="cancelar-agendamento.php?id=<?php echo $agendamento['id']; ?>&action=cancelar">Cancelar</a>
                                            <?php endif; ?>
                                            <a class="btn-action btn-whatsapp" href="<?php echo criarLinkWhatsApp($agendamento['telefone']); ?>" target="_blank">WhatsApp</a>
                                        <?php else: ?>
                                            <?php if($agendamento['status_agendamento'] !== 'cancelado' && $agendamento['status_agendamento'] !== 'concluido'): ?>
                                                <a class="btn-action btn-cancel" href="cancelar-agendamento.php?id=<?php echo $agendamento['id']; ?>&action=cancelar">Cancelar</a>
                                            <?php else: ?>
                                                <span class="no-action">-</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </section>
</body>
</html>