<?php

namespace AllInOneManagement\Lightkeeper;

use AllInOneManagement\Lightkeeper\Config\ResolvedConfig;
use AllInOneManagement\Lightkeeper\Context\LightkeeperContext;

require_once __DIR__ . '/Util/utils.php';

class Lightkeeper
{
    private $config;
    private $resolvedConfig;

    public function __construct($customConfig = null)
    {
        $this->config = new ResolvedConfig($customConfig);
        $this->resolvedConfig = $this->config->getConfig();
    }

    public function run()
    {
        if ($this->resolvedConfig['root'] && !isAbsolutePath($this->resolvedConfig['root'])) {
            $this->resolvedConfig['root'] = joinPaths($_SERVER['DOCUMENT_ROOT'], $this->resolvedConfig['root']);
        } elseif (!$this->resolvedConfig['root']) {
            $this->resolvedConfig['root'] = $_SERVER['DOCUMENT_ROOT'];
        }
        print_r($this->resolvedConfig['urls']);

        // Step 2: Context Setup
        $context = new LightkeeperContext($this->resolvedConfig);
        //$context->discoverRouteDefinitions();
        //$context->readRobotsTxt();
        //$context->processSitemap();

        // Step 3: Worker
        //$worker = new UnlighthouseWorker($context);
        //$worker->performScans();

        // Step 4: Client
        //$client = new UnlighthouseClient();
        //$client->setWorker($worker);
        //$client->setupBroadcasting();
        //$client->handleWorkerEvents();
    }
}
