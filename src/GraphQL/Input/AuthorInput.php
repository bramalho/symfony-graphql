<?php

namespace App\GraphQL\Input;

use Symfony\Component\Validator\Constraints as Assert;

class AuthorInput
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $email;
}
