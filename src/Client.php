<?php

namespace SigmaNet\SDK;

use GuzzleHttp\Psr7;
use SigmaNet\SDK\Actions\ObjectRecursiveValidator;
use SigmaNet\SDK\Actions\RequestCreator;
use SigmaNet\SDK\Actions\ResponseCreator;
use SigmaNet\SDK\Exception\ClientIncorrectAuthTypeException;
use SigmaNet\SDK\Exception\JsonParseException;
use SigmaNet\SDK\Exception\Request\RequestParseException;
use SigmaNet\SDK\Exception\Response\ResponseParseException;
use SigmaNet\SDK\Exception\ServerResponse\BadRequestException;
use SigmaNet\SDK\Exception\ServerResponse\ForbiddenException;
use SigmaNet\SDK\Exception\ServerResponse\InternalServerException;
use SigmaNet\SDK\Exception\ServerResponse\NotFoundException;
use SigmaNet\SDK\Exception\ServerResponse\RequestTimeoutException;
use SigmaNet\SDK\Exception\ServerResponse\ResponseException;
use SigmaNet\SDK\Exception\ServerResponse\TooManyRequestsException;
use SigmaNet\SDK\Exception\ServerResponse\UnauthorizedException;
use SigmaNet\SDK\Exception\TransportException;
use SigmaNet\SDK\Model\Request\AbstractRequest;
use SigmaNet\SDK\Model\Request\AbstractRequestTransport;
use SigmaNet\SDK\Model\Request\Payment\ApplePayVerifyRequest;
use SigmaNet\SDK\Model\Request\Payment\ApplePayVerifySerializer;
use SigmaNet\SDK\Model\Request\Payment\ApplePayVerifyTransport;
use SigmaNet\SDK\Model\Request\Payment\CancelPaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\CancelPaymentSerializer;
use SigmaNet\SDK\Model\Request\Payment\CancelPaymentTransport;
use SigmaNet\SDK\Model\Request\Payment\CapturePaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\CapturePaymentSerializer;
use SigmaNet\SDK\Model\Request\Payment\CapturePaymentTransport;
use SigmaNet\SDK\Model\Request\Payment\CreatePaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\CreatePaymentSerializer;
use SigmaNet\SDK\Model\Request\Payment\CreatePaymentTransport;
use SigmaNet\SDK\Model\Request\Payment\GetPaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\GetPaymentSerializer;
use SigmaNet\SDK\Model\Request\Payment\GetPaymentTransport;
use SigmaNet\SDK\Model\Request\Payment\PatchPaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\PatchPaymentSerializer;
use SigmaNet\SDK\Model\Request\Payment\PatchPaymentTransport;
use SigmaNet\SDK\Model\Request\Payment\ProcessPaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\ProcessPaymentSerializer;
use SigmaNet\SDK\Model\Request\Payment\ProcessPaymentTransport;
use SigmaNet\SDK\Model\Request\Payout\CreatePayoutRequest;
use SigmaNet\SDK\Model\Request\Payout\CreatePayoutSerializer;
use SigmaNet\SDK\Model\Request\Payout\CreatePayoutTransport;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutRequest;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutRequestById;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutSbpMembersRequest;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutSbpMembersSerializer;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutSbpMembersTransport;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutSerializer;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutTransport;
use SigmaNet\SDK\Model\Request\Refund\CreateRefundRequest;
use SigmaNet\SDK\Model\Request\Refund\CreateRefundSerializer;
use SigmaNet\SDK\Model\Request\Refund\CreateRefundTransport;
use SigmaNet\SDK\Model\Request\Refund\GetRefundRequest;
use SigmaNet\SDK\Model\Request\Refund\GetRefundSerializer;
use SigmaNet\SDK\Model\Request\Refund\GetRefundTransport;
use SigmaNet\SDK\Model\Request\Reports\PaymentsReportRequest;
use SigmaNet\SDK\Model\Request\Reports\PaymentsReportSerializer;
use SigmaNet\SDK\Model\Request\Reports\PaymentsReportTransport;
use SigmaNet\SDK\Model\Request\Reports\PayoutsReportRequest;
use SigmaNet\SDK\Model\Request\Reports\PayoutsReportSerializer;
use SigmaNet\SDK\Model\Request\Reports\PayoutsReportTransport;
use SigmaNet\SDK\Model\Request\Subscription\GetSubscriptionRequest;
use SigmaNet\SDK\Model\Request\Subscription\GetSubscriptionSerializer;
use SigmaNet\SDK\Model\Request\Subscription\GetSubscriptionTransport;
use SigmaNet\SDK\Model\Request\Wallet\WalletRequest;
use SigmaNet\SDK\Model\Request\Wallet\WalletSerializer;
use SigmaNet\SDK\Model\Response\AbstractResponse;
use SigmaNet\SDK\Model\Response\Payment\ApplePayVerifyResponse;
use SigmaNet\SDK\Model\Response\Payment\CancelPaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\CapturePaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\CreatePaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\GetPaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\ProcessPaymentResponse;
use SigmaNet\SDK\Model\Response\Payout\CreatePayoutResponse;
use SigmaNet\SDK\Model\Response\Payout\GetPayoutResponse;
use SigmaNet\SDK\Model\Response\Payout\GetPayoutSbpMembersResponse;
use SigmaNet\SDK\Model\Response\Refund\CreateRefundResponse;
use SigmaNet\SDK\Model\Response\Refund\GetRefundResponse;
use SigmaNet\SDK\Model\Response\Subscription\GetSubscriptionResponse;
use SigmaNet\SDK\Model\Response\Wallet\WalletResponse;
use SigmaNet\SDK\Transport\AbstractApiTransport;
use SigmaNet\SDK\Transport\Authorization\BasicAuthorization;
use SigmaNet\SDK\Transport\Authorization\TokenAuthorization;
use SigmaNet\SDK\Transport\CurlApiTransport;

