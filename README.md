# aiq

## Decisões

Acesse a [página](/docs/decisoes.md) para ver algumas decisões tomadas durante o processo de desenvolvimento.

## Melhorias

Acesse a [página](/docs/melhorias.md) para encontrar melhorias que poderemos fazer no sistema no futuro.

## Técnico

### Tecnologias

- PHP
- Nginx
- Laravel
- Postgres
- Redis
- Docker
- PHPUnit

## Pré requisito

- Docker

### Instalação e Preparação

- Clone o repositorio: `git@github.com:gdakuzak/aiq.git`
- Entrar na pasta do projeto: `cd aiq`
- Copie o `.env.example` para `.env`
  - Se tiver usando Linux: `cp .env.example .env`
- Altere os parametros:
  - `DB_USERNAME=postgres`
  - `DB_PASSWORD=postgres`
- Execute o comando para buildar a imagem: `docker compose build`

### Docker - Startup

- Subir docker

```sh
docker compose up
```

- ir para a pasta do projeto e rodar o comando:

```sh
docker exec -it $(docker compose ps -q php-fpm) sh
```

- Caso for a primeira vez que voce está fazendo o startup, siga os passos:
  - Execute o comando: `php artisan key:generate`;


### Testes

- Testes automaticos com Github Actions: [Clique Aqui](https://github.com/gdakuzak/aiq/actions/workflows/tests.yaml)
- Para testes no ambiente:
  - Após executar os passos do [Startup](#docker---startup), execute o comando:
    ```sh
    php artisan test
    ```



### System Design

![System Design](/docs/SystemDesign.png)