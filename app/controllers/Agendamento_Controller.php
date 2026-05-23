<?php

require_once __DIR__ . '/../services/Agendamento_Service.php';
require_once __DIR__ . '/../services/Servico_Service.php';

class AgendamentoController {

    private $service;
    private $servicoService;

    public function __construct(){
        $this->service = new AgendamentoService();
        $this->servicoService = new ServicoService();
    }

    public function criar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return;
        }

        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if($_SESSION['usuario']['tipo_usuario'] !== 'cliente'){
            header('Location: dashboard.php');
            exit;
        }

        $dados = [
            'usuario_id' => $_SESSION['usuario']['id'],
            'servico_id' => $_POST['servico_id'] ?? null,
            'data_agendamento' => $_POST['data_agendamento'] ?? null,
            'observacoes' => trim($_POST['observacoes'] ?? '')
        ];

        if(
            empty($dados['servico_id']) ||
            empty($dados['data_agendamento']) ||
            !$this->servicoService->obterPorId($dados['servico_id'])
        ){
            $_SESSION['mensagem'] = 'Selecione um serviço válido e informe a data do agendamento.';
            header('Location: agendamento.php');
            exit;
        }

        if($this->service->criar($dados)){
            $_SESSION['mensagem'] = 'Agendamento criado com sucesso. Aguarde aprovação.';
        } else {
            $_SESSION['mensagem'] = 'Não foi possível criar o agendamento.';
        }

        header('Location: dashboard.php');
        exit;
    }

    public function listar(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if($_SESSION['usuario']['tipo_usuario'] === 'administrador'){
            return $this->service->listarTodos();
        }

        return $this->service->listar($_SESSION['usuario']['id']);
    }

    public function alterarStatus($id, $status){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $usuario = $_SESSION['usuario'];

        if(in_array($status, ['aprovado', 'concluido'], true)){
            if($usuario['tipo_usuario'] !== 'administrador'){
                header('Location: dashboard.php');
                exit;
            }
        }

        if($status === 'cancelado'){
            if($usuario['tipo_usuario'] !== 'administrador'){
                if(!$this->service->pertenceAoUsuario($id, $usuario['id'])){
                    header('Location: dashboard.php');
                    exit;
                }
            }
        }

        $this->service->alterarStatus($id, $status);
    }

    public function aprovar(){
        if(isset($_GET['id'])){
            $this->alterarStatus($_GET['id'], 'aprovado');
        }

        header('Location: dashboard.php');
        exit;
    }

    public function concluir(){
        if(isset($_GET['id'])){
            $this->alterarStatus($_GET['id'], 'concluido');
        }

        header('Location: dashboard.php');
        exit;
    }

    public function cancelar(){
        if(isset($_GET['id'])){
            $this->alterarStatus($_GET['id'], 'cancelado');
        }

        header('Location: dashboard.php');
        exit;
    }

    public function estatisticas(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if($_SESSION['usuario']['tipo_usuario'] === 'administrador'){
            return [
                'total' => $this->service->totalAgendamentosTodos(),
                'pendentes' => $this->service->totalPendentesTodos(),
                'aprovados' => $this->service->totalAprovadosTodos(),
                'concluidos' => $this->service->totalConcluidosTodos(),
                'cancelados' => $this->service->totalCanceladosTodos()
            ];
        }

        $usuarioId = $_SESSION['usuario']['id'];

        return [
            'total' => $this->service->totalAgendamentos($usuarioId),
            'pendentes' => $this->service->totalPendentes($usuarioId),
            'concluidos' => $this->service->totalConcluidos($usuarioId),
            'cancelados' => $this->service->totalCancelados($usuarioId)
        ];
    }

}