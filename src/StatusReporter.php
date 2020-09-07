<?php

declare(strict_types=1);

namespace Hschulz\CheckFpm;

use Hschulz\CheckFpm\Model\NagiosReport;
use Hschulz\FpmStatus\Analysis\AbstractStatusReporter;
use Hschulz\FpmStatus\Model\Entry;
use Hschulz\FpmStatus\Model\PoolConfig;
use Hschulz\FpmStatus\Model\Status;

/**
 * Description of StatusReporter
 */
class StatusReporter extends AbstractStatusReporter
{
    /**
     *
     * @return NagiosReport
     */
    protected function getReport(): NagiosReport
    {
        return new NagiosReport();
    }

    /**
     *
     * @return Entry|null
     */
    protected function checkListenQueue(): ?Entry
    {
        $entry = parent::checkListenQueue();

        if ($entry === null) {
            return null;
        }

        $entry->setStatus(NagiosReturnValue::CRITICAL);

        return $entry;
    }

    /**
     *
     * @return Entry|null
     */
    protected function checkMaxChildren(): ?Entry
    {
        $entry = parent::checkMaxChildren();

        if ($entry === null) {
            return null;
        }

        $entry->setStatus(NagiosReturnValue::CRITICAL);

        return $entry;
    }

    /**
     *
     * @return Entry|null
     */
    protected function checkMaxListenQueue(): ?Entry
    {
        $entry = parent::checkMaxListenQueue();

        if ($entry === null) {
            return null;
        }

        $entry->setStatus(NagiosReturnValue::WARNING);

        return $entry;
    }

    /**
     *
     * @return Entry|null
     */
    protected function checkSlowRequests(): ?Entry
    {
        $entry = parent::checkSlowRequests();

        if ($entry === null) {
            return null;
        }

        $entry->setStatus(NagiosReturnValue::WARNING);

        return $entry;
    }

    /**
     *
     * @param Status $status
     * @param PoolConfig|null $config
     * @return NagiosReport
     */
    public function generate(Status $status, ?PoolConfig $config = null): NagiosReport
    {
        return parent::generate($status, $config);
    }
}
