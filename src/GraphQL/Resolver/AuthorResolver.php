<?php

namespace App\GraphQL\Resolver;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Paginator;

class AuthorResolver implements ResolverInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ResolveInfo $info, $value, Argument $args)
    {
        $method = $info->fieldName;
        return $this->$method($value, $args);
    }

    public function resolve(int $id): ?Author
    {
        return $this->entityManager->find(Author::class, $id);
    }

    public function id(Author $author): int
    {
        return $author->getId();
    }

    public function name(Author $author): string
    {
        return $author->getName();
    }

    public function email(Author $author): string
    {
        return $author->getEmail();
    }

    public function posts(Author $author, Argument $args): Connection
    {
        $posts = $author->getPosts();
        $paginator = new Paginator(function ($offset, $limit) use ($posts) {
            return array_slice($posts->toArray(), $offset, $limit ?? 10);
        });

        return $paginator->auto($args, count($posts));
    }
}
