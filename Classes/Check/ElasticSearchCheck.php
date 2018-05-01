<?php
declare(strict_types=1);

namespace Ttree\Health\Check;

use Ttree\Health\Result\ResultInterface;
use Ttree\Health\Result\WarningResult;

class ElasticSearchCheck implements CheckInterface
{
    public function run(): ResultInterface
    {
        return WarningResult::createFromString('ElasticSearchCheck is not in green state');
    }
}
