<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Isdayoff
{
    public function __construct(private HttpClientInterface $httpClient)
    {

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function whatIsDay(array $days, bool $type = true): array
    {
        $daysResult = array();

        foreach ($days as $day)
        {
            $response =  $this->httpClient->request('GET', 'https://isdayoff.ru/'. $day)->getContent();


            switch ($type) {
                case true;
                    if($response == 0)
                    {
                       $daysResult[] = $day;
                    }
                    break;
                case false;
                    if($response == 1)
                    {
                        $daysResult[] = $day;
                    }
                    break;
                default;
            }
        }

        return $daysResult;
    }

}