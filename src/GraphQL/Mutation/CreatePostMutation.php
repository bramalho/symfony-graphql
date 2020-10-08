<?php

namespace App\GraphQL\Mutation;

use App\Entity\Author;
use App\Entity\Post;
use App\GraphQL\Input\PostInput;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreatePostMutation implements MutationInterface
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

    public function createPost(Argument $args): Post
    {
        $input = new PostInput();
        foreach($args["input"] as $key => $value){
            $input->$key = $value;
        }

        $errors = $this->validator->validate($input);

        if (count($errors) !== 0){
            throw new \Exception($errors);
        }

        $author = $this->entityManager->find(Author::class, $input->author);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $post = new Post();
        $post->setAuthor($author);
        $post->setTitle($input->title);
        $post->setBody($input->body);
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}
