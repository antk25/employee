<?php

namespace App\Tests\Service;

use App\Service\DatePeriod;
use PHPUnit\Framework\TestCase;

class DatePeriodTest extends TestCase
{

    public function testGetDatePeriod(): void
    {
        $startDate = '2022-05-01';
        $endDate = '2022-05-05';

        $service = new DatePeriod();

        $expected = [
            '2022-05-01',
            '2022-05-02',
            '2022-05-03',
            '2022-05-04',
            '2022-05-05'
        ];

        $this->assertEquals($expected, $service->getDatePeriod($startDate, $endDate));

    }
}
