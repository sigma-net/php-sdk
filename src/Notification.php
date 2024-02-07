<?php

namespace SigmaNet\SDK;

use SigmaNet\SDK\Actions\RequestCreator;
use SigmaNet\SDK\Exception\Notification\EmptyApiKeyException;
use SigmaNet\SDK\Exception\Notification\IncorrectBodyRequestException;
use SigmaNet\SDK\Exception\Notification\NotificationParseException;
use SigmaNet\SDK\Exception\Notification\NotificationSecurityException;
use SigmaNet\SDK\Model\Request\NotificationRequest;

class Notification
{
    public const RESPONSE_SUCCESS = 'ok';

    public const RESPONSE_ERROR = 'error';

    private $skipIpCheck = false;

    private $allowedIps = [];

    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string[]
     */
    public function getAllowedIps()
    {
        return $this->allowedIps;
    }

    /**
     * @param string[] $allowedIps
     */
    public function setAllowedIps($allowedIps): void
    {
        $this->allowedIps = $allowedIps;
    }

    /**
     * @param string $allowedIp
     *
     * @return void
     */
    public function addAllowedIp($allowedIp): void
    {
        $this->allowedIps[] = $allowedIp;
    }

    /**
     * @param bool $autoResponse
     *
     * @return NotificationRequest
     *
     * @throws EmptyApiKeyException
     * @throws NotificationSecurityException
     * @throws NotificationParseException
     * @throws IncorrectBodyRequestException
     * @throws \Exception
     */
    public function process($autoResponse = true)
    {
        try {
            $request = $this->getRequest();
            $autoResponse && $this->successResponse();
        } catch (\Exception $e) {
            $autoResponse && $this->errorResponse($e->getMessage());

            throw $e;
        }

        return $request;
    }

    public function successResponse(): void
    {
        $this->response(self::RESPONSE_SUCCESS);
    }

    public function errorResponse($message): void
    {
        $this->response(self::RESPONSE_ERROR, $message);
    }

    public function setSkipIpCheck($skip = true): void
    {
        $this->skipIpCheck = $skip;
    }

    public function isIpCheckSkipped()
    {
        return $this->skipIpCheck;
    }

    /**
     * @return NotificationRequest
     *
     * @throws NotificationSecurityException
     * @throws NotificationParseException
     * @throws IncorrectBodyRequestException
     * @throws EmptyApiKeyException
     */
    protected function getRequest()
    {
        if (empty($this->apiKey)) {
            throw new EmptyApiKeyException('Please provide the api key');
        }

        $this->checkRequest();

        return $this->getRequestFromBody();
    }

    protected function response($status, $message = null)
    {
        $response = [
            'status' => $status,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * @return NotificationRequest
     *
     * @throws NotificationParseException
     * @throws IncorrectBodyRequestException
     */
    protected function getRequestFromBody()
    {
        $body = $this->getBody();

        if (!is_string($body)) {
            throw new IncorrectBodyRequestException('The request body contains an invalid json');
        }

        $body = json_decode($body, true);

        if ($body === null) {
            throw new IncorrectBodyRequestException('The request body contains an invalid json');
        }

        try {
            /** @var NotificationRequest $request */
            $request = RequestCreator::create(NotificationRequest::class, $body);
        } catch (\Exception $e) {
            throw new NotificationParseException('An error occurred while parsing the request');
        }

        return $request;
    }

    /**
     * @throws NotificationSecurityException
     */
    protected function checkRequest()
    {
        if (!empty($_SERVER['HTTP_X_API_SIGNATURE'])) {
            $signature = $_SERVER['HTTP_X_API_SIGNATURE'];
        } else {
            throw new NotificationSecurityException('Empty signature');
        }

        $signature = strtolower($signature);
        $expectedSignature = strtolower(hash('sha256', $this->getBody() . $this->apiKey));

        if ($signature !== $expectedSignature) {
            throw new NotificationSecurityException('Incorrect signature');
        }

        if (strtolower($_SERVER['REQUEST_METHOD']) !== 'post') {
            throw new NotificationSecurityException('Only post requests are expected');
        }

        if (!$this->isIpAllowed()) {
            throw new NotificationSecurityException('Remote ip is not allowed');
        }
    }

    /**
     * @return bool|string
     */
    protected function getBody()
    {
        return file_get_contents('php://input');
    }

    /**
     * @return bool
     */
    protected function isIpAllowed(): bool
    {
        return $this->skipIpCheck || empty($this->allowedIps) || in_array($_SERVER['REMOTE_ADDR'], $this->allowedIps);
    }
}
