-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 13/10/2024 às 01:43
-- Versão do servidor: 8.0.30
-- Versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `invictos`
--
CREATE DATABASE IF NOT EXISTS `invictos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `invictos`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(64) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `level` int NOT NULL,
  `deleted` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `level`, `deleted`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'admin@admin', 'Usuário Administrador', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 2, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'usuario@usuario', 'Usuario Comum', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'inativo@inativo', 'Usuário Inativo', 'aefdde27979f6c25eff519ea4623b5ff21fd143dc9b0943e122de0a53ac9fdbd', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'deletado@deletado', 'Usuario Deletado', '8a1491af3660be97f687a85ef8aace49723987219a75febeb3a0673a99e2def0', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'elionars@gmail.com', 'Elionardo S Santos', 'c60df4beb6ded3fb6616d30cb83075933d20f8e5141227b6853ed4e93ab94379', 0, 1, 1, '2024-10-12 20:58:46', NULL, NULL, NULL, NULL),
(36, 'elionars@gmail.com', 'Elionardo S Santos', 'ac8f355d0a1b1a561f96273d3f730fd2563d9e1a17e5644391aa0651d28c2196', 2, 0, 1, '2024-10-12 18:07:00', NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
