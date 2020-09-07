<?php

declare(strict_types=1);

namespace Hschulz\CheckFpm\Model;

use Hschulz\CheckFpm\NagiosReturnValue;
use Hschulz\FpmStatus\Model\Entry;
use Hschulz\FpmStatus\Model\Report;

/**
 * Extends the default report class with a method to find the most important
 * message that should be used to display the status for nagios.
 */
class NagiosReport extends Report
{
    /**
     * Returns the most important message from the list of entries.
     * Order of importance is: CRITICAL, WARNING, UNKNOWN, OK
     *
     * @return Entry|null The most important entry or null
     */
    public function getMostImportantMessage(): ?Entry
    {
        /* Iterate all entries */
        foreach ($this->entries as $data) {

            /* Return by importance */
            if (isset($data[NagiosReturnValue::CRITICAL])) {
                return $data[NagiosReturnValue::CRITICAL][0] ?? null;
            } elseif (isset($data[NagiosReturnValue::WARNING])) {
                return $data[NagiosReturnValue::WARNING][0] ?? null;
            } elseif (isset($data[NagiosReturnValue::UNKNOWN])) {
                return $data[NagiosReturnValue::UNKNOWN] ?? null;
            } elseif ($data[NagiosReturnValue::OK]) {
                return $data[NagiosReturnValue::OK][0] ?? null;
            }
        }

        return null;
    }
}
