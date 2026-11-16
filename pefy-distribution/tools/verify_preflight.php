<?php
declare(strict_types=1);
/** No external dependencies; test the preflight report structure without claiming installation. */
$cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__DIR__ . '/chamilo_preflight.php');
$output = [];
$code = 0;
exec($cmd, $output, $code);
$report = json_decode(implode("\n", $output), true);
if (!is_array($report) || !isset($report['checks'], $report['missing_extensions'], $report['ready_for_installation_review'])) {
    fwrite(STDERR, "Invalid preflight report\n");
    exit(1);
}
if ($code === 0 && !$report['ready_for_installation_review']) {
    fwrite(STDERR, "Fail-open preflight\n");
    exit(1);
}
echo "Preflight report contract OK; installation readiness: " .
    ($report['ready_for_installation_review'] ? 'candidate' : 'blocked') . PHP_EOL;
