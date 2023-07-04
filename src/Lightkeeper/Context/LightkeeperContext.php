<?php

declare(strict_types=1);

namespace AllInOneManagement\Lightkeeper\Context;

class LightkeeperContext
{
    private $config;
    private $routeDefinitions;
    private $sitemapUrls;
    private $excludedRoutes;

    public function __construct($resolvedConfig)
    {
        $this->config = $resolvedConfig;
    }

    public function discoverRouteDefinitions()
    {
        // Logic to discover route definitions and create a virtual router
    }

    public function readRobotsTxt()
    {
        // Logic to read and process the robots.txt file
    }

    public function processSitemap()
    {
        // Logic to process the sitemap.xml and collect URLs
    }

    public function getUrlsToScan()
    {
        // Logic to determine the URLs to be scanned
        // Example: combine route definitions, sitemap URLs, and excluded routes
        $urls = array_merge($this->routeDefinitions, $this->sitemapUrls);
        $urls = array_diff($urls, $this->excludedRoutes);

        return $urls;
    }

    // Setter methods for route definitions, sitemap URLs, and excluded routes
    public function setRouteDefinitions($routeDefinitions)
    {
        $this->routeDefinitions = $routeDefinitions;
    }

    public function setSitemapUrls($sitemapUrls)
    {
        $this->sitemapUrls = $sitemapUrls;
    }

    public function setExcludedRoutes($excludedRoutes)
    {
        $this->excludedRoutes = $excludedRoutes;
    }
}