# SymfonyWebParser

## Set up
- Pull Repositorty
- Copy .env to .env.{env_name} and fill in values
- run docker compose build
- run docker compose up
- open http://localhost:8080/articles

## Access PHP and Symfony Console
``docker-compose exec php /bin/bash``
 ``symfony console make:migration``
 ``symfony console doctrine:migrations:migrate``


## Add Dummy Data to DB
``symfony console doctrine:fixtures:load``

## Access DB Console
``docker-compose exec database /bin/bash  ``


## Fetch data from url to Rabbit MQ
``symfony console fetch-html https://highload.today/category/novosti/``


## Parse Data From RabbitMQ to DB
``symfony console parse-articles``


## Default Credentials
  `` Password : $ymf0ny  
     Email : superadmin@test.com ``