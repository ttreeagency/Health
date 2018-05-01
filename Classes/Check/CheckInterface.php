<?php
declare(strict_types=1);

namespace Ttree\Health\Check;

use Ttree\Health\Result\ResultInterface;

interface CheckInterface
{
    public function run():ResultInterface;
}
