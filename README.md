# Symfony GraphQL

```bash
docker-compose up -d

docker-compose exec -u www-data php sh

composer install

./bin/console doctrine:schema:update --force

./bin/console doctrine:fixtures:load
```

Go to [localhost/graphiql](http://localhost/graphiql)

Author Query

```gql
query {
    author(id: 1) {
        name
        email
        posts (first: 10){
            edges {
                cursor
                node {
                    title
                    body
                }
            }
        }
    }
}
```

Post Query

```gql
query {
    post(id: 1) {
        title
        body
        author {
            name
            email
        }
    }
}
```

Author List Query

```gql
query {
    author_list(limit: 5) {
        authors {
            name
            email
        }
    }
}
```

Post List Query

```gql
query {
    post_list(limit: 5) {
        posts {
            title
            body
            author {
                name
                email
            }
        }
    }
}
```
