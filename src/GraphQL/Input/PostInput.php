<?php

namespace App\GraphQL\Input;

use Symfony\Component\Validator\Constraints as Assert;

class PostInput
{
    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $author;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $body;
}
