<?php

require_once __DIR__ . '/../models/Agendamento.php';

class AgendamentoService {

    private $model;

    public function __construct(){
        $this->model = new Agendamento();
    }

    public function criar($dados){
        return $this->model->criar($dados);
    }

    public function listar($usuarioId){
        return $this->model->listarPorUsuario($usuarioId);
    }

    public function listarTodos(){
        return $this->model->listarTodos();
    }

    public function pertenceAoUsuario($id, $usuarioId){
        return $this->model->pertenceAoUsuario($id, $usuarioId);
    }

    public function alterarStatus($id, $status){
        return $this->model->alterarStatus($id, $status);
    }

    public function cancelar($id){
        return $this->alterarStatus($id, 'cancelado');
    }

    public function totalAgendamentos($usuarioId){
        return $this->model->totalAgendamentos($usuarioId);
    }

    public function totalPendentes($usuarioId){
        return $this->model->totalPendentes($usuarioId);
    }

    public function totalAprovados($usuarioId){
        return $this->model->totalAprovados($usuarioId);
    }

    public function totalConcluidos($usuarioId){
        return $this->model->totalConcluidos($usuarioId);
    }

    public function totalCancelados($usuarioId){
        return $this->model->totalCancelados($usuarioId);
    }

    public function totalAgendamentosTodos(){
        return $this->model->totalAgendamentosTodos();
    }

    public function totalPendentesTodos(){
        return $this->model->totalPendentesTodos();
    }

    public function totalAprovadosTodos(){
        return $this->model->totalAprovadosTodos();
    }

    public function totalConcluidosTodos(){
        return $this->model->totalConcluidosTodos();
    }

    public function totalCanceladosTodos(){
        return $this->model->totalCanceladosTodos();
    }

}