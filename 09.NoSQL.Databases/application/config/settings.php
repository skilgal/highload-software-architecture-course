<?php
$applicationEnvironment = getenv('APP_ENV') ?? 'dev';
// Error reporting for development
error_reporting($applicationEnvironment === 'dev' ? E_ALL : 0);
ini_set('display_errors', $applicationEnvironment === 'dev' ? '1' : 0);
// Timezone
date_default_timezone_set('Europe/Kiev');
// Settings
$settings = [];
// Path settings
$settings['root'] = dirname(__DIR__);
// Resource path settings
$settings['resource'] = dirname(__DIR__) . '/resource';
// Error Handling Middleware settings
$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => true,
    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,
    // Display error details in error log
    'log_error_details' => true,
];
$settings['commands'] = [\App\Console\ReindexElasticsearchCommand::class];
$settings['elasticsearch'] = [
    'hosts' => [
        getenv('ELASTICSEARCH_HOST')
    ]
];

return $settings;