<?php

use AllInOneManagement\Lightkeeper\Lightkeeper;

// Custom config example
$customConfig = [
    'api_key' => 'YOUR_API_KEY',
    'max_threads' => 10,
    'report_format' => 'html',
];

$app = new Lightkeeper($customConfig);

// Start the Unlighthouse process
$app->run();