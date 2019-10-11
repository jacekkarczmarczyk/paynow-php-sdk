<?php

namespace Paynow\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Paynow\HttpClient\HttpClient;

class TestHttpClient extends HttpClient
{
    public function mockResponse($responseFile, $httpStatus)
    {
        $content = null;
        $response = new Response($httpStatus);
        if ($responseFile != null) {
            $filePath = dirname(__FILE__) . '/resources/' . $responseFile;
            $content = file_get_contents($filePath, true);
            $response = new Response($httpStatus, ['Content-Type' => 'application/json'], $content);
        }

        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handler]);
    }
}