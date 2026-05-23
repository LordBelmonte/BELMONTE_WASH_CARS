<?php

require_once __DIR__ . '/../models/Usuario.php';

class UserService {

    private $usuario;

    public function __construct(){
        $this->usuario = new Usuario();
    }

    public function obterPorId($id){
        return $this->usuario->buscarPorId($id);
    }

    public function atualizarPerfil($id, $dados){
        return $this->usuario->atualizar($id, $dados);
    }

    public function alterarSenha($id, $senhaAtual, $senhaNova){
        if(!$this->usuario->validarSenha($id, $senhaAtual)){
            return false;
        }

        return $this->usuario->alterarSenha($id, $senhaNova);
    }

}