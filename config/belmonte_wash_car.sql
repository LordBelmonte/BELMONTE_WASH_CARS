-- phpMyAdmin SQL Dump
-- Banco de dados final para Belmonte Wash Car's

CREATE DATABASE IF NOT EXISTS `belmonte_wash_car` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `belmonte_wash_car`;

DROP TABLE IF EXISTS `agendamentos`;
DROP TABLE IF EXISTS `servicos`;
DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` enum('cliente','administrador') NOT NULL DEFAULT 'cliente',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `descricao` text DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `data_agendamento` date NOT NULL,
  `status_agendamento` enum('pendente','aprovado','concluido','cancelado') NOT NULL DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `servico_id` (`servico_id`),
  CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `agendamentos_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuarios` (`nome`, `email`, `telefone`, `senha`, `tipo_usuario`) VALUES
('Administrador', 'admin@belmonte.com', '11999990000', '$2y$10$v.XxZPJO0G.doC0PObKPmu/wITlWGsLSNSGEzH/gdmyIst0cTVjy6', 'administrador'),
('Cliente Teste', 'cliente@belmonte.com', '11988880000', '$2y$10$SwzkpTJ0els6hX0z4k1Yx.I1eiGucsabClOt3./uKHsSWyPiJcv3a', 'cliente');

INSERT INTO `servicos` (`nome`, `descricao`, `valor`) VALUES
('Lavagem Completa', 'Serviço completo de lavagem e higienização interna e externa.', 129.90),
('Higienização Interna', 'Limpeza interna profunda do veículo.', 89.90),
('Polimento e Enceramento', 'Polimento para remover riscos leves e proteção com cera.', 179.90);

