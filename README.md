# Symfony GraphQL

```bash
docker-compose up -d

docker-compose exec -u www-data php sh

composer install

./bin/console doctrine:schema:update --force

./bin/console doctrine:fixtures:load
```
