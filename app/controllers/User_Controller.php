<?php

require_once __DIR__ . '/../services/User_Service.php';

class UserController {

    private $service;

    public function __construct(){
        $this->service = new UserService();
    }

    public function processar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return;
        }

        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $acao = $_POST['acao'] ?? '';

        if($acao === 'atualizar_perfil'){
            $this->atualizarPerfil();
        }

        if($acao === 'alterar_senha'){
            $this->alterarSenha();
        }
    }

    public function atualizarPerfil(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id = $_SESSION['usuario']['id'];
        $dados = [
            'nome' => trim($_POST['nome'] ?? ''),
            'telefone' => trim($_POST['telefone'] ?? '')
        ];

        if($this->service->atualizarPerfil($id, $dados)){
            $_SESSION['usuario']['nome'] = $dados['nome'];
            $_SESSION['usuario']['telefone'] = $dados['telefone'];
            $_SESSION['mensagem'] = 'Perfil atualizado com sucesso.';
        } else {
            $_SESSION['mensagem'] = 'Não foi possível atualizar o perfil.';
        }

        header('Location: perfil.php');
        exit;
    }

    public function alterarSenha(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id = $_SESSION['usuario']['id'];
        $senhaAtual = $_POST['senha_atual'] ?? '';
        $senhaNova = $_POST['senha_nova'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        if($senhaNova !== $confirmarSenha){
            $_SESSION['mensagem'] = 'A nova senha e a confirmação devem ser iguais.';
            header('Location: perfil.php');
            exit;
        }

        if(empty($senhaAtual) || empty($senhaNova)){
            $_SESSION['mensagem'] = 'Preencha os campos de senha.';
            header('Location: perfil.php');
            exit;
        }

        if($this->service->alterarSenha($id, $senhaAtual, $senhaNova)){
            $_SESSION['mensagem'] = 'Senha alterada com sucesso.';
        } else {
            $_SESSION['mensagem'] = 'Senha atual inválida.';
        }

        header('Location: perfil.php');
        exit;
    }

    public function obterUsuario($id){
        return $this->service->obterPorId($id);
    }

}