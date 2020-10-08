<?php

namespace App\GraphQL\Mutation;

use App\Entity\Author;
use App\GraphQL\Input\AuthorInput;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateAuthorMutation implements MutationInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function updateAuthor(Argument $args): Author
    {
        $input = new AuthorInput();
        foreach($args["input"] as $key => $value){
            $input->$key = $value;
        }

        $errors = $this->validator->validate($input);

        if (count($errors) !== 0){
            throw new \Exception($errors);
        }

        $author = $this->entityManager->find(Author::class, $args["id"]);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $author->setName($input->name);
        $author->setEmail($input->email);
        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }
}
