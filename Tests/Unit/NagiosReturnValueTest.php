<?php

declare(strict_types=1);

namespace Hschulz\CheckFpm\Tests\Unit;

use Hschulz\CheckFpm\NagiosReturnValue;
use PHPUnit\Framework\TestCase;

/**
 * Description of NagiosReturnValueTest
 */
final class NagiosReturnValueTest extends TestCase
{
    public function testValuesMatchValue(): void
    {
        $this->assertEquals(NagiosReturnValue::OK, 0);
        $this->assertEquals(NagiosReturnValue::WARNING, 1);
        $this->assertEquals(NagiosReturnValue::CRITICAL, 2);
        $this->assertEquals(NagiosReturnValue::UNKNOWN, 3);
    }

    public function testValuesMatchText(): void
    {
        $this->assertEquals(NagiosReturnValue::STATUS[NagiosReturnValue::OK], 'OK');
        $this->assertEquals(NagiosReturnValue::STATUS[NagiosReturnValue::WARNING], 'WARNING');
        $this->assertEquals(NagiosReturnValue::STATUS[NagiosReturnValue::CRITICAL], 'CRITICAL');
        $this->assertEquals(NagiosReturnValue::STATUS[NagiosReturnValue::UNKNOWN], 'UNKNOWN');
    }
}