class Client
{
    public const VERSION = '1.0.0';

    /** @var AbstractApiTransport */
    private $apiTransport;

    public function __construct(AbstractApiTransport $apiTransport = null)
    {
        $this->apiTransport = $apiTransport;
        if (!$this->apiTransport) {
            $this->apiTransport = new CurlApiTransport();
        }
    }

    /**
     * @param string $login
     * @param string $secret
     * @param string $type
     *
     * @throws ClientIncorrectAuthTypeException
     */
    public function setAuth($login, $secret, $type = TokenAuthorization::class): void
    {
        switch ($type) {
            case TokenAuthorization::class:
                $auth = new TokenAuthorization($login, $secret);
                break;
            case BasicAuthorization::class:
                $auth = new BasicAuthorization($login, $secret);
                break;
            default:
                throw new ClientIncorrectAuthTypeException('Unknown authorization type');
        }

        $this->apiTransport->setAuth($auth);
    }

    /**
     * @param CreatePaymentRequest|AbstractRequest|array $payment
     *
     * @return CreatePaymentResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function createPayment($payment)
    {
        if (is_array($payment)) {
            $payment = RequestCreator::create(CreatePaymentRequest::class, $payment);
        }

        ObjectRecursiveValidator::validate($payment);
        $paymentSerializer = new CreatePaymentSerializer($payment);
        $paymentTransport = new CreatePaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, CreatePaymentResponse::class);
    }

    /**
     * @param PatchPaymentRequest|AbstractRequest|array  $payment
     *
     * @return AbstractResponse
     * @throws ResponseException
     * @throws TransportException
     * @internal
     */
    public function patchPayment($payment)
    {
        if (is_array($payment)) {
            $payment = RequestCreator::create(PatchPaymentRequest::class, $payment);
        }

        ObjectRecursiveValidator::validate($payment);
        $paymentSerializer = new PatchPaymentSerializer($payment);
        $paymentTransport = new PatchPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, GetPaymentResponse::class);
    }

    /**
     * @param ProcessPaymentRequest|AbstractRequest|array $payment
     *
     * @return ProcessPaymentResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function processPayment($payment)
    {
        if (is_array($payment)) {
            $payment = RequestCreator::create(ProcessPaymentRequest::class, $payment);
        }

        ObjectRecursiveValidator::validate($payment);
        $paymentSerializer = new ProcessPaymentSerializer($payment);
        $paymentTransport = new ProcessPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, ProcessPaymentResponse::class);
    }

    /**
     * @param string|GetPaymentRequest $paymentToken
     *
     * @return GetPaymentResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     */
    public function getPayment($paymentToken)
    {
        if (!($paymentToken instanceof GetPaymentRequest)) {
            $paymentToken = new GetPaymentRequest($paymentToken);
        }

        ObjectRecursiveValidator::validate($paymentToken);
        $paymentSerializer = new GetPaymentSerializer($paymentToken);
        $paymentTransport = new GetPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, GetPaymentResponse::class);
    }

    /**
     * @param string|CapturePaymentRequest $paymentToken
     *
     * @return CapturePaymentResponse|AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     * @throws ResponseParseException
     * @throws JsonParseException
     */
    public function capturePayment($paymentToken)
    {
        if (!$paymentToken instanceof CapturePaymentRequest) {
            $paymentToken = new CapturePaymentRequest($paymentToken);
        }

        ObjectRecursiveValidator::validate($paymentToken);
        $paymentSerializer = new CapturePaymentSerializer($paymentToken);
        $paymentTransport = new CapturePaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, CapturePaymentResponse::class);
    }

    /**
     * @param string|CancelPaymentRequest $paymentToken
     * @param string|null                 $reason
     *
     * @return CancelPaymentResponse|AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     * @throws ResponseParseException
     * @throws JsonParseException
     */
    public function cancelPayment($paymentToken, $reason = null)
    {
        if (!$paymentToken instanceof CancelPaymentRequest) {
            $paymentToken = new CancelPaymentRequest($paymentToken);
        }

        if ($reason !== null) {
            $paymentToken->setReason($reason);
        }

        ObjectRecursiveValidator::validate($paymentToken);
        $paymentSerializer = new CancelPaymentSerializer($paymentToken);
        $paymentTransport = new CancelPaymentTransport($paymentSerializer);

        return $this->execute($paymentTransport, CancelPaymentResponse::class);
    }

    /**
     * @param array|CreatePayoutRequest|AbstractRequest $payout
     *
     * @return CreatePayoutResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function createPayout($payout)
    {
        if (is_array($payout)) {
            $payout = RequestCreator::create(CreatePayoutRequest::class, $payout);
        }

        ObjectRecursiveValidator::validate($payout);
        $payoutSerializer = new CreatePayoutSerializer($payout);
        $payoutTransport = new CreatePayoutTransport($payoutSerializer);

        return $this->execute($payoutTransport, CreatePayoutResponse::class);
    }

    /**
     * @param int|array|GetPayoutRequest|GetPayoutRequestById|AbstractRequest $payoutParam
     *
     * @return GetPayoutResponse|AbstractResponse
     *
     * @throws TransportException
     * @throws JsonParseException
     * @throws ResponseException
     * @throws ResponseParseException
     * @throws RequestParseException
     */
    public function getPayout($payoutParam)
    {
        if (is_int($payoutParam)) {
            $payout = new GetPayoutRequestById($payoutParam);
        } elseif (is_array($payoutParam)) {
            $payout = RequestCreator::create(GetPayoutRequest::class, $payoutParam);
        } else {
            $payout = $payoutParam;
        }

        ObjectRecursiveValidator::validate($payout);
        $payoutSerializer = new GetPayoutSerializer($payout);
        $payoutTransport = new GetPayoutTransport($payoutSerializer);

        return $this->execute($payoutTransport, GetPayoutResponse::class);
    }

    /**
     * @param array|GetSubscriptionRequest $subscriptionRequest
     *
     * @return AbstractResponse|GetSubscriptionResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function getSubscription($subscriptionRequest)
    {
        if (is_array($subscriptionRequest)) {
            $subscriptionRequest = RequestCreator::create(GetSubscriptionRequest::class, $subscriptionRequest);
        } elseif (!($subscriptionRequest instanceof GetSubscriptionRequest)) {
            $subscriptionRequest = new GetSubscriptionRequest($subscriptionRequest);
        }

        ObjectRecursiveValidator::validate($subscriptionRequest);
        $serializer = new GetSubscriptionSerializer($subscriptionRequest);
        $transport = new GetSubscriptionTransport($serializer);

        return $this->execute($transport, GetSubscriptionResponse::class);
    }

    /**
     * @param array|CreateRefundRequest $request
     *
     * @return AbstractResponse|CreateRefundResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function createRefund($request)
    {
        if (!($request instanceof CreateRefundRequest)) {
            $request = RequestCreator::create(CreateRefundRequest::class, $request);
        }

        ObjectRecursiveValidator::validate($request);
        $serializer = new CreateRefundSerializer($request);
        $transport = new CreateRefundTransport($serializer);

        return $this->execute($transport, CreateRefundResponse::class);
    }

    /**
     * @param string|array|GetRefundRequest $request
     *
     * @return AbstractResponse|GetRefundResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function getRefund($request)
    {
        if (is_array($request)) {
            $request = RequestCreator::create(GetSubscriptionRequest::class, $request);
        } elseif (!($request instanceof GetRefundRequest)) {
            $request = new GetRefundRequest($request);
        }

        ObjectRecursiveValidator::validate($request);
        $serializer = new GetRefundSerializer($request);
        $transport = new GetRefundTransport($serializer);

        return $this->execute($transport, GetRefundResponse::class);
    }

    /**
     * @param array|PaymentsReportRequest $paymentsReport
     *
     * @return $this|Psr7\MessageTrait
     *
     * @throws TransportException
     */
    public function getPaymentsReport($paymentsReport)
    {
        if (!($paymentsReport instanceof PaymentsReportRequest)) {
            $paymentsReport = RequestCreator::create(PaymentsReportRequest::class, $paymentsReport);
        }

        ObjectRecursiveValidator::validate($paymentsReport);
        $paymentsReportSerializer = new PaymentsReportSerializer($paymentsReport);
        $paymentsReportTransport = new PaymentsReportTransport($paymentsReportSerializer);

        $filename = [];
        $filename[] = 'payments_report';
        $filename[] = $paymentsReport->getDatetimeFrom()->format('Y-m-d-H-i-s');
        $filename[] = '_';
        $filename[] = $paymentsReport->getDatetimeTo()->format('Y-m-d-H-i-s');
        $filename[] = '.csv';

        return $this->download($paymentsReportTransport, join($filename));
    }

    /**
     * @param array|PayoutsReportRequest $payoutsReport
     *
     * @return Psr7\MessageTrait
     * @throws TransportException
     */
    public function getPayoutsReport($payoutsReport)
    {
        if (!($payoutsReport instanceof PayoutsReportRequest)) {
            $payoutsReport = RequestCreator::create(PayoutsReportRequest::class, $payoutsReport);
        }

        ObjectRecursiveValidator::validate($payoutsReport);
        $payoutsReportSerializer = new PayoutsReportSerializer($payoutsReport);
        $payoutsReportTransport = new PayoutsReportTransport($payoutsReportSerializer);

        $filename = [];
        $filename[] = '$payouts_report';
        $filename[] = $payoutsReport->getDatetimeFrom()->format('Y-m-d-H-i-s');
        $filename[] = '_';
        $filename[] = $payoutsReport->getDatetimeTo()->format('Y-m-d-H-i-s');
        $filename[] = '.csv';

        return $this->download($payoutsReportTransport, join($filename));
    }

    /**
     * @param string|WalletRequest $walletRequest
     *
     * @return AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     */
    public function getWalletInfo($walletRequest)
    {
        if (!$walletRequest instanceof WalletRequest) {
            $walletRequest = new WalletRequest($walletRequest);
        }

        ObjectRecursiveValidator::validate($walletRequest);
        $walletSerializer = new WalletSerializer($walletRequest);

        return $this->execute($walletRequest->getTransport($walletSerializer), WalletResponse::class);
    }

    /**
     * @param array|ApplePayVerifyRequest $verifyRequest
     *
     * @return ApplePayVerifyResponse|AbstractResponse
     * @throws ResponseException
     * @throws TransportException
     */
    public function verifyApplePay($verifyRequest)
    {
        if (!($verifyRequest instanceof ApplePayVerifyRequest)) {
            $verifyRequest = new ApplePayVerifyRequest($verifyRequest);
        }

        ObjectRecursiveValidator::validate($verifyRequest);
        $serializer = new ApplePayVerifySerializer($verifyRequest);
        $transport = new ApplePayVerifyTransport($serializer);

        return $this->execute($transport, ApplePayVerifyResponse::class);
    }

    public function getPayoutSbpMembers()
    {
        $request = new GetPayoutSbpMembersRequest();

        ObjectRecursiveValidator::validate($request);
        $serializer = new GetPayoutSbpMembersSerializer($request);
        $transport = new GetPayoutSbpMembersTransport($serializer);

        return $this->execute($transport, GetPayoutSbpMembersResponse::class);
    }

    /**
     * @param AbstractRequestTransport $requestTransport
     * @param string                   $responseType
     *
     * @return AbstractResponse
     *
     * @throws ResponseException
     * @throws TransportException
     * @throws ResponseParseException
     * @throws JsonParseException
     */
    protected function execute(AbstractRequestTransport $requestTransport, $responseType)
    {
        $response = $this->apiTransport->send(
            $requestTransport->getPath(),
            $requestTransport->getMethod(),
            $requestTransport->getQueryParams(),
            $requestTransport->getBodyForRequest(),
            $requestTransport->getHeaders()
        );

        if ($response->getStatusCode() != 200) {
            $this->processError($response); // throw ResponseException
        }

        $body = $response->getBody()->getContents();
        $headers = $response->getHeaders();
        $responseData = json_decode($body, true);

        if (!$responseData) {
            $errorCode = json_last_error();

            if ($errorCode === JSON_ERROR_NONE) {
                $errorCode = -1;
            }

            throw new JsonParseException('Decode response error', $errorCode, $headers ?: [], $body);
        }

        return ResponseCreator::create($responseType, $responseData);
    }

    /**
     * @param AbstractRequestTransport $requestTransport
     * @param string                   $filename
     *
     * @return Psr7\MessageTrait
     *
     * @throws TransportException
     */
    protected function download(AbstractRequestTransport $requestTransport, $filename)
    {
        $response = $this->apiTransport->send(
            $requestTransport->getPath(),
            $requestTransport->getMethod(),
            $requestTransport->getQueryParams(),
            $requestTransport->getBodyForRequest(),
            $requestTransport->getHeaders()
        );

        if ($response->getStatusCode() === 200) {
            return (new Psr7\Response())
                ->withHeader('Content-Type', 'text/csv; charset=utf-8')
                ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->withBody($response->getBody());
        }

        return $response;
    }

    /**
     * @param Psr7\Response $response
     *
     * @throws ResponseException
     */
    protected function processError(Psr7\Response $response)
    {
        $content = $response->getBody()->getContents();

        switch ($response->getStatusCode()) {
            case BadRequestException::HTTP_CODE:
                throw new BadRequestException($response->getHeaders(), $content);
            case UnauthorizedException::HTTP_CODE:
                throw new UnauthorizedException($response->getHeaders(), $content);
            case ForbiddenException::HTTP_CODE:
                throw new ForbiddenException($response->getHeaders(), $content);
            case NotFoundException::HTTP_CODE:
                throw new NotFoundException($response->getHeaders(), $content);
            case RequestTimeoutException::HTTP_CODE:
                throw new RequestTimeoutException($response->getHeaders(), $content);
            case TooManyRequestsException::HTTP_CODE:
                throw new TooManyRequestsException($response->getHeaders(), $content);
            case InternalServerException::HTTP_CODE:
                throw new InternalServerException($response->getHeaders(), $content);
            default:
                throw new ResponseException(
                    'An unknown API error occurred',
                    $response->getStatusCode(),
                    $response->getHeaders(),
                    $content
                );
        }
    }
}
