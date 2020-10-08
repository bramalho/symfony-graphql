<?php

namespace App\GraphQL\Resolver;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Type\Definition\ResolveInfo;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class AuthorListResolver implements ResolverInterface
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

    public function resolve(Argument $args)
    {
        $authors = $this->entityManager->getRepository(Author::class)->findBy(
            [], ['id' => 'asc'], $args['limit'], 0
        );

        return ['authors' => $authors];
    }
}
