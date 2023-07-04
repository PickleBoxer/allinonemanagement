<?php

class LightkeeperWorker
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    public function performScans()
    {
        $urls = $this->context->getUrlsToScan();

        foreach ($urls as $url) {
            // Step 1: Perform a GET request and extract HTML payload for basic SEO data and internal link discovery
            $htmlPayload = $this->performGetRequest($url);
            $seoData = $this->extractSeoData($htmlPayload);
            $internalLinks = $this->discoverInternalLinks($htmlPayload);

            // Step 2: Perform the Lighthouse scan
            $lighthouseReport = $this->runLighthouseScan($url);

            // Step 3: Save the HTML payload, JSON report, SEO data, and internal links to the filesystem
            $this->savePayload($url, $htmlPayload);
            $this->saveLighthouseReport($url, $lighthouseReport);
            $this->saveSeoData($url, $seoData);
            $this->saveInternalLinks($url, $internalLinks);
        }
    }

    private function performGetRequest($url)
    {
        // Perform the GET request and return the HTML payload
    }

    private function extractSeoData($htmlPayload)
    {
        // Extract basic SEO data from the HTML payload and return the data
    }

    private function discoverInternalLinks($htmlPayload)
    {
        // Discover internal links within the HTML payload and return the links
    }

    private function runLighthouseScan($url)
    {
        // Run the Lighthouse scan for the given URL and return the report data
    }

    private function savePayload($url, $htmlPayload)
    {
        // Save the HTML payload to the filesystem
    }

    private function saveLighthouseReport($url, $lighthouseReport)
    {
        // Save the Lighthouse report (JSON) to the filesystem
    }

    private function saveSeoData($url, $seoData)
    {
        // Save the SEO data to the filesystem
    }

    private function saveInternalLinks($url, $internalLinks)
    {
        // Save the internal links to the filesystem
    }
}