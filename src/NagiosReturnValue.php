<?php

declare(strict_types=1);

namespace Hschulz\CheckFpm;

/**
 * Interface used to provide return value constants and their string mapping.
 */
interface NagiosReturnValue
{
    /**
     * Return value that indicates an OK.
     * @var int
     */
    public const OK = 0;

    /**
     * Return value that indicates a WARNING.
     * @var int
     */
    public const WARNING = 1;

    /**
     * Return value that indicates a CRITICAL error.
     * @var int
     */
    public const CRITICAL = 2;

    /**
     * Return value that indicates an UNKNOWN state.
     * @var int
     */
    public const UNKNOWN = 3;

    /**
     * Maps the return values to string representations.
     * @var array
     */
    public const STATUS = [
        self::OK => 'OK',
        self::WARNING => 'WARNING',
        self::CRITICAL => 'CRITICAL',
        self::UNKNOWN => 'UNKNOWN'
    ];
}
