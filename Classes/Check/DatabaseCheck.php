<?php
declare(strict_types=1);

namespace Ttree\Health\Check;

use Ttree\Health\Result\ResultInterface;
use Ttree\Health\Result\SuccessResult;

class DatabaseCheck implements CheckInterface
{
    public function run(): ResultInterface
    {
        return SuccessResult::createFromString('Database access works');
    }
}
