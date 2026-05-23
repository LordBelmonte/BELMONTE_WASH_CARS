<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belmonte Wash Car's</title>
    <link rel="stylesheet" href="assets/css/base/reset.css">
    <link rel="stylesheet" href="assets/css/base/variables.css">
    <link rel="stylesheet" href="assets/css/base/global.css">
    <link rel="stylesheet" href="assets/css/layout/container.css">
    <link rel="stylesheet" href="assets/css/components/navbar.css">
    <link rel="stylesheet" href="assets/css/pages/hero.css">
    <link rel="stylesheet" href="assets/css/pages/home.css">
</head>

<body>
    <?php include 'components/header.php'; ?>
    <?php include 'components/hero.php'; ?>
    <?php include 'components/cta.php'; ?>
    <?php include 'components/contact.php'; ?>
    <?php include 'components/footer.php'; ?>
</body>
</html>