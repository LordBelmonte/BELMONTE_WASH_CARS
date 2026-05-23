<?php

require_once '../app/middleware/auth.php';
require_once '../app/controllers/Agendamento_Controller.php';

$controller = new AgendamentoController();

$action = $_GET['action'] ?? 'cancelar';
$id = $_GET['id'] ?? null;

if(!$id){
    header('Location: dashboard.php');
    exit;
}

switch($action){
    case 'aprovar':
        $controller->aprovar();
        break;
    case 'concluir':
        $controller->concluir();
        break;
    case 'cancelar':
    default:
        $controller->cancelar();
        break;
}
