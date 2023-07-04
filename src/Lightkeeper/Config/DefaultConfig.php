<?php

/**
 * This file contains the Config class which is responsible for managing the default configuration of the AllInOneManagement module.
 */

declare(strict_types=1);

namespace AllInOneManagement\Lightkeeper\Config;

use AllInOneManagement\Lightkeeper\Config\DefaultColumns;

class DefaultConfig
{
    private static $instance;
    private $config;

    /**
     * The default configuration for the AllInOneManagement module.
     *
     * @var array
     */
    private $defaultConfig = [
        /**
         * The site that will be scanned.
         */
        'site' => '',
        /**
         * The path that we'll be performing the scan from, this should be the path to the app that represents the site.
         * Using this path we can auto-discover the provider
         * @default getcwd()
         */
        'root' => '',
        'serverRoot' => '',
        'routerPrefix' => '/',
        'apiPrefix' => '/api',
        /**
         * Provide a list of URLs that should be used explicitly.
         * Will disable sitemap and crawler.
         *
         * @default []
         */
        'urls' => [],
        /**
         * Should reports be saved to the local file system and re-used between runs for the scanned site.
         *
         * Note: This makes use of cache-bursting for when the configuration changes, since this may change the report output.
         *
         * @default true
         */
        'cache' => true,
        'client' => [
            'groupRoutesKey' => 'route.definition.name',
            'columns' => [],
        ],
        'scanner' => [
            'customSampling' => [],
            'ignoreI18nPages' => true,
            'maxRoutes' => 200,
            'skipJavascript' => true,
            'samples' => 1,
            'throttle' => false,
            'crawler' => true,
            'dynamicSampling' => 5,
            'sitemap' => true,
            'robotsTxt' => true,
            'device' => 'mobile',
        ],
        'server' => [
            'port' => 5678,
            'showURL' => false,
            'open' => true,
        ],
        'discovery' => [
            'supportedExtensions' => ['vue', 'md'],
            'pagesDir' => 'pages',
        ],
        /**
         * Where to emit lighthouse reports and the runtime client.
         *
         * @default "./lighthouse/"
         */
        'outputPath' => '.unlighthouse',
        'debug' => false,
        'puppeteerOptions' => [],
        'puppeteerClusterOptions' => [
            'monitor' => true,
            'workerCreationDelay' => 500,
            'retryLimit' => 3,
            'timeout' => 300000,
            'maxConcurrency' => 5,
            'skipDuplicateUrls' => false,
            'retryDelay' => 2000,
            'concurrency' => 'browser',
        ],
        'lighthouseOptions' => [
            'onlyCategories' => ['performance', 'accessibility', 'best-practices', 'seo'],
            'formFactor' => 'mobile',
        ],
    ];

    /**
     * Config constructor.
     *
     * @param array|null $config
     */
    private function __construct($config = null)
    {
        $this->defaultConfig['root'] =
            /**dirname(__FILE__, 3)*/
            getcwd();
        $this->defaultConfig['root'] = _PS_MODULE_DIR_ . 'allinonemanagement/';
        $this->defaultConfig['serverRoot'] = $_SERVER['DOCUMENT_ROOT'];
        $this->defaultConfig['client']['columns'] = DefaultColumns::$defaultColumns;
        
        if ($config !== null) {
            $this->config = array_replace_recursive($this->defaultConfig, $config);
        } else {
            $this->config = $this->defaultConfig;
        }
    }

    /**
     * Returns the instance of the Config class.
     *
     * @param array|null $config
     * @return Config
     */
    public static function getInstance($config = null)
    {
        if (!self::$instance) {
            self::$instance = new DefaultConfig($config);
        }
        return self::$instance;
    }

    /**
     * Returns the value of the specified key from the configuration.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->config[$key];
    }

    /**
     * Sets the new configuration by merging it with the existing configuration.
     *
     * @param array $newConfig
     */
    public function set($newConfig)
    {
        $this->config = array_replace_recursive($this->config, $newConfig);
    }

    /**
     * Returns the entire configuration array.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
