<?php

namespace App\GraphQL\Mutation;

use App\Entity\Author;
use App\Entity\Post;
use App\GraphQL\Input\PostInput;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdatePostMutation implements MutationInterface
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

    public function updatePost(Argument $args): Post
    {
        $input = new PostInput();
        foreach($args["input"] as $key => $value){
            $input->$key = $value;
        }

        $errors = $this->validator->validate($input);

        if (count($errors) !== 0){
            throw new \Exception($errors);
        }

        $post = $this->entityManager->find(Post::class, $args["id"]);
        if (!$post) {
            throw new \Exception("Post not found");
        }

        $author = $this->entityManager->find(Author::class, $input->author);
        if (!$author) {
            throw new \Exception("Author not found");
        }

        $post->setAuthor($author);
        $post->setTitle($input->title);
        $post->setBody($input->body);
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}
