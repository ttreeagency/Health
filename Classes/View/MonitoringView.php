<?php
declare(strict_types=1);

namespace Ttree\Health\View;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Http\Response as HttpResponse;
use Neos\Flow\Log\SystemLoggerInterface;
use Neos\Flow\Mvc\View\AbstractView;
use Neos\Flow\Exception as FlowException;
use Neos\Utility\Arrays;
use Ttree\Health\Result\ErrorResult;
use Ttree\Health\Result\ResultInterface;
use Ttree\Health\Result\SuccessResult;
use Ttree\Health\Result\WarningResult;

class MonitoringView extends AbstractView
{
    const STATUS_ERROR = 'Error';
    const STATUS_WARNING = 'Warning';
    const STATUS_SUCCESS = 'Success';

    protected $statusMapping = [
        ErrorResult::class => self::STATUS_ERROR,
        WarningResult::class => self::STATUS_WARNING,
        SuccessResult::class => self::STATUS_SUCCESS,
    ];

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * @return string The rendered view
     * @throws FlowException
     */
    public function render()
    {
        if (!isset($this->variables['endpoint'])) {
            throw new FlowException('Missing endpoint variable');
        }
        if (!isset($this->variables['results']) || !is_array($this->variables['results'])) {
            throw new FlowException(sprintf('The MonitoringView expects a variable "results" of type "array"!'), 1469545196);
        }
        $results = $this->variables['results'];

        /** @var HttpResponse $response */
        $response = $this->controllerContext->getResponse();
        $response->setHeader('Content-Type', 'application/json');

        $results = $this->formatResult($results);

        $f = function(array $results, string $status): array {
            return array_filter($results, function (array $message) use ($status) {
                return $message['status'] === $status;
            });
        };

        $m = function(array $message): array {
          return [
              'count' => count($message),
              'message' => $message
          ];
        };

        $success = $f($results, self::STATUS_SUCCESS);
        $warnings = $f($results, self::STATUS_WARNING);
        $errors = $f($results, self::STATUS_ERROR);

        $results = array_filter([
            'success' => $m($success),
            'warnings' => $m($warnings),
            'errors' => $m($errors)
        ], function (array $message) {
            return $message['count'] > 0;
        });

        if (Arrays::getValueByPath($results, 'warnings.count') > 0 || Arrays::getValueByPath($results, 'errors.count') > 0) {
            $response->setStatus(500);
        }

        return json_encode(Arrays::arrayMergeRecursiveOverrule([
            'endpoint' => $this->variables['endpoint']
        ], $results));
    }

    /**
     * @param array $results
     * @return array
     */
    private function formatResult(array $results)
    {
        return array_map(function (ResultInterface $result) {
            return [
                'status' => $this->statusMapping[get_class($result)],
                'message' => $result->getMessage()
            ];
        }, $results);
    }
}
