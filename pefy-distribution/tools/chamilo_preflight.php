<?php
declare(strict_types=1);
/** Read-only installation preflight. Does not bootstrap Chamilo or expose secrets. */
$root = dirname(__DIR__, 2);
$required = ['bcmath','ctype','curl','dom','exif','fileinfo','gd','iconv','intl',
'json','ldap','libxml','mbstring','pdo','simplexml','soap','sodium','xml',
'xmlreader','zip','zlib'];
$missing = array_values(array_filter($required, static fn($ext) => !extension_loaded($ext)));
$checks = [
    'php_version_supported' => PHP_VERSION_ID >= 80300 && PHP_VERSION_ID < 90000,
    'composer_manifest_present' => is_file($root . '/composer.json'),
    'vendor_autoload_present' => is_file($root . '/vendor/autoload.php'),
    'env_file_present' => is_file($root . '/.env.local') || is_file($root . '/.env'),
    'php_extensions_present' => count($missing) === 0,
];
$report = [
    'component' => 'pefy-chamilo-readonly-preflight',
    'php_version' => PHP_VERSION,
    'checks' => $checks,
    'missing_extensions' => $missing,
    'ready_for_installation_review' => !in_array(false, $checks, true),
    'limitations' => 'Does not validate DB connectivity, Symfony boot, web server, migrations, security or LMS/PEFY E2E.',
];
echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
exit($report['ready_for_installation_review'] ? 0 : 1);
