# aiq

## Decisões

Acesse a [página](/docs/decisoes.md) para verificar as justificativas que foram utilziadas para a aplicação das decisões.

## Melhorias

Acesse a [página](/docs/melhorias.md) para encontrar melhorias que poderemos fazer no sistema no futuro.

## Técnico

### Docker - Startup

- Subir docker

```sh
docker compose up
```

- ir para a pasta do projeto e rodar o comando:

```sh
docker exec -it $(docker compose ps -q php-fpm) sh
```

### Testes

- Testes automaticos com Github Actions: [Clique Aqui](https://github.com/gdakuzak/aiq/actions/workflows/tests.yaml)
- Para testes no ambiente:
  - Após executar os passos do [Startup](#docker---startup), execute o comando:
    ```sh
    php artisan test
    ```
