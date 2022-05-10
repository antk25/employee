<?php

namespace App\Tests\Functional\Controller;

use App\Tests\AbstractControllerTest;

class ScheduleEmployeeControllerTest extends AbstractControllerTest
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

    public function test_get_employee_schedule(): void
    {
        $this->client->request('GET', '/employee-schedule?startDate=2022-05-05&endDate=2022-05-06&employeeId=1');

        $responseContent = $this->client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();

        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/responses/getEmployeeSchedule.json', $responseContent);

    }

}