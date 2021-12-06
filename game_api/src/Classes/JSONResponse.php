<?php

namespace App\Classes;

use Symfony\Component\HttpFoundation\Response;

class JSONResponse
{
    private $error;
    private $message;

    public function getError(): bool
    {
        return $this->error;
    }

    public function setError(bool $error): self
    {
        $this->error = $error;

        return $this;
    }
    
    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}