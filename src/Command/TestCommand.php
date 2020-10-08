<?php

namespace App\Command;

use App\Entity\Author;
use App\Entity\Post;
use App\Repository\AuthorRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    /** @var EntityManagerInterface  */
    private $entityManager;

    /** @var AuthorRepository */
    private $authorRepository;

    /** @var PostRepository */
    private $postRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->authorRepository = $this->entityManager->getRepository(Author::class);
        $this->postRepository = $this->entityManager->getRepository(Post::class);
    }

    protected function configure()
    {
        $this->setDescription('Test command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Testing...');

        $io->writeln('Authors');
        $table = new Table($output);
        $table->setHeaders(['ID', 'Name', 'Email']);
        $authors = $this->authorRepository->findAll();
        foreach ($authors as $author) {
            $table->addRow([
                $author->getId(),
                $author->getName(),
                $author->getEmail()
            ]);
        }
        $table->render();

        $io->writeln('Posts');
        $table = new Table($output);
        $table->setHeaders(['ID', 'Title', 'Body', 'Author']);
        $posts = $this->postRepository->findAll();
        foreach ($posts as $post) {
            $table->addRow([
                $post->getId(),
                $post->getTitle(),
                $post->getBody(),
                '#' . $post->getAuthor()->getId() . ' ' . $post->getAuthor()->getName()
            ]);
        }
        $table->render();

        $io->success('Done!');

        return Command::SUCCESS;
    }
}
