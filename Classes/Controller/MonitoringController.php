<?php
declare(strict_types=1);

namespace Ttree\Health\Controller;

use Neos\Flow\Mvc\Controller\ActionController;
use Ttree\Health\Service\CheckRunnerService;
use Ttree\Health\View\MonitoringView;
use Neos\Flow\Annotations as Flow;

class MonitoringController extends ActionController
{
    /**
     * @var array
     */
    protected $supportedMediaTypes = ['application/json'];

    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = ['json' => MonitoringView::class];

    /**
     * @var CheckRunnerService
     * @Flow\Inject
     */
    protected $runner;

    /**
     * @param string $preset The Monitoring preset
     * @return void
     */
    public function indexAction($preset)
    {
        $this->verifySettings($preset);
        $this->view->assign('endpoint', $preset);
        $this->view->assign('results', $this->runner->run(
            $this->settings['presets'][$preset]['checks'])
        );
    }

    /**
     * @param string $preset
     * @return void
     */
    private function verifySettings($preset)
    {
        if (!isset($this->settings['presets'][$preset])) {
            throw new \InvalidArgumentException(sprintf('The endpoint "%s" is not configured.', $preset), 1461435428);
        }
    }
}
