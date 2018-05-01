<?php
declare(strict_types=1);

namespace Ttree\Health\Result;

abstract class AbstractResult implements ResultInterface
{
    /**
     * @var string
     */
    protected $message;

    protected function __construct(string $message)
    {
        $this->message = $message;
    }

    public static function createFromString(string $message)
    {
        return new static($message);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}
