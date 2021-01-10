<?php

declare(strict_types=1);

namespace App\Core\traits;

trait ErrorsTrait
{
    /** @var array - Array of Error messages */
    private $errors = [];

    public function setError($message): void
    {
        $this->errors[] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = array_merge($this->errors, $errors);
    }

    public function hasErrors(): bool
    {
        return (bool)$this->errors;
    }

    public function getFirstError(): ?string
    {
        return $this->errors[array_key_first($this->errors)] ?? null;
    }

    public function getLastError(): ?string
    {
        return $this->errors[array_key_last($this->errors)] ?? null;
    }
}
