<?php

namespace App\Auth\Services;

interface FlusherInterface
{
    public function flush(): void;
}