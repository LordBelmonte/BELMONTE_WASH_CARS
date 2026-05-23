<?php

require_once __DIR__ . '/../services/Auth_Service.php';

class AuthController {

    private $service;

    public function __construct(){
        $this->service = new AuthService();
    }

    public function processar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $acao = $_POST['acao'] ?? '';

            if($acao === 'login'){
                $this->login();
            }

            if($acao === 'cadastro'){
                $this->cadastro();
            }
        }
    }

    private function login(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        $usuario = $this->service->login($email, $senha);

        if($usuario){
            session_regenerate_id(true);
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email'],
                'telefone' => $usuario['telefone'],
                'tipo_usuario' => $usuario['tipo_usuario'],
                'data_criacao' => $usuario['data_criacao'] ?? null
            ];

            header('Location: dashboard.php');
            exit;
        }

        $_SESSION['mensagem'] = 'E-mail ou senha inválidos.';
        header('Location: login-cadastro.php');
        exit;
    }

    private function cadastro(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        if($senha !== $confirmarSenha){
            $_SESSION['mensagem'] = 'As senhas não conferem.';
            header('Location: login-cadastro.php');
            exit;
        }

        if(empty($nome) || empty($email) || empty($senha)){
            $_SESSION['mensagem'] = 'Preencha todos os campos obrigatórios.';
            header('Location: login-cadastro.php');
            exit;
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'senha' => $senha,
            'tipo_usuario' => 'cliente'
        ];

        if(!$this->service->cadastrar($dados)){
            $_SESSION['mensagem'] = 'E-mail já cadastrado ou inválido.';
            header('Location: login-cadastro.php');
            exit;
        }

        $_SESSION['mensagem'] = 'Conta criada com sucesso. Faça login.';
        header('Location: login-cadastro.php');
        exit;
    }

}
