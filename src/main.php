<?php

declare(strict_types=1);

namespace Hschulz\CheckFpm;

/* Use the composer autoloader */
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Exception;
use Hschulz\CheckFpm\NagiosReturnValue;
use Hschulz\CheckFpm\Options;
use Hschulz\CheckFpm\StatusReporter;
use Hschulz\FpmStatus\Model\PoolConfig;
use Hschulz\FpmStatus\Request\CurlStatus;
use function getopt;
use function implode;

/* Create a short options string to be used by getopt() */
$shortOptions = implode('', [
    Options::HOST_SHORT . Options::ARG_REQUIRED,
    Options::PAGE_SHORT . Options::ARG_REQUIRED,
    Options::HTTPS_SHORT
]);

/* Create a long options string to be used by getopt() */
$longOptions = [
    Options::HELP_LONG,
    Options::VERSION_LONG,
    Options::HOST_LONG . Options::ARG_REQUIRED,
    OPTIONS::PAGE_LONG . Options::ARG_REQUIRED,
    Options::HTTPS_LONG,
    Options::EXTENDED_PERFORMANCE
];

/**
 * The help message.
 */
$helpMessage =<<<'EOT'

+------------------------------------------------------------------------------+
| check_fpm.phar - 0.1.0 - (C) 2019 - Hauke Schulz <hauke27@gmail.com>         |
+------------------------------------------------------------------------------+

Base options:
    --version               Print version number
    --help                  Print this help screen

Defaults:
    -h --host               IP or hostname to check
    -p --page               Path to the status page
    -s --https              Use HTTPS

Performance statistics:
    --ext-perfdata          Return full data to enable performance statistics

Usage:
    check_status.phar -h localhost [options]

Examples:

    * Check a custom url and page using SSL with extended performance data
    check_status.phar --host your.host.name -p /mystatus -s --ext-perfdata

    * Running without parameters equals the following call
    check_status.phar --host localhost -p /status -s

EOT;

/* Get the command line options matching the available parameters */
$opts = getopt($shortOptions, $longOptions);

/* Check for help argument */
$help = $opts[Options::HELP_LONG] ?? true;

/* Display help when parameter is set */
if (!$help) {
    echo $helpMessage;
    die(NagiosReturnValue::OK);
}

/* Check for version argument */
$version = $opts[Options::VERSION_LONG] ?? true;

/* Display version when parameter is set */
if (!$version) {
    echo '0.1.0' . PHP_EOL;
    die(NagiosReturnValue::OK);
}

/* Parse arguments or use default values */
$host = $opts[Options::HOST_SHORT] ?? $opts[Options::HOST_LONG] ?? 'localhost';
$page = $opts[Options::PAGE_SHORT] ?? $opts[Options::PAGE_LONG] ?? '/status';
$https = $opts[Options::HTTPS_SHORT] ?? $opts[Options::HTTPS_LONG] ?? true;
$full = $opts[Options::EXTENDED_PERFORMANCE] ?? true;

/* The pool config is not yet customizable and uses default values */
$config = new PoolConfig();
$config->setIdleTimeout('10s');
$config->setMaxChildren(60);
$config->setMaxRequests(500);
$config->setMaxSpareServers(0);
$config->setMinSpareServer(0);

/* Create the fpm status query url */
$url = 'http' . (!$https ? 's' : '') . '://' . $host . $page . '?json' . (!$full ? '&full' : '');

/* Create a new http request */
$request = new CurlStatus();

/* Try to get a status or return the exception message as the status */
try {
    $status = $request->getStatus($url);
} catch (Exception $e) {
    echo $e->getMessage();
    die(NagiosReturnValue::UNKNOWN);
}

/* Create a new reporter instance using the returned status values and config */
$reporter = new StatusReporter();
$report = $reporter->generate($status, $config);

/* Get all entries */
$entries = $report->getEntries();

/* Get the performance data */
$perfdata = $report->getPerformance();

/* Temporary store */
$tmp = [];

/* Iterate performance data entries */
foreach ($perfdata as $key => $value) {
    $tmp[] = $key . '=' . $value;
}

/* Create a nagios parsable performance data string */
$perfstring = implode(', ', $tmp);

/* Get the most important message */
$ent = $report->getMostImportantMessage();

/* If an entry was found it will be used as the status message */
if ($ent !== null) {
    echo NagiosReturnValue::STATUS[$ent->getStatus()] . ': ' . $ent->getMessage() . ' | ' . $perfstring;
    die($ent->getStatus());
}

/* No entry was found, a default message will be used */
echo NagiosReturnValue::STATUS[NagiosReturnValue::UNKNOWN] . ' - Unknown status' . ' | ' . $perfstring;
die(NagiosReturnValue::UNKNOWN);
