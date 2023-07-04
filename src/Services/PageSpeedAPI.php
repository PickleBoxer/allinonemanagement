<?php

declare(strict_types=1);

namespace AllInOneManagement\Services;

/**
 * This class provides methods to interact with the Google PageSpeed Insights API.
 * It allows to get performance metrics and generate reports for a given URL.
 *
 * @package AllInOneManagement\Services
 */
class PageSpeedAPI
{
    private $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';

    /**
     * Report artifacts.
     *
     * @var array
     */
    private $reportArtifacts = [
        'html' => 'payload.html',
        'reportHtml' => 'lighthouse.html',
        'screenshot' => 'screenshot.jpeg',
        'fullScreenScreenshot' => 'full-screenshot.jpeg',
        'screenshotThumbnailsDir' => '__screenshot-thumbnails__',
        'reportJson' => 'lighthouse.json',
    ];

    /**
     * This method generates performance metrics and reports for a given URL.
     * It deletes all previous reports before generating new ones.
     *
     * @param array $urls An array of URLs to generate reports for.
     * @param array $options An array of options to pass to the API.
     * @return void
     *
     * @throws \Exception If there is an error with the cURL request.
     */
    public function getResults(array $urls = [], array $options = []): void
    {
        // Deletes all previous reports before generating new ones.
        $this->deleteAll(_PS_MODULE_DIR_ . 'allinonemanagement/reports/');

        // Loops through each URL and generates a report.
        foreach ($urls as $url) {
            $params = [
                'url' => $url,
            ];
            $params = array_merge($params, $options);
            $apiUrl = $this->apiUrl . '?' . http_build_query($params);
            // Matches any URL-encoded square brackets followed by one or more digits and another URL-encoded square bracket.
            $apiUrl = preg_replace('/%5B\d+%5D=/', '=', $apiUrl);

            // Sends a cURL request to the API and gets the response.
            $response = $this->getResponse($apiUrl);
            $result = json_decode($response, true);
            $dirPath = $this->getPathFromUrl($url);

            // Writes the response to a file.
            $this->writeToFile($response, $dirPath);

            // Extracts all base64 data from the response and saves it to files.
            $this->extractAllBase64Data($result, $dirPath);

            // Generates an HTML report from the response and saves it to a file.
            $this->generateLighthouseHtml($response, $dirPath);

            // Generates an HTML file from url and saves it to a file.
            $this->getPageContent($url, $dirPath);
        }
    }

    /**
     * Sends a cURL request to the Google PageSpeed Insights API and returns the response.
     *
     * @param string $apiUrl The URL of the API endpoint.
     * @return string The response from the API.
     *
     * @throws \Exception If there is an error with the cURL request.
     */
    private function getResponse(string $apiUrl): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }

    /**
     * Writes the API response to a file.
     *
     * @param string $response The response from the API.
     * @param string $dirPath The directory path to save the file.
     * @return void
     */
    private function writeToFile(string $response, string $dirPath): void
    {
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $filePath = $dirPath . '/lighthouse.json';
        file_put_contents($filePath, $response);
    }

    /**
     * Recursively deletes all files and directories in a given directory.
     *
     * @param string $dir The directory to delete.
     * @return void
     */
    private function deleteAll(string $dir): void
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                $this->deleteAll($file);
                rmdir($file);
            } else {
                unlink($file);
            }
        }
    }

    /**
     * Extracts all base64 data from the PageSpeed Insights API response and saves it to files.
     *
     * @param array $result The decoded response from the API.
     * @param string $dirPath The directory path to save the files.
     * @return void
     */
    public function extractAllBase64Data($result, $dirPath)
    {
        $this->extractScreenshotBase64Data($result, $dirPath);
        $this->extractFullScreenScreenshotBase64Data($result, $dirPath);
        $this->extractScreenshotThumbnails($result, $dirPath);
    }

    private function extractScreenshotBase64Data($result, $dirPath)
    {
        if (isset($result['lighthouseResult']['audits']['final-screenshot']['details']['data'])) {
            $screenshotBase64 = $result['lighthouseResult']['audits']['final-screenshot']['details']['data'];
            $data = explode(',', $screenshotBase64);
            $screenshotBuffer = base64_decode($data[1]);
            $screenshotPath = $dirPath . $this->reportArtifacts['screenshot'];
            file_put_contents($screenshotPath, $screenshotBuffer);
        }
    }

    private function extractFullScreenScreenshotBase64Data($result, $dirPath)
    {
        if (isset($result['lighthouseResult']['fullPageScreenshot']['screenshot']['data'])) {
            $fullScreenScreenshotBase64 = $result['lighthouseResult']['fullPageScreenshot']['screenshot']['data'];
            $data = explode(',', $fullScreenScreenshotBase64);
            $fullScreenScreenshotBuffer = base64_decode($data[1]);
            $fullScreenScreenshotPath = $dirPath . $this->reportArtifacts['fullScreenScreenshot'];
            file_put_contents($fullScreenScreenshotPath, $fullScreenScreenshotBuffer);
        }
    }

    private function extractScreenshotThumbnails($result, $dirPath)
    {
        $screenshotThumbnails = $result['lighthouseResult']['audits']['screenshot-thumbnails']['details'];
        $screenshotThumbnailsDir = $dirPath . $this->reportArtifacts['screenshotThumbnailsDir'];
        if (isset($screenshotThumbnails['items']) && $screenshotThumbnails['type'] === 'filmstrip') {
            if (!file_exists($screenshotThumbnailsDir)) {
                mkdir($screenshotThumbnailsDir, 0777, true);
            }
            foreach ($screenshotThumbnails['items'] as $key => $thumbnail) {
                $thumbnailBase64 = $thumbnail['data'];
                $data = explode(',', $thumbnailBase64);
                $thumbnailBuffer = base64_decode($data[1]);
                $thumbnailPath = $screenshotThumbnailsDir . '/' . $key . '.jpeg';
                file_put_contents($thumbnailPath, $thumbnailBuffer);
            }
        }
    }

    public function generateLighthouseHtml($response, $dirPath)
    {
        // Read the contents of the template file
        $template = file_get_contents(_PS_MODULE_DIR_ . 'allinonemanagement/views/Lighthouse/Report/standalone-template.html');

        // Replace the placeholders with the actual content
        $template = str_replace('%%LIGHTHOUSE_JSON%%', $response, $template);

        // Read the contents of the standalone.js file
        $js = file_get_contents(_PS_MODULE_DIR_ . 'allinonemanagement/views/Lighthouse/Report/standalone.js');
        $template = str_replace('%%LIGHTHOUSE_JAVASCRIPT%%', $js, $template);

        // Save the generated HTML file
        $responsePath =  $dirPath . $this->reportArtifacts['reportHtml'];
        file_put_contents($responsePath, $template);
    }

    private function getPathFromUrl($url)
    {
        $parts = parse_url($url);
        $host = $parts['host'];
        if (isset($parts['path'])) {
            $path = $parts['path'];
            $path = explode(".", $path)[0];
        } else {
            $path = '';
        }

        $dirPath = _PS_MODULE_DIR_ . 'allinonemanagement/reports/' . $host  . $path . '/';

        return $dirPath;
    }

    /**
     * Gets the content of a page from a given URL and saves it as an HTML file.
     *
     * @param string $url The URL of the page.
     * @param string $dirPath The directory path to save the file.
     * @return void
     * @throws Exception If the URL is invalid or the file cannot be saved.
     */
    private function getPageContent(string $url, string $dirPath): void
    {
        // Check if the URL is valid
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid URL');
        }

        // Get the page content using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        // Check if the file was saved successfully
        $filePath = $dirPath . $this->reportArtifacts['html'];
        if (!file_put_contents($filePath, $html)) {
            throw new \Exception('Failed to save file');
        }
    }
}
