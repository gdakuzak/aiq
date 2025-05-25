# Decisões

- Docker: Fazer o container para poder fazer uma escalada num Kubernets para escala;
- Laravel: Utilizando framework solido dentro da linguagem PHP;
- Redis: compartilhar sessoes e cache para escala num Kubernets;
- Postgres: Depende da quantidade de workload, PG é melhor que o MySQL, porém como tem preferencia ao PG, ele foi escolhido.

- API como dependencia: Entendendo que o sistema atual é um serviço menor em relação aos favoritos de produtos cadastrados em outro sistema, utilizei a api FakeStoreApi como dependencia direta para trazer os dados, para evitar duplicar dados em dois sistemas.
  - Fatores:
    - Para manter os dados dentro dos favoritos, precisariamos ter rotinas para atualizar os dados dos produtos, o que concentraria uma quantidade de requisões dentro de um periodo, trazendo problemas de concorrencia para o banco nesse momento. Acredito que esse tipo de abordagem traga risco de consistencia e mais custo de manutenção, tanto para manter esses dados dentro do DB (espaco em disco), quanto para realizar intervenções para que a consistencia esteja mais próximo do 100%;
    - Para manter fora do banco de dados do favoritas, vamos ter uma quantidade de consultas na aplicação que temos dependencia, porém podemos mitigar um pouco esse risco utilizando redis colocando um cache para esse tipo de requisição, utilizando o TTL (time-to-live) na cada dos 30 minutos, inicialmente. Dependendo da frequencia de mudança desses dados, podemos aumentar ou diminuir. Adicionar feature flag para que essa feature possa ser desativada quando times acharem pertinentes.
