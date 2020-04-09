<?php

namespace WebFeletesDevelopers\Pharaon\Application\UseCase;

use Exception;

/**
 * Class BaseUseCaseResponse
 * @package WebFeletesDevelopers\Pharaon\Application\UseCase
 * @author WebFeletesDevelopers
 */
abstract class BaseUseCaseResponse
{
    protected bool $success = true;
    protected ?Exception $error;

    /**
     * @return bool
     */
    public function success(): bool
    {
        return $this->success;
    }

    /**
     * @param Exception $error
     */
    public function setError(Exception $error): void
    {
        $this->success = false;
        $this->error = $error;
    }

    public function error(): ?Exception
    {
        return $this->error;
    }
}
