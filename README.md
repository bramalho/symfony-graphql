# Symfony GraphQL

```bash
docker-compose up -d

docker-compose exec -u www-data php sh

composer install

./bin/console doctrine:schema:update --force

./bin/console doctrine:fixtures:load
```

Go to [localhost/graphiql](http://localhost/graphiql)

## Queries

Author Query

```gql
query {
    author(id: 1) {
        id
        name
        email
        posts (first: 10){
            edges {
                cursor
                node {
                    id
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
        id
        title
        body
        author {
            id
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
            id
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
            id
            title
            body
            author {
                id
                name
                email
            }
        }
    }
}
```

## Mutations

Create Author Mutation

```gql
mutation($input: AuthorInput!) {
    create_author(input: $input){
        id
        name
        email
    }
}
```

```json
{
    "input": {
        "name": "Author 1",
        "email": "one@author.com"
	}
}
```

Update Author Mutation

```gql
mutation($id: Int, $input: AuthorInput!) {
    update_author(id: $id, input: $input){
        id
        name
        email
    }
}
```

```json
{
    "id": 3,
    "input": {
        "name": "Author 3",
        "email": "three@author.com"
	}
}
```

Create Post Mutation

```gql
mutation($input: PostInput!) {
    create_post(input: $input){
        id
        title
        body
        author {
            id
            name
            email
        }
    }
}

```

```json
{
    "input": {
        "author": 1,
        "title": "My Post",
        "body": "This is my post!"
    }
}
```
