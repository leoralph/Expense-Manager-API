# Expense Manager API

Guia de configuração:

1. Clone o projeto utilizado o comando `git clone https://github.com/leoralph/Expense-Manager-API`
2. Entre na pasta do projeto e instale as dependencias utilizando o comando `composer install`
3. Crie uma cópia do arquivo .env.example para somente .env
4. Gere a chave de criptografia do projeto utilizando o comando `php artisan key:generate`
5. Dentro do arquivo .env, inclua as informações nesessárias para se conectar ao banco de dados
6. Inclua também o dominio utilizado pelo frontend na configuração `SANCTUM_STATEFUL_DOMAINS` (não é necessário caso esteja utilizando algum dos dominios que estão incluídos no arquivo `config/sanctum.php`)
7. Utilize o comando `php artisan serve`, isso irá rodar o projeto na porte 8000 por padrão, mas pode ser customizado utilizando a opção `--port`

Testes:

- Os testes do projeto foram feitos com o framework [PestPHP](https://pestphp.com/)
