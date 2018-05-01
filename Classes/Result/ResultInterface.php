<?php
declare(strict_types=1);

namespace Ttree\Health\Result;

interface ResultInterface
{
    public static function createFromString(string $message);
    public function getMessage(): string;
}
