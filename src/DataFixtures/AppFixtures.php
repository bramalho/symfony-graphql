<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author->setName('John Doe')
            ->setEmail('john@doe.com');

        $manager->persist($author);

        $post = new Post();
        $post->setTitle('My First Post')
            ->setBody('This is my first post!')
            ->setAuthor($author);

        $manager->persist($post);

        $manager->flush();
    }
}
