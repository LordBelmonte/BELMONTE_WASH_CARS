<?php

require_once __DIR__ . '/../models/Servico.php';

class ServicoService {

    private $model;

    public function __construct(){
        $this->model = new Servico();
    }

    public function listar(){
        return $this->model->listar();
    }

    public function obterPorId($id){
        return $this->model->buscarPorId($id);
    }

}
