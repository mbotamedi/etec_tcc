<?php
// File: config.php
// Description: Configurações essenciais para a API do PagSeguro e banco de dados.

// -- CONFIGURAÇÕES DO PAGSEGURO --
// Troque para 'https://api.pagseguro.com' em ambiente de produção.
define('PAGSEGURO_URL', 'https://sandbox.api.pagseguro.com'); 

// Insira seu token de autenticação do PagSeguro aqui.
// Em produção, use um token gerado na sua conta de produção.
// IMPORTANTE: Mantenha seu token seguro e nunca o exponha no lado do cliente (JavaScript, HTML).
define('PAGSEGURO_TOKEN', '672721cb-6ad2-417f-9241-5565770ec91d182eba2e4d51b57015821ce796870f93dad6-71f2-420c-bdf6-e369fc173496'); 

// --- CORREÇÃO IMPORTANTE ABAIXO ---
// A URL de notificação DEVE incluir o nome da pasta do seu projeto.
// Substitua a URL do Ngrok abaixo pela sua URL atual toda vez que iniciá-lo.
define('PAGSEGURO_NOTIFICATION_URL', 'https://4a02-2804-14d-8470-8151-c0e5-5f9d-d572-ca6d.ngrok-free.app/etec_tcc/pgseguro/notificacao.php');

// -- CONFIGURAÇÕES DO BANCO DE DADOS (Não são mais usadas aqui, mas mantidas por segurança) --
//define('DB_HOST', 'sql306.infinityfree.com');
//define('DB_NAME', 'if0_39209106_pgseguroteste');
//define('DB_USER', 'if0_39209106');
//define('DB_PASS', 'UxMUUjhkL1P0i');

// SQL para criar a tabela de pedidos, caso ainda não exista.
/*
CREATE TABLE `tb_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedidos` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `response_data` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_pedidos` (`id_pedidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
*/
?>
