<?php

namespace App\Service;

class DatePeriod
{
    const DAY = 86400;

    public function getDatePeriod($startDate, $endDate, $format = 'Y-m-d'): array
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $numDays = round(($endDate - $startDate) / self::DAY) + 1;

        $days = array();

        for ($i = 1; $i < $numDays; $i++) {
            $days[] = date($format, ($startDate + ($i * self::DAY)));
        }

        return $days;
    }


}