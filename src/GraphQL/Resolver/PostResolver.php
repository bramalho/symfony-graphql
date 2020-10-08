<?php

namespace App\GraphQL\Resolver;

use App\Entity\Author;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class PostResolver implements ResolverInterface
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

    public function resolve(int $id): Post
    {
        return $this->entityManager->find(Post::class, $id);
    }

    public function title(Post $post): string
    {
        return $post->getTitle();
    }

    public function body(Post $post): string
    {
        return $post->getBody();
    }

    public function author(Post $post): Author
    {
        return $post->getAuthor();
    }
}
