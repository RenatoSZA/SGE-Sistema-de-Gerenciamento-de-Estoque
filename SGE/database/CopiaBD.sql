-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/06/2026 às 00:57
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `laravel`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'warning',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `alerts`
--

INSERT INTO `alerts` (`id`, `message`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Produto Cadeira Ergonomica está com estoque baixo.', 'warning', '2026-06-12 02:35:54', '2026-06-12 02:35:54'),
(2, 'Funcionário Lucas Paz está atrasado.', 'danger', '2026-06-12 02:35:54', '2026-06-12 02:35:54'),
(3, 'Encomenda Samsung do setor TI chegou. Dirijam-se a area de descarregamento.', 'info', '2026-06-12 02:35:54', '2026-06-12 02:35:54');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_11_204512_add_matricula_to_users_table', 2),
(5, '2026_06_11_210703_add_employee_fields_to_users_table', 3),
(6, '2026_06_11_213441_create_products_table', 4),
(7, '2026_06_11_213442_add_schedule_to_users_table', 4),
(8, '2026_06_11_213442_create_alerts_table', 4),
(9, '2026_06_11_213442_create_stock_movements_table', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `sector` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `sector`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 'Cadeira Ergonomica', 'MaxOffice', 'Mobiliario', 15, '2026-06-12 02:35:53', '2026-06-12 02:35:53'),
(2, 'Notebook Dell', 'Dell', 'TI', 8, '2026-06-12 02:35:53', '2026-06-12 02:35:53'),
(3, 'Monitor 24', 'Samsung', 'TI', 12, '2026-06-12 02:35:53', '2026-06-12 02:35:53'),
(4, 'Mesa de Reuniao', 'WoodTech', 'Mobiliario', 2, '2026-06-12 02:35:53', '2026-06-12 02:35:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('74NJUC5srg8O9HncD1NA3sJq4ixPD1M0Om6kPrLR', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ1JxVVRhYVM3a0c1N1pIcFRSNW5vZkZxb1U5cHNraXJzcWp4WUNMUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZXR0aW5ncy9wcm9maWxlIjtzOjU6InJvdXRlIjtzOjE2OiJzZXR0aW5ncy5wcm9maWxlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9', 1781217706),
('qIYEzpQlZhRRaTokiUhLoqdD35RBeTt8cgqm0SID', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.123.1 Chrome/148.0.7778.97 Electron/42.2.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNllaVm5yNzBNVTlIRU83S2wxcXJROGlOam8xUGRNRndkNDU1TWcxZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMDoic2l0ZS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1781216753),
('StE9H9C7TBHLXkG3M8ciljS6wX4dig3ft7buKM9b', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWtHUGJNN3NCSDFmOVdxNmlBdW53RXZvaHZRekt5ZDJ0UGc1MW92YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zdXBvcnRlLXRlc3RlIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781217553);

-- --------------------------------------------------------

--
-- Estrutura para tabela `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity_changed` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `product_id`, `type`, `quantity_changed`, `created_at`, `updated_at`) VALUES
(1, 1, 'in', 10, '2026-06-12 02:25:53', '2026-06-12 02:35:53'),
(2, 2, 'out', 2, '2026-06-12 02:10:53', '2026-06-12 02:35:53'),
(3, 3, 'in', 5, '2026-06-12 01:35:53', '2026-06-12 02:35:53'),
(4, 4, 'out', 1, '2026-06-12 00:35:53', '2026-06-12 02:35:53'),
(5, 1, 'out', 3, '2026-06-11 23:35:53', '2026-06-12 02:35:53'),
(6, 2, 'in', 8, '2026-06-11 22:35:53', '2026-06-12 02:35:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `matricula` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `departamento` varchar(255) DEFAULT NULL,
  `nivel_acesso` enum('Funcionario','Gerente','Admin') NOT NULL DEFAULT 'Funcionario',
  `data_admissao` date DEFAULT NULL,
  `horario_entrada` varchar(255) DEFAULT '07:00',
  `horario_saida` varchar(255) DEFAULT '17:00',
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `matricula`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `cpf`, `departamento`, `nivel_acesso`, `data_admissao`, `horario_entrada`, `horario_saida`, `is_active`) VALUES
(2, 'A20260001', 'Renato Souza', 'renato@sge.com', NULL, '$2y$12$a2tbw5Y5GXharuYQidzpgeBoLVd4Y09N9mCXrnCkIeFEpsYsXl71m', NULL, '2026-06-12 02:21:38', '2026-06-12 02:21:38', '11111111111', 'TI', 'Admin', '2026-06-11', '07:00', '17:00', 1),
(3, 'F20260002', 'Daphinne Barros', 'daphinne@sge.com', NULL, '$2y$12$RjHQ/Io/PBwa7aXMnQvV1.7Z3DMWLBX66qeHi5ADUgjviD3tKJIb6', NULL, '2026-06-12 02:35:53', '2026-06-12 02:35:53', '33325290889', 'Operacoes', 'Funcionario', '2026-06-11', '08:00', '18:00', 1),
(4, 'F20260003', 'Maria Santa', 'maria@sge.com', NULL, '$2y$12$ygHA94SFFMLxJ37agDXZtu9SnzI0Ec2IN5Wfp/aV4PUJAt4MjkbPC', NULL, '2026-06-12 02:35:53', '2026-06-12 02:35:53', '43921056009', 'Operacoes', 'Funcionario', '2026-06-11', '09:00', '18:00', 0),
(5, 'G20260001', 'Aline Aguiar', 'alien@sge.com', NULL, '$2y$12$QrSCWXs2VVz2J4Ilu/rcHuTJ2ZEPTa0nl1Mw5UuzLrjz0tJIM5zl.', NULL, '2026-06-12 02:35:54', '2026-06-12 02:35:54', '23869367488', 'Operacoes', 'Gerente', '2026-06-11', '07:30', '17:30', 1),
(7, 'F20260005', 'Gabryel Santos', 'gabryel@sge.com', NULL, '$2y$12$Dz2eiqKi7GRmeZGW4Qw5.OPVpldeSePFPj8tnVHBeSaDesrdPHVmi', NULL, '2026-06-12 02:35:54', '2026-06-12 02:35:54', '17859614084', 'Operacoes', 'Funcionario', '2026-06-11', '06:00', '15:00', 0),
(8, 'G20260002', 'Hadassa Abele', 'hadassa@sge.com', NULL, '$2y$12$MjRe1lmzckwnPIBRghtUu.C2cmjVLwsCrZhzhPL.QgdG7RMnsy16y', NULL, '2026-06-12 02:47:05', '2026-06-12 02:47:05', '22222222222', 'TI', 'Gerente', '2026-06-11', '07:00', '17:00', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_movements_product_id_foreign` (`product_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_matricula_unique` (`matricula`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_cpf_unique` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
