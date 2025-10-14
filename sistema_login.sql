-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14/10/2025 às 13:48
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
-- Banco de dados: `sistema_login`
--

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
(4, '2025_10_07_051808_add_telefone_endereco_to_users_table', 2);

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
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `itens` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `forma_pagamento` varchar(50) NOT NULL,
  `pago` tinyint(1) DEFAULT 0,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor_pago` decimal(10,2) DEFAULT 0.00,
  `troco` decimal(10,2) DEFAULT 0.00,
  `endereco` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(8,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) NOT NULL DEFAULT 'espetos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `imagem`, `categoria`) VALUES
(1, 'Beira-rio', 'Espeto de filet mignon suíno com tiras de bacon e geleia de pimenta.', 18.00, 'Beira-Rio.png', 'espetos'),
(2, 'Laçador', 'Espeto de cubos de picanha com queijo coalho (acompanha farofa e maionese).', 25.00, 'lacador.webp', 'espetos'),
(3, 'Tricolor', 'Espeto de linguiça uruguaia com cubos de frango e chimichurri.', 20.00, 'Tricolor.png', 'espetos'),
(4, 'Gurizinho', 'Espeto de carne simples', 10.00, 'gurizinho.jpg', 'espetos'),
(5, 'Cidade Baixa', 'Cubos de alcatra à milanesa (acompanha farofa e maionese).', 22.00, 'Cidade-Baixa.jpg', 'espetos'),
(6, 'Moinhos', 'Espeto de carne, queijo provolone e bacon (acompanha farofa e maionese).', 20.00, 'Moinhos.png', 'espetos'),
(7, 'Farrapos', 'Espeto de cubos de frango com linguiça, calabresa e pimentões veremlhos (acompanha farofa e maionese).', 18.00, 'Farrapos.png', 'espetos'),
(8, 'Guaíba', 'Cubos de tilápia com pimentões amarelos (acompanha farofa e maionese).', 25.00, 'guaiba.jpg', 'espetos'),
(9, 'Chinelão', 'Espeto completo de carne, frango, mignon suíno e bacon, coberto com molho barbecue (acompanha farofa e maionese).', 30.00, 'chinelão.jpg', 'espetos'),
(10, 'Água', 'Garrafa de água mineral gelada.', 5.00, 'água-mineral.jpg', 'bebidas'),
(11, 'Cerveja', 'Cerveja artesanal feita pela casa.', 15.00, 'cerveja-artesanal.jpg', 'bebidas'),
(12, 'Refrigerante em lata', 'Lata de refrigerante gelado.', 9.00, 'refri-lata.png', 'bebidas'),
(13, 'Heineken', 'Cerveja promocional da empresa.', 13.00, 'heineken.webp', 'bebidas'),
(14, 'Batatas fritas', 'Porção crocante de batatas.', 15.00, 'batata-frita.jpg', 'acompanhamentos'),
(15, 'Pão de alho', 'Pão de alho assado com queijo (vem em 8 unidades).', 16.00, 'pão-de-alho.jpg', 'acompanhamentos'),
(16, 'Pão de queijo', 'Porção de pães de queijo quentinhos (vem em 16 unidades).', 17.00, 'pão-de-queijo.jpg', 'acompanhamentos'),
(17, 'Suco natural', 'Suco natural de frutas (sabores variados, 500ml).', 15.00, 'suco-natural.jpg', 'bebidas');

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
('CriCXwEgIOSEy1IHt2Z3wxbHaEd4dXFqgwfBMpV9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1FmcW5TSGo5WHdYNmRtS0Foem01NzBKNHo2M25YcFBqWGd3UzVQNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760319280),
('OEfyEXJgJ3poQeCeLOW9MaU3562jmUtv9W3YwP8J', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiemJCMldMWmVTMXVQcTdkREpFM0RSSU5YUVlIc25WOFB1SlJmNFFJbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjg7fQ==', 1760317054),
('wyaJlGP7bJvh9pFRj2A7LBY1j4TZ5pvx7pER6e1e', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMzY2UWpDa3RnckhkclhKMW9oZGU1YUlXbEtrUmF3Qml6anpzc1djOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c3VhcmlvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9', 1760438482);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `telefone` varchar(255) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `senha`, `criado_em`, `telefone`, `endereco`, `foto`) VALUES
(8, 'Alisson Davi', 'alissonsodregarcia@gmail.com', '$2y$10$N.iK54XRMorHqYlhkcU14OeSZKJWU86usRxwWQ8bUVjGr2pbJxlEy', '2025-09-16 00:06:16', '51991628190', 'Rua Jesus Operário 85', 'img/usuarios/user_8_1760438479.png'),
(10, 'ana maria', 'anasim@gmail.com', '$2y$10$RW87GPi9pQEL3Kx.VZnGHeJruTMRlaaybLa410fHj.zzJ9sQ0eAFq', '2025-09-25 14:28:04', '55991820340', 'Rua Jesus Operário', NULL),
(11, 'Victor Roqueiro', 'victouwu@gmail.com', '$2y$12$sAVLHCor.synTI9a4gcMeOOquwMdabYZczVB5nJnC5cGdUQa9rJnS', '2025-10-07 02:28:23', '51991628191', 'Rua Florianópolis 3172', 'img/usuarios/user_11_1759851439.png');

--
-- Índices para tabelas despejadas
--

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
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
