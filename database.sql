-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22/11/2024 às 02:11
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
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int AUTOINCREMENT NOT NULL,
  `codigo` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `titulo` varchar(256) DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `tipo_consumo` varchar(64) DEFAULT NULL,
  `multiplicador` float DEFAULT NULL,
  `altura_minima_porta` float DEFAULT NULL,
  `altura_maxima_porta` float DEFAULT NULL,
  `largura_minima_porta` float DEFAULT NULL,
  `largura_maxima_porta` float DEFAULT NULL,
  `peso_minimo_porta` float DEFAULT NULL,
  `peso_maximo_porta` float DEFAULT NULL,
  `selecionado` tinyint(1) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `codigo`, `titulo`, `peso`, `consumo`, `multiplicador`, `altura_minima_porta`, `altura_maxima_porta`, `largura_minima_porta`, `largura_maxima_porta`, `peso_minimo_porta`, `peso_maximo_porta`, `selecionado`, `deleted`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(9, '44', 'PERFIL INVICTOS 75 ALTO 24 FECHADA', 8, 'm2', 1, 0, 0, 0, 0, 0, 0, 0, 0, 5, '2024-11-20 12:25:10', 5, '2024-11-21 19:44:56', NULL, NULL),
(10, '22', '', 0, 'altura', 2, 0, 0, 0, 0, 0, 0, 0, 0, 5, '2024-11-20 13:36:08', 5, '2024-11-21 19:43:45', NULL, NULL),
(13, '36', 'EIXO 114,3MM', 3, 'largura', 1, 0, 0, 0, 0, 0, 0, 1, 0, 5, '2024-11-21 22:28:22', 5, '2024-11-21 23:10:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL AUTOINCREMENT,
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
(2, 'usuario@usuario', 'Usuario Comum', '9250e222c4c71f0c58d4c54b50a880a312e9f9fed55d5c3aa0b0e860ded99165', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'inativo@inativo', 'Usuário Inativo', 'aefdde27979f6c25eff519ea4623b5ff21fd143dc9b0943e122de0a53ac9fdbd', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'deletado@deletado', 'Usuario Deletado', '8a1491af3660be97f687a85ef8aace49723987219a75febeb3a0673a99e2def0', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'elionars@gmail.com', 'Elionardo S Santos', 'ac8f355d0a1b1a561f96273d3f730fd2563d9e1a17e5644391aa0651d28c2196', 2, 0, 1, '2024-10-12 20:58:46', NULL, NULL, NULL, NULL),
(39, 'cristiano@invictos', 'Cristiano', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 2, 0, 5, '2024-11-02 09:25:49', NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
