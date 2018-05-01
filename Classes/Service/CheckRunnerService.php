<?php
declare(strict_types=1);

namespace Ttree\Health\Service;

use Neos\Flow\Annotations as Flow;
use Ttree\Health\Check\CheckInterface;

/**
 * @Flow\Scope("singleton")
 */
class CheckRunnerService
{
    public function run(array $configuration): array
    {
        return array_map(function(array $configuration) {
            if (!isset($configuration['class'])) {
                throw new \InvalidArgumentException('Missing implementation for the current check. Review your Settings.');
            }
            return $this->createCheck($configuration['class'])->run();
        }, $configuration);
    }

    protected function createCheck($className): CheckInterface
    {
        return new $className;
    }
}
