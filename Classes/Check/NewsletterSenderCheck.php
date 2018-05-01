<?php
declare(strict_types=1);

namespace Ttree\Health\Check;

use Ttree\Health\Result\ErrorResult;
use Ttree\Health\Result\ResultInterface;

class NewsletterSenderCheck implements CheckInterface
{
    public function run(): ResultInterface
    {
        return ErrorResult::createFromString('Newsletter Sender is down');
    }
}
