# Bem vindo ao nosso Projeto "Test" — Sistema Laravel de "BahQEspetos"

Um sistema desenvolvido em **Laravel** com foco em simular a aplicação de uma página web no meio comercial, assim vendendo produtos, controlar pedidos e itens do cardápio, autenticar usuário, etc.  
Este projeto foi criado como parte do curso Técnico em Informática para Internet, oferecido pela Faculdade & Escola técnica QI, aplicando os conceitos de infraestrutura lógica, sistemas web e banco de dados.
---

## Instalação

### Pré-requisitos
-[PHP e Composer](# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'));
- [MySQL ou MariaDB](https://www.apachefriends.org/pt_br/index.html);
- [Node.js e NPM](https://nodejs.org/);

### Passos para rodar o projeto

```em PowerShell
# Clone este repositório
git clone https://github.com/valdemiroz/bahqespeto.git

# Acesse a pasta do projeto (digite o caminho, caso contrário, o código pode causar problemas)
cd c:/(caminho geral da pasta)/bahqespeto.git

# Instale as dependências do Laravel
composer install

# Crie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure o banco de dados no arquivo .env (insira estes dados)
# Exemplo:
# DB_DATABASE=sistema_login
# DB_USERNAME=root
# DB_PASSWORD=

# Rode as migrações
php artisan migrate

# Inicie o servidor local
php artisan serve

#Acesse a partir do link que o terminal indicar. ele deve aparecer assim:
"http://localhost:8000/" (Ctrl + Click do Mouse esq. para acesso rápido)
```
## Uso
Alguns dos recursos principais que esta página realiza são:

- Cadastro e Autenticação de clientes;
- Registro de pedidos (na área de admin e banco de dados);
- visualização dos dados inseridos do BD (pedidos, usuários e produtos) na área de admin;


## Sugestões de correção

Caso haja um conflito para abrir o projeto ou problemas dentro de tais arquivos cirados na pasta, contate conosco via E-mail [alissonsodregarcia@gmail.com], assim podendo ver o que podemos melhorar e agradeçemos desde já pelo apoio do desenvolvimento de nosso projeto.

## Autores

| Nome                            | Função        | Contato                                        |
| ------------------------------- | ------------- | ---------------------------------------------- |
| ChatGPT (IA)                    | Assistente    | [@google](https://chatgpt.com)                 |
| Alisson Davi                    | Desenvolvedor | [@AlissonDavi](https://github.com/valdemiroz)  |
| Matheus de Souza                | Desenvolvedor | [@MateusSouza]                                 |
| Jefferson                       | Desenvolvedor | [@Jefferson]                                   |
| Leonardo Abadi                  | Desenvolvedor | [@LeoAbadi]                                    |
| Agnaldo                         | Desenvolvedor | [@Agnaldo]                                     |

## Tecnologias Utilizadas

| Categoria          | Ferramenta                                                         |
| ------------------ | ------------------------------------------------------------------ |
| Backend            | **Laravel 10**, **PHP 8.2**                                        |
| Banco de Dados     | **MySQL / MariaDB**                                                |
| Frontend           | **Blade Templates**, **HTML5**, **CSS3**, **JavaScript**           |
| Estilo             | **CSS**                                                            |
| Controle de Versão | **Git / GitHub**                                                   |


