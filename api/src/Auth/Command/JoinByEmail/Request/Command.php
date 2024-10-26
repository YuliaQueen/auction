<?php

namespace App\Auth\Command\JoinByEmail\Request;

class Command
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}