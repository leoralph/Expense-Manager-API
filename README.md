# Expense Manager API

Guia de configuração:

1. Clone o projeto utilizado o comando `git clone https://github.com/leoralph/Expense-Manager-API`
2. Entre na pasta do projeto e instale as dependencias utilizando o comando `composer install`
3. Crie uma cópia do arquivo .env.example para somente .env
4. Gere a chave de criptografia do projeto utilizando o comando `php artisan key:generate`
5. Dentro do arquivo .env, inclua as informações nesessárias para se conectar ao banco de dados
6. Utilize o comando `php artisan migrate` para criar o esquema de tabelas no seu banco de dados
7. Inclua também o dominio utilizado pelo frontend na configuração `SANCTUM_STATEFUL_DOMAINS` (não é necessário caso esteja utilizando algum dos dominios que estão incluídos no arquivo `config/sanctum.php`)
8. Utilize o comando `php artisan serve`, isso irá rodar o projeto na porte 8000 por padrão, mas pode ser customizado utilizando a opção `--port`

Testes:

-   Os testes do projeto foram feitos com o framework [PestPHP](https://pestphp.com/), para realizar os testes basta utilizar o comando `php artisan test`

Endpoints:

-   Todas as rotas utilizam por padrão o prefixo `api` após a url base do projeto, então se a url do projeto é `http://localhost:8000`, os endpoints serão utilizados na url `http://localhost:8000/api`

### Cookie CSRF [/csrf-cookie]

#### [GET] Retorna um cookie chamado `XSRF-TOKEN`, o valor desse cookie deverá ser passado para todas as requisições que fazem uso de autenticação de alguma, o valor será passado utilizando o header `X-XSRF-TOKEN`

### Login [/auth/login]

#### [POST] Autentica o token que está sendo utilizado atualmente no header `X-XSRF-TOKEN`

-   Request (application/json)

    -   Body

              {
                  "email": "
                  "password": "
              }

### Logout [/auth/logout]

#### [POST] Invalida o token que está sendo utilizado atualmente no header `X-XSRF-TOKEN`

### Usuário Autenticado [/auth/user]

#### [GET] Retorna os dados do usuário autenticado

### Usuário [/user]

#### [POST] Cria um novo usuário

-   Request (application/json)

    -   Body

              {
                  "name": "",
                  "email": "",
                  "password": "",
                  "password_confirmation": ""
              }

#### [PUT /{userId}] Atualiza um usuário

-   Request (application/json)

    -   Body

              {
                  "name": "",
                  "email": "",
                  "password": "",
                  "password_confirmation": ""
              }

### Despesa [/expense]

#### [GET] Retorna todas as despesas do usuário autenticado, em formato paginado

- Request

    - URL Query Params

        - page
        - per_page
        - sort_by
        - sort_direction
        - search

#### [POST] Cria uma nova despesa para o usuário autenticado

- Request (application/json)

    -   Body

            {
                "description": "",
                "date": "",
                "value": 0
            }

#### [PUT /{expenseId}] Atualiza uma despesa do usuário autenticado

- Request (application/json)

    -   Body

            {
                "description": "",
                "date": "",
                "value": 0
            }

#### [DELETE /{expenseId}] Exclui uma despesa do usuário autenticado
