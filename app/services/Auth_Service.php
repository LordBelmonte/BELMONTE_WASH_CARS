<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthService {

    private $usuario;

    public function __construct(){
        $this->usuario = new Usuario();
    }

    public function cadastrar($dados){
        if($this->usuario->buscarPorEmail($dados['email'])){
            return false;
        }

        $dados['tipo_usuario'] = 'cliente';

        return $this->usuario->cadastrar($dados);
    }

    public function login($email, $senha){
        $usuario = $this->usuario->buscarPorEmail($email);

        if(
            $usuario &&
            password_verify($senha, $usuario['senha'])
        ){
            return $usuario;
        }

        return false;
    }

}