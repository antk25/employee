<?php

namespace App\Service;

use DateTime;
use App\Service\Isdayoff;
use App\Service\DatePeriod;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class EmployeeSchedule

{
    const START_DAY = '00:00';

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


    public function __construct(private Isdayoff $isdayoff, private DatePeriod $datePeriod)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getOnScheduleEmployee($startDate, $endDate, $employeeId): array
    {
            $datePeriod = $this->datePeriod->getDatePeriod($startDate, $endDate);

            $result = $this->isdayoff->whatIsDay($datePeriod, true);

            $schedule = array();

            foreach ($result as $item)
            {
               $schedule[] = [
                   "day" => $item,
                   "timeRanges" => [
                       [
                           "start" => $this->employees[$employeeId]['startAm'],
                           "end" => $this->employees[$employeeId]['endAm']
                       ],
                       [
                           "start" => $this->employees[$employeeId]['startPm'],
                           "end" => $this->employees[$employeeId]['endPm']
                       ]
                   ]
               ];
            }

            return $schedule;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */

    public function getOffScheduleEmployee($startDate, $endDate, $employeeId): array
    {
        $datePeriod = $this->datePeriod->getDatePeriod($startDate, $endDate);

        $result = $this->isdayoff->whatIsDay($datePeriod, true);

        $schedule = array();

        foreach ($result as $item)
        {
            $schedule[] = [
                "day" => $item,
                "timeRanges" => [
                    [
                        "start" => self::START_DAY,
                        "end" => $this->employees[$employeeId]['startAm']
                    ],
                    [
                        "start" => $this->employees[$employeeId]['endPm'],
                        "end" => self::START_DAY
                    ]
                ]
            ];
        }

        return $schedule;
    }


}