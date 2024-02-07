<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SigmaNet\SDK\Exception\TransportException;
use SigmaNet\SDK\Transport\AbstractApiTransport;
use SigmaNet\SDK\Transport\Authorization\TokenAuthorization;
use SigmaNet\SDK\Transport\GuzzleApiTransport;
use PHPUnit\Framework\TestCase;

class GuzzleApiTransportTest extends TestCase
{
    public function testSend()
    {
        $mock = new MockHandler([
            new Response(200),
            new Response(200),
        ]);

        $authToken = new TokenAuthorization('test', 'test');
        $handler = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handler]);
        $transport = new GuzzleApiTransport($guzzleClient);
        $transport->setAuth($authToken);

        try {
            $response = $transport->send('method', AbstractApiTransport::METHOD_GET, [
                'datetime_from' => '2018-01-31T00:00:00',
                'datetime_to' => '2018-02-06T23:59:59',
            ]);
        } catch (TransportException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertEquals(200, $response->getStatusCode());

        try {
            $response = $transport->send('method', AbstractApiTransport::METHOD_POST, [], 'body');
        } catch (TransportException $e) {
            $this->fail($e->getMessage());
        }
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testSendSetAuth()
    {
        $guzzleClient = new Client();
        $transport = new GuzzleApiTransport($guzzleClient);
        $this->setExpectedException(TransportException::class);
        $transport->send('method', AbstractApiTransport::METHOD_GET);
    }
}
