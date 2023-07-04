<?php

declare(strict_types=1);

namespace AllInOneManagement\Lightkeeper\Config;

require_once dirname(__DIR__) . '/Util/utils.php';
use AllInOneManagement\Lightkeeper\Config\DefaultConfig;

class ResolvedConfig
{
    private $configData;

    public function __construct($customConfig = null)
    {
        $this->configData = DefaultConfig::getInstance()->getConfig();

        if ($customConfig !== null) {
            $this->configData = array_replace_recursive($this->configData, $customConfig);
        }

        $this->resolveConfig();
    }

    private function resolveConfig()
    {
        if ($this->configData['site']) {
            $this->configData['site'] = normaliseHost($this->configData['site']);
        }
        if ($this->configData['urls']) {
            $this->configData['urls'] = array_map(function ($url) {
                return normaliseHost($url);
            }, $this->configData['urls']);
        }
    }

    public function get($key, $default = null)
    {
        $keys = explode('.', $key);
        $value = $this->configData;

        foreach ($keys as $nestedKey) {
            if (isset($value[$nestedKey])) {
                $value = $value[$nestedKey];
            } else {
                return $default;
            }
        }

        return $value;
    }

    public function getConfig()
    {
        return $this->configData;
    }
}