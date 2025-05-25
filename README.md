# aiq

## Decisões

Acesse a [página](/docs/decisoes.md) para verificar as justificativas que foram utilziadas para a aplicação das decisões.

## Melhorias

Acesse a [página](/docs/melhorias.md) para encontrar melhorias que poderemos fazer no sistema no futuro.

## Técnico

### Docker

- Subir docker

```sh
docker compose up
```

- ir para a pasta do projeto e rodar o comando:

```sh
docker exec -it $(docker compose ps -q php-fpm) sh
```
