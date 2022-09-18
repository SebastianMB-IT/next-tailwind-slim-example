<?php

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/lib.php';

use PHPUnit\Framework\TestCase;

class libTest extends TestCase
{
    public function testLib(): void
    {
        $flights = get_cheapest_flight('BLQ', 'LHR');
        $this->assertNotEmpty($flights, 'flights is not empty');
    }
}
