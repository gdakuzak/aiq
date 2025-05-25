# Decisões

- Docker: Fazer o container para poder fazer uma escalada num Kubernets para escala;
- Laravel: Utilizando framework solido dentro da linguagem PHP;
- Redis: compartilhar sessoes e cache para escala num Kubernets;
- Postgres: Depende da quantidade de workload, PG é melhor que o MySQL, porém como tem preferencia ao PG, ele foi escolhido.

- API como dependencia: Entendendo que o sistema atual é um serviço menor em relação aos favoritos de produtos cadastrados em outro sistema, utilizei a api FakeStoreApi como dependencia direta para trazer os dados, para evitar duplicar dados em dois sistemas.