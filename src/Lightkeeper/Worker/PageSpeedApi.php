<?php

class PageSpeedApi
{
    private $apiKey;
    private $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';

    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    public function runScan($url)
    {
        $options = [
            'onlyCategories' => ['performance', 'accessibility', 'best-practices', 'seo'],
        ];

        $url = $this->buildApiUrl($url);
        $response = $this->sendApiRequest($url);
        $data = json_decode($response, true);

        return $data;
    }

    private function buildApiUrl($url)
    {
        $apiUrl = $this->apiUrl . '?url=' . urlencode($url);

        if ($this->apiKey !== null) {
            $apiUrl .= '&key=' . $this->apiKey;
        }

        return $apiUrl;
    }

    private function sendApiRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            throw new Exception('API request failed: ' . $error);
        }

        if ($httpCode !== 200) {
            throw new Exception('API request failed with HTTP code ' . $httpCode);
        }

        return $response;
    }

    /**$urls = array('https://vapr.store', 'https://vapr.store/746-per-iniziare', 'https://vapr.store/basi-con-nicotina/6875-6593-vapr-base-nicobooster-70-30-10ml.html#/65-nicotina-18mg_ml');
        $options = array(
            'strategy' => 'mobile',
            'category' => array(
                'performance',
                'accessibility',
                'best-practices',
                'seo',
                'pwa'
            )
        );

        foreach ($urls as $url) {
            $params = [
                'url' => $url,
            ];
            $params = array_merge($params, $options);
            $apiUrl = $this->apiUrl . '?' . http_build_query($params);
            // Matches any URL-encoded square brackets followed by one or more digits and another URL-encoded square bracket.
            $apiUrl = preg_replace('/%5B\d+%5D=/', '=', $apiUrl);
            */
}