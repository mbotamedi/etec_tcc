# Documentação do Projeto Cantina Três Irmãos

## Visão Geral do Projeto
O projeto "Cantina Três Irmãos" é um sistema web de e-commerce para uma cantina, que permite aos usuários visualizar produtos em promoção, realizar pedidos, gerenciar carrinho de compras e acessar áreas administrativas. O sistema possui funcionalidades de login, controle de estoque, e interface responsiva para facilitar o uso em diferentes dispositivos.

## Tecnologias Utilizadas
- PHP para a lógica do servidor e manipulação de dados.
- MariaDB para o banco de dados (base de dados: bd_cantina).
- HTML5, CSS3 e Bootstrap para o front-end responsivo.
- JavaScript para interatividade, controle do carrinho e modais.
- Fontes do Google Fonts e ícones do Bootstrap Icons e Font Awesome.

## Estrutura de Diretórios
- `php/`: Contém os arquivos PHP principais, incluindo páginas, controle de login, e componentes como navbar e footer.
- `admin/`: Área administrativa para gerenciamento de produtos, categorias, usuários e pedidos.
- `carrinho/`: Funcionalidades relacionadas ao carrinho de compras e finalização de pedidos.
- `includes/`: Arquivos de conexão com banco de dados e consultas SQL.
- `css/`: Arquivos de estilos CSS personalizados para diferentes partes do sistema.
- `js/`: Scripts JavaScript para funcionalidades diversas, como controle do carrinho e modais.
- `assets/` e `imgs/`: Imagens e ícones usados no site.

## Funcionalidades Principais
- **Página inicial** com carrossel de promoções e listagem de produtos em destaque.
- **Sistema de login** para clientes e administradores, com controle de acesso.
- **Carrinho de compras** com adição, remoção e alteração de quantidade de produtos.
- **Área administrativa** para gerenciamento de produtos, categorias, subcategorias, usuários e pedidos. (`DISPONÍVEL APENAS PARA USUÁRIOS ADMINISTRADORES`)
- **Consulta e exibição de produtos** com imagens, descrições, preços e estoque.
- **Finalização de pedidos** com cadastro de endereço e confirmação.
- **Envio de e-mails** para contato e suporte (arquivo `php/email.php`).

## Banco de Dados
- Banco: `bd_cantina`
- Principais tabelas:
  - `tb_produtos`: Armazena informações dos produtos, como descrição, preço, estoque e imagem.
  - `tb_usuarios`: Contém dados dos usuários do sistema, incluindo tipo (cliente ou administrador).
  - Outras tabelas relacionadas a categorias, subcategorias, pedidos e endereços.

## Como Instalar e Executar
1. Configure um servidor local com PHP e MySQL (ex: WAMP, XAMPP).
2. Importe o arquivo `bd_cantina.sql` para seu SGBD de sua preferência para criar o banco de dados e tabelas.
3. Ajuste as configurações de conexão no arquivo `includes/conexao.php` conforme seu ambiente.
4. Coloque os arquivos do projeto na pasta do servidor local (ex: `www/etec_tcc`).
5. Acesse o sistema via navegador pelo endereço configurado (ex: `http://localhost/etec_tcc`).
6. Faça login ou navegue como cliente para visualizar produtos e realizar pedidos.
