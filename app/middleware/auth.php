<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['usuario'])){
    header('Location: login-cadastro.php');
    exit;
}
