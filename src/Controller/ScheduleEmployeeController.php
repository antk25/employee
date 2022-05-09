<?php

namespace App\Controller;

use App\Service\EmployeeSchedule;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ScheduleEmployeeController extends AbstractController

{
    private string $startDate;
    private string $endDate;
    private int $employeeId;



    public function __construct(private EmployeeSchedule $employeeSchedule)
    {

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/employee-schedule', name: 'get_employee_schedule')]
    public function getOnEmployeeSchedule(Request $request): JsonResponse
    {

//        $start = DateTime::createFromFormat('Y-m-d', $request->query->get('start'));
//        $end = DateTime::createFromFormat('Y-m-d', $request->query->get('end'));
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $employeeId = $request->query->get('employeeId');

        return $this->json($this->employeeSchedule->getOnScheduleEmployee($startDate, $endDate, $employeeId));

    }

    #[Route('/employee-schedule-off', name: 'get_employee_schedule_off')]
    public function getOffEmployeeSchedule(Request $request): JsonResponse
    {

        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $employeeId = $request->query->get('employeeId');

        return $this->json($this->employeeSchedule->getOffScheduleEmployee($startDate, $endDate, $employeeId));

    }


}