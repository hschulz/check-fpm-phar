<?php

declare(strict_types=1);

namespace Hschulz\CheckFpm;

/**
 * Interface used to provide constants for cli parameters.
 */
interface Options
{
    /**
     * PHPs getopt syntax that specifies a required value for a parameter.
     * @var string
     */
    public const ARG_REQUIRED = ':';

    /**
     * PHPs getopt syntax that specifies an optional value for a parameter.
     * @var string
     */
    public const ARG_OPTIONAL = '::';

    /**
     * Long name for the help parameter.
     * @var string
     */
    public const HELP_LONG = 'help';

    /**
     * Long name for the version parameter.
     * @var string
     */
    public const VERSION_LONG = 'version';

    /**
     * Short name for the host parameter.
     * @var string
     */
    public const HOST_SHORT = 'h';

    /**
     * Long name for the host parameter.
     * @var string
     */
    public const HOST_LONG = 'host';

    /**
     * Short name for the page parameter.
     * @var string
     */
    public const PAGE_SHORT = 'p';

    /**
     * Long name for the page parameter.
     * @var string
     */
    public const PAGE_LONG = 'page';

    /**
     * Short name for the "use ssl" option.
     * @var string
     */
    public const HTTPS_SHORT = 's';

    /**
     * Long name for the "use ssl" option.
     * @var string
     */
    public const HTTPS_LONG = 'https';

    /**
     * Name for the extended performance data option.
     * @var string
     */
    public const EXTENDED_PERFORMANCE = 'ext-perfdata';
}
