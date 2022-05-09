<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ScheduleEmployeeControllerTest extends WebTestCase
{
    public function test_get_employee_schedule(): void
    {
        $client = static::createClient();

        $client->request('GET', '/employee-schedule?startDate=2022-02-01&endDate=2022-02-10&employeeId=0');

        $this->assertResponseIsSuccessful();

        $jsonResult = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('from', $jsonResult);

    }

}