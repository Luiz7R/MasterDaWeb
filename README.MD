
## Teste MasterDaWeb - FullStack

<br>

Teste FullStack Desenvolvido para a MasterDaWeb.

## Tecnologias Usadas:

PHP, Laravel, MySQL, Bootstrap, Docker , Vue.js


### Funcionalidades Desenvolvidos:

* Projeto utilizando Docker
* Usando Clean Code, Solid, Design Pattern
* Usando Vuex: store, mutations, getters. axios
* Autenticação com JWT

* Listando produtos opção de enviar o produto ao carrinho, controlar quantidade de produtos etc.
* Desenvolvido um carrinho de compras com Laravel e VueJS

## Painel Administrador

* Desenvolvimento painel de administrador

### Contém: 
* Gráfico de Produtos vendidos 

* Gráfico de Lucro dos Pedidos

## Subindo o Ambiente no Docker:

```
docker-compose build
```

### Copiar o .env

```
.env.example para novo arquivo .env
```
# Rodar o Projeto: 

## Entrar no container laravel:

```
docker exec -it laravel bash
```
* Entrar na pasta do nginx, onde esta a aplicação laravel:
```
  cd usr/share/nginx
```
## Rodar os Comandos abaixo:

<br>

### Instalando Dependências:
```
composer install
```

## Banco de Dados:

### rodar as migrate

```
php artisan migrate
```

### rodar o seeder

```
php artisan db:seed
```

## Já contem produtos e usuários para usar o Projeto com facilidade =D


### Após isso já esta configurado, basta acessar o frontend, pela endereço:

```
http://localhost:8080/#/
```