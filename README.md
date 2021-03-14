# Projeto de Transferência de Dinheiro

## Funcionalidades
 - Cadastrar Usuários
 - Transferir dinheiro
 
## Tecnologias / Patterns
 - PHP
 - Laravel
 - Mysql
 - RabbitMQ
 - Docker
 - PHP Unit
 - Repository Pattern | SOLID

## Criar o arquivo .env com base no .example

```
DB_CONNECTION=mysql
DB_HOST=transactions_database
DB_PORT=3306
DB_DATABASE=app
DB_USERNAME=root
DB_PASSWORD=root

RABBITMQ_QUEUE=notifications
RABBITMQ_HOST=rabbitmq
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest

URL_AUTH=https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6
URL_SEND_MESSAGE=https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04
```

## Como instalar

Instalar as dependências
```bash
$ docker-compose up --build -d
```

## Docker
Executar o docker usando o `docker-compose`
```bash
$ docker-compose up --build -d
```

## URL da api tem o préfixo
```
http://localhost:8000/api
```

## Estrutura do banco
<img src="https://github.com/ayrtonsilas/service-transactions/blob/main/docs/service-transactions.png" />

## Estrutura de comunicação
<img src="https://github.com/ayrtonsilas/service-transactions/blob/main/docs/transaction-flux.png" />
## Testes

```bash
$ php artisan test
```

```
  PASS  Tests\Unit\TransactionTest
  ✓ new transaction

   PASS  Tests\Unit\UserTest
  ✓ new user

   PASS  Tests\Feature\TransactionRequestTest
  ✓ required fields

   PASS  Tests\Feature\UserRequestTest
  ✓ required fields

  Tests:  4 passed
  Time:   1.67s
```
## Rotas

### Usuários

```
[GET] /users
```
Response: `200`
```
...
"data": [
        {
            "id": 1,
            "name": "BBB",
            "email": "BBB@bbb.com",
            "register_code": "40481895060",
            "type": "user",
            "created_at": "2021-03-14T00:40:57.000000Z",
            "updated_at": "2021-03-14T00:40:57.000000Z"
        },
        {
            "id": 2,
            "name": "AAA",
            "email": "AAA@bbb.com",
            "register_code": "54917408024",
            "type": "user",
            "created_at": "2021-03-14T00:41:13.000000Z",
            "updated_at": "2021-03-14T00:41:13.000000Z"
        }
    ],
...
```

------------

```
[GET] /users/:id
```
Response: `200`
```
{
    "data": {
        "id": 1,
        "name": "BBB",
        "email": "BBB@bbb.com",
        "register_code": "40481895060",
        "type": "user",
        "created_at": "2021-03-14T00:40:57.000000Z",
        "updated_at": "2021-03-14T00:40:57.000000Z"
    }
}
```

------------

```
[POST] /users
```
Body
```
{
    "name": "CCC",
    "register_code" : "51994442042",
    "email" : "CCC@CCC.com",
    "type" : "user",
    "amount" : 10
}
```
Response: `201`
```
{
    "data": {
        "name": "CCC",
        "register_code": "51994442042",
        "email": "CCC@CCC.com",
        "type": "user",
        "updated_at": "2021-03-14T02:13:36.000000Z",
        "created_at": "2021-03-14T02:13:36.000000Z",
        "id": 3
    }
}
```

------------

### Transações
```
[GET] /transactions
```
Response: `200`
```
...
"data": [
        {
            "id": 1,
            "payer": 2,
            "payee": 1,
            "value": 5,
            "created_at": "2021-03-14T00:47:04.000000Z",
            "updated_at": "2021-03-14T00:47:04.000000Z"
        },
        {
            "id": 2,
            "payer": 2,
            "payee": 1,
            "value": 5,
            "created_at": "2021-03-14T01:17:34.000000Z",
            "updated_at": "2021-03-14T01:17:34.000000Z"
        }
    ]
...
```

------------

```
[GET] /transactions/:id
```
Response: `200`
```
{
    "data": {
        "id": 1,
        "payer": 2,
        "payee": 1,
        "value": 5,
        "created_at": "2021-03-14T00:47:04.000000Z",
        "updated_at": "2021-03-14T00:47:04.000000Z"
    }
}
```

------------

```
[POST] /transactions
```
Body
```
{
    "payer": 2,
    "payee" : 1,
    "value" : 5
}
```
Response: `201`
```
{
    "data": {
        "payer": 2,
        "payee": 1,
        "value": 5,
        "updated_at": "2021-03-14T01:17:34.000000Z",
        "created_at": "2021-03-14T01:17:34.000000Z",
        "id": 2
    }
}
```

## Acesso ao RabbitMQ

```
http://localhost:15672/
```
usuário: `guest`
senha: `guest`
