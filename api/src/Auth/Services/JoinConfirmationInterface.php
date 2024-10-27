<?php

namespace App\Auth\Services;

use App\Auth\Entity\User\ValueObjects\Email;
use App\Auth\Entity\User\ValueObjects\Token;

interface JoinConfirmationInterface
{
    public function send(Email $email, Token $token): void;
}