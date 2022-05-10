<?php

namespace App\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class EmployeeScheduleTest extends TestCase
{

    private array $employees = [
        [
            "employee" => '1',
            "startAm" => '10:00',
            "endAm" => '13:00',
            "startPm" => '14:00',
            "endPm" => '19:00',
        ],
        [
            "employee" => '2',
            "startAm" => '09:00',
            "endAm" => '12:00',
            "startPm" => '13:00',
            "endPm" => '18:00',
        ]

    ];


    private MockObject $isDayOff;
    private MockObject $datePeriod;

    public function setUp(): void
    {
        $this->isDayOff = $this->createMock(Isdayoff::class);
        $this->datePeriod = $this->createMock(DatePeriod::class);
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testGetOnScheduleEmployee(): void
    {

        $this->datePeriod->expects($this->any())
            ->method('getDatePeriod')
            ->willReturn([
                '2022-05-01',
                '2022-05-02',
                '2022-05-03',
                '2022-05-04',
                '2022-05-05',
            ]);

        $this->isDayOff->expects($this->any())
            ->method('whatIsDay')
            ->willReturn(['2022-05-05']);

        $service = new EmployeeSchedule($this->isDayOff, $this->datePeriod);

        $expects = [
            [
            'day' => '2022-05-05',
            'timeRanges' => [
                    [
                        'start' => '09:00',
                        'end' => '12:00'
                    ],
                    [
                        'start' => '13:00',
                        'end' => '18:00'
                    ],
                ]
            ]
        ];

        $result = $service->getOnScheduleEmployee('2022-05-01', '2022-05-05', 1);

        $this->assertEquals($expects, $result);

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testGetOffScheduleEmployee(): void
    {

        $this->datePeriod->expects($this->any())
            ->method('getDatePeriod')
            ->willReturn([
                '2022-05-01',
                '2022-05-02',
                '2022-05-03',
                '2022-05-04',
                '2022-05-05',
            ]);

        $this->isDayOff->expects($this->any())
            ->method('whatIsDay')
            ->willReturn(['2022-05-05']);

        $service = new EmployeeSchedule($this->isDayOff, $this->datePeriod);

        $expects = [
            [
                'day' => '2022-05-05',
                'timeRanges' => [
                    [
                        'start' => '00:00',
                        'end' => '09:00'
                    ],
                    [
                        'start' => '18:00',
                        'end' => '00:00'
                    ],
                ]
            ]
        ];

        $result = $service->getOffScheduleEmployee('2022-05-01', '2022-05-05', 1);

        $this->assertEquals($expects, $result);

    }

}
