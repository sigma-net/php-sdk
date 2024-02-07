<?php


namespace Tests\SigmaNet\SDK;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SigmaNet\SDK\Client;
use SigmaNet\SDK\Exception\JsonParseException;
use SigmaNet\SDK\Exception\Validation\EmptyRequiredPropertyException;
use SigmaNet\SDK\Exception\Validation\InvalidPropertyException;
use SigmaNet\SDK\Model\PaymentMethods;
use SigmaNet\SDK\Model\PayoutStatuses;
use SigmaNet\SDK\Model\Request\Item\FeeItem;
use SigmaNet\SDK\Model\Request\Item\ItemsReceiptRequestItem;
use SigmaNet\SDK\Model\Request\Item\OrderRequestItem;
use SigmaNet\SDK\Model\Request\Item\PaymentMethodDataItem;
use SigmaNet\SDK\Model\Request\Item\PayoutMethodDataItem;
use SigmaNet\SDK\Model\Request\Item\ReceiptRequestItem;
use SigmaNet\SDK\Model\Request\Item\RefundReceiptRequestItem;
use SigmaNet\SDK\Model\Request\Item\RefundRequestItem;
use SigmaNet\SDK\Model\Request\Item\SettingsRequestItem;
use SigmaNet\SDK\Model\Request\Payment\CancelPaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\CapturePaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\CreatePaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\GetPaymentRequest;
use SigmaNet\SDK\Model\Request\Payment\ProcessPaymentRequest;
use SigmaNet\SDK\Model\Request\Payout\CreatePayoutRequest;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutRequest;
use SigmaNet\SDK\Model\Request\Payout\GetPayoutRequestById;
use SigmaNet\SDK\Model\Request\Refund\CreateRefundRequest;
use SigmaNet\SDK\Model\Request\Refund\GetRefundRequest;
use SigmaNet\SDK\Model\Request\Subscription\GetSubscriptionRequest;
use SigmaNet\SDK\Model\Response\Item\AuthorizationItem;
use SigmaNet\SDK\Model\Response\Item\CardItem;
use SigmaNet\SDK\Model\Response\Item\ErrorDetailsItem;
use SigmaNet\SDK\Model\Response\Item\MoneyItem;
use SigmaNet\SDK\Model\Response\Item\OrderResponseItem;
use SigmaNet\SDK\Model\Response\Item\PaymentItem;
use SigmaNet\SDK\Model\Response\Item\PaymentMethodItem;
use SigmaNet\SDK\Model\Response\Item\PayoutMethodItem;
use SigmaNet\SDK\Model\Response\Item\RefundResponseItem;
use SigmaNet\SDK\Model\Response\Item\WalletPayoutResponseItem;
use SigmaNet\SDK\Model\Response\Item\WalletResponseItem;
use SigmaNet\SDK\Model\Response\Payment\CancelPaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\CapturePaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\CreatePaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\GetPaymentResponse;
use SigmaNet\SDK\Model\Response\Payment\ProcessPaymentResponse;
use SigmaNet\SDK\Model\Response\Payout\CreatePayoutResponse;
use SigmaNet\SDK\Model\Response\Payout\GetPayoutResponse;
use SigmaNet\SDK\Model\Response\Refund\CreateRefundResponse;
use SigmaNet\SDK\Model\Response\Refund\GetRefundResponse;
use SigmaNet\SDK\Model\Response\Subscription\GetSubscriptionResponse;
use SigmaNet\SDK\Transport\GuzzleApiTransport;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    protected static function generateClient(MockHandler $mock)
    {
        $handler = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new GuzzleApiTransport($guzzleClient);
        $client = new Client($apiClient);
        $client->setAuth('test', 'test');

        return $client;
    }

    /**
     * @dataProvider createPaymentProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCreatePaymentFromArray($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/createPaymentFixture.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);

        $createPaymentResponse = $client->createPayment($data);
        $this->assertInstanceOf(CreatePaymentResponse::class, $createPaymentResponse);
        $this->assertEquals($expectedContent['id'], $createPaymentResponse->getId());
        $this->assertEquals($expectedContent['token'], $createPaymentResponse->getToken());
        $this->assertInstanceOf(\DateTime::class, $createPaymentResponse->getCreateDate());
        $this->assertEquals(new \DateTime($expectedContent['create_date']), $createPaymentResponse->getCreateDate());
        $this->assertInstanceOf(\DateTime::class, $createPaymentResponse->getExpireDate());
        $this->assertEquals(new \DateTime($expectedContent['expire_date']), $createPaymentResponse->getExpireDate());
        $this->assertEquals($expectedContent['status'], $createPaymentResponse->getStatus());
        $this->assertEquals($expectedContent['payment_url'], $createPaymentResponse->getPaymentUrl());

        $this->assertArrayHasKey('email', $createPaymentResponse->getCustomParameters());
        $this->assertArrayHasKey('order_id', $createPaymentResponse->getCustomParameters());

        $this->assertInstanceOf(OrderResponseItem::class, $createPaymentResponse->getOrder());
        $this->assertEquals($expectedContent['order']['amount'], $createPaymentResponse->getOrder()->getAmount());
        $this->assertEquals($expectedContent['order']['currency'], $createPaymentResponse->getOrder()->getCurrency());
        $this->assertEquals($expectedContent['order']['description'], $createPaymentResponse->getOrder()->getDescription());

        $this->assertInstanceOf(WalletResponseItem::class, $createPaymentResponse->getWallet());
        $this->assertEquals($expectedContent['wallet']['id'], $createPaymentResponse->getWallet()->getId());
        $this->assertEquals($expectedContent['wallet']['amount'], $createPaymentResponse->getWallet()->getAmount());
        $this->assertEquals($expectedContent['wallet']['currency'], $createPaymentResponse->getWallet()->getCurrency());

        $this->assertInstanceOf(MoneyItem::class, $createPaymentResponse->getPayer());
        $this->assertEquals($expectedContent['payer']['amount'], $createPaymentResponse->getPayer()->getAmount());
        $this->assertEquals($expectedContent['payer']['currency'], $createPaymentResponse->getPayer()->getCurrency());

        $this->assertInstanceOf(MoneyItem::class, $createPaymentResponse->getExtra());
        $this->assertEquals($expectedContent['extra']['amount'], $createPaymentResponse->getExtra()->getAmount());
        $this->assertEquals($expectedContent['extra']['currency'], $createPaymentResponse->getExtra()->getCurrency());
    }

    /**
     * @dataProvider processPaymentProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testProcessPayment($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/processPaymentFixture.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);

        $processPaymentResponse = $client->processPayment($data);

        $this->assertInstanceOf(ProcessPaymentResponse::class, $processPaymentResponse);
        $this->checkPaymentResponse($expectedContent, $processPaymentResponse);

        $this->assertInstanceOf(AuthorizationItem::class, $processPaymentResponse->getAuthorization());
        $this->assertEquals($expectedContent['authorization']['action'], $processPaymentResponse->getAuthorization()->getAction());
        $this->assertEquals($expectedContent['authorization']['method'], $processPaymentResponse->getAuthorization()->getMethod());
        $this->assertEquals($expectedContent['authorization']['params'], $processPaymentResponse->getAuthorization()->getParams());

        $this->assertInstanceOf(MoneyItem::class, $processPaymentResponse->getPayer());
        $this->assertEquals($expectedContent['payer']['amount'], $processPaymentResponse->getPayer()->getAmount());
        $this->assertEquals($expectedContent['payer']['currency'], $processPaymentResponse->getPayer()->getCurrency());

        $this->assertInstanceOf(MoneyItem::class, $processPaymentResponse->getExtra());
        $this->assertEquals($expectedContent['extra']['amount'], $processPaymentResponse->getExtra()->getAmount());
        $this->assertEquals($expectedContent['extra']['currency'], $processPaymentResponse->getExtra()->getCurrency());

        $this->assertArrayHasKey('email', $processPaymentResponse->getCustomParameters());
        $this->assertArrayHasKey('order_id', $processPaymentResponse->getCustomParameters());
    }

    /**
     * @dataProvider processPaymentProviderEmptyRequired
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testProcessPaymentFailRequired($data)
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);

        $client = self::generateClient($mock);

        $this->setExpectedException(EmptyRequiredPropertyException::class);
        $client->processPayment($data);
    }

    /**
     * @dataProvider processPaymentProviderInvalidFields
     *
     * @param array $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testProcessPaymentFailTypes($data)
    {
        $mock = new MockHandler([
            new Response(200, []),
        ]);

        $client = self::generateClient($mock);

        $this->setExpectedException(InvalidPropertyException::class);
        $client->processPayment($data);
    }

    /**
     * @dataProvider capturePaymentProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCapturePayment($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/getPaymentFixture.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);

        $capturePaymentResponse = $client->capturePayment($data);
        $this->assertInstanceOf(CapturePaymentResponse::class, $capturePaymentResponse);
        $this->checkPaymentResponse($expectedContent, $capturePaymentResponse);
    }

    /**
     * @dataProvider getPaymentProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testGetPayment($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/getPaymentFixture.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $getPaymentResponse = $client->getPayment($data);

        $this->assertInstanceOf(GetPaymentResponse::class, $getPaymentResponse);
        $this->checkPaymentResponse($expectedContent, $getPaymentResponse);
    }

    /**
     * @dataProvider cancelPaymentProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCancelPayment($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/getPaymentFixture.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $cancelPayment = $client->cancelPayment($data);

        $this->assertInstanceOf(CancelPaymentResponse::class, $cancelPayment);
        $this->checkPaymentResponse($expectedContent, $cancelPayment);
    }

    /**
     * @dataProvider getPaymentProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testGetPaymentError($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/getErrorPaymentFixture.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $getPaymentResponse = $client->getPayment($data);

        $this->assertInstanceOf(GetPaymentResponse::class, $getPaymentResponse);
        $this->checkPaymentResponse($expectedContent, $getPaymentResponse);
    }

    /**
     * @dataProvider createPayoutProvider
     *
     * @param $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCreatePayout($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/payout.json');
        $expectedContent = json_decode($jsonPaymentString, true);

        if ($data instanceof CreatePayoutRequest) {
            $expectedContent['description'] = $data->getOrder()->getDescription();
            $expectedContent['custom_parameters'] = $data->getCustomParameters();
        } else {
            $expectedContent['description'] = empty($data['order']['description']) ? null : $data['order']['description'];
            $expectedContent['custom_parameters'] = empty($data['custom_parameters']) ? null : $data['custom_parameters'];
        }

        $jsonPaymentString = json_encode($expectedContent);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $createPayout = $client->createPayout($data);
        $this->assertInstanceOf(CreatePayoutResponse::class, $createPayout);
        $this->checkPayoutResponse($expectedContent, $createPayout);
    }

    /**
     * @dataProvider createPayoutInvPropProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCreatePayoutInvProp($data)
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);

        $client = self::generateClient($mock);
        $this->setExpectedException(InvalidPropertyException::class);
        $client->createPayout($data);
    }

    /**
     * @dataProvider createPayoutInvRequiredProvider
     *
     * @param $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCreatePayoutInvRequired($data)
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);

        $client = self::generateClient($mock);
        $this->setExpectedException(EmptyRequiredPropertyException::class);
        $client->createPayout($data);
    }

    /**
     * @dataProvider createPayoutUnexpectedValueProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     * @throws \Exception
     */
    public function testCreatePayoutUnexpectedValue($data)
    {

        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);

        $client = self::generateClient($mock);
        $this->setExpectedException(\UnexpectedValueException::class);

        try {
            $client->createPayout($data);
        } catch (JsonParseException $e) {
            throw new \Exception('stub');
        }
    }

    /**
     * @dataProvider getSubscriptionProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testGetSubscription($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/subscription.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $subscription = $client->getSubscription($data);
        $this->assertInstanceOf(GetSubscriptionResponse::class, $subscription);
        $this->assertInstanceOf(PaymentItem::class, $subscription->getParentPayment());
        $this->assertEquals(count($expectedContent['payments']), count($subscription->getPayments()));
        $this->assertEquals($expectedContent['token'], $subscription->getToken());
        $this->assertEquals($expectedContent['status'], $subscription->getStatus());
    }

    /**
     * @dataProvider createRefundProvider
     *
     * @param array $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testCreateRefund($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/refund.json');
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);
        $client = self::generateClient($mock);
        $refund = $client->createRefund($data);
        $this->assertInstanceOf(CreateRefundResponse::class, $refund);
    }

    /**
     * @dataProvider getRefundProvider
     *
     * @param mixed $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testGetRefund($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/refund.json');
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);
        $client = self::generateClient($mock);
        $refund = $client->getRefund($data);
        $this->assertInstanceOf(GetRefundResponse::class, $refund);
    }

    /**
     * @dataProvider getPayoutProvider
     *
     * @param $data
     *
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testGetPayout($data)
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/payout.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $getPayout = $client->getPayout($data);
        $this->assertInstanceOf(GetPayoutResponse::class, $getPayout);
        $this->checkPayoutResponse($expectedContent, $getPayout);
    }

    /**
     * @throws \SigmaNet\SDK\Exception\ServerResponse\ResponseException
     * @throws \SigmaNet\SDK\Exception\TransportException
     */
    public function testGetPayoutError()
    {
        $jsonPaymentString = file_get_contents(__DIR__ . '/Fixtures/payout_error.json');
        $expectedContent = json_decode($jsonPaymentString, true);
        $mock = new MockHandler([
            new Response(200, [], $jsonPaymentString),
        ]);

        $client = self::generateClient($mock);
        $getPayout = $client->getPayout([
            'transaction_id' => '123',
            'wallet_id' => 1,
        ]);
        $this->assertInstanceOf(GetPayoutResponse::class, $getPayout);
        $this->assertEquals(PayoutStatuses::STATUS_ERROR, $getPayout->getStatus());
        $this->assertInstanceOf(ErrorDetailsItem::class, $getPayout->getErrorDetails());
        $this->assertEquals($expectedContent['error_details']['error'], $getPayout->getErrorDetails()->getError());
        $this->assertEquals($expectedContent['error_details']['description'], $getPayout->getErrorDetails()->getDescription());
    }

    public function createPaymentProvider()
    {
        $createPayoutRequestAll = new CreatePaymentRequest();
        $order = new OrderRequestItem();
        $order
            ->setCurrency('USD')
            ->setAmount(9999.999)
            ->setDescription('Discount right now!');
        $settings = new SettingsRequestItem();
        $settings
            ->setExpireDate(new \DateTime())
            ->setLocale('ru')
            ->setWalletId(1234567890)
            ->setPaymentMethod(PaymentMethods::PAYMENT_METHOD_CARD)
            ->setFailUrl('http://fail')
            ->setBackUrl('http://back')
            ->setSuccessUrl('http://success')
            ->setProjectId(998877);
        $receipt = new ReceiptRequestItem();
        $receipt
            ->setPlace('https://some.place.order')
            ->setEmail('none@none')
            ->setPhone('79991234567');

        $taxes = ItemsReceiptRequestItem::getAvailableTaxes();
        for ($i = 0; $i <= 100; $i++) {
            $receiptItem = new ItemsReceiptRequestItem();
            $receiptItem
                ->setTax($taxes[$i % count($taxes)])
                ->setSum(5.789 + $i * 10)
                ->setQuantity(0.23 + $i)
                ->setPrice(0.9 + $i)
                ->setName('Product ' . $i);
            $receipt->addItem($receiptItem);
        }

        $createPayoutRequestAll
            ->setOrder($order)
            ->setSettings($settings)
            ->setCustomParameters([
                'email' => 'none',
                'test' => 'yes',
            ]);


        $createPayoutRequestRequired = new CreatePaymentRequest();
        $order = new OrderRequestItem();
        $order
            ->setAmount(1000.0001)
            ->setCurrency('RUB');
        $settings = new SettingsRequestItem();
        $settings->setProjectId(1);
        $createPayoutRequestRequired
            ->setOrder($order)
            ->setSettings($settings);

        return [
            [
                [
                    'order' => [
                        'currency' => 'RUB',
                        'amount' => 10.00,
                        'description' => 'test',
                    ],
                    'settings' => [
                        'project_id' => 1,
                        'payment_method' => 'card',
                        'success_url' => 'http://site.com/?success',
                        'fail_url' => 'http://site.com/?fail',
                        'back_url' => 'http://site.com/?back',
                        'locale' => 'en',
                    ],
                    'custom_parameters' => [
                        'email' => 'vasia@gmail.com',
                        'order_id' => '515',
                    ],
                    'receipt' => [
                        'items' => [
                            [
                                'name' => 'Товар 1',
                                'price' => 125.5,
                                'quantity' => 0.5,
                                'tax' => 'vat0',
                            ],
                        ],
                        'email' => 'vasia@gmail.com',
                        'place' => 'http://site.ru',
                    ],
                ],
            ],
            [
                [
                    'order' => [
                        'currency' => 'RUB',
                        'amount' => 10.00,
                        'description' => 'test',
                    ],
                    'settings' => [
                        'project_id' => 1,
                        'payment_method' => 'card',
                        'success_url' => 'http://site.com/?success',
                        'fail_url' => 'http://site.com/?fail',
                        'back_url' => 'http://site.com/?back',
                        'locale' => 'en',
                        'create_subscription' => true,
                        'subscription_token' => 'subscription-token',
                    ],
                    'custom_parameters' => [
                        'email' => 'vasia@gmail.com',
                        'order_id' => '515',
                    ],
                    'receipt' => [
                        'items' => [
                            [
                                'name' => 'Товар 1',
                                'price' => 125.5,
                                'quantity' => 0.5,
                                'tax' => 'vat0',
                            ],
                        ],
                        'email' => 'vasia@gmail.com',
                        'place' => 'http://site.ru',
                    ],
                ],
            ],
            [
                $createPayoutRequestAll,
            ],
            [
                $createPayoutRequestRequired,
            ],
        ];
    }

    public function processPaymentProvider()
    {
        $processPaymentCard = new ProcessPaymentRequest();
        $paymentMethodDataItem = new PaymentMethodDataItem();
        $paymentMethodDataItem
            ->setType(PaymentMethods::PAYMENT_METHOD_CARD)
            ->setCardNumber('5200000000000000')
            ->setCardMonth('02')
            ->setCardYear('25')
            ->setCardSecurity('321');
        $processPaymentCard
            ->setIp('127.0.0.1')
            ->setToken('1-62aebd0e3a-3dae1e0976-73f96a4432')
            ->setPaymentMethodData($paymentMethodDataItem);

        $processPaymentQIWI = new ProcessPaymentRequest();
        $paymentMethodDataItem = new PaymentMethodDataItem();
        $paymentMethodDataItem
            ->setType(PaymentMethods::PAYMENT_METHOD_QIWI)
            ->setAccount('123456789012345678')
            ->setCapture(true);
        $processPaymentQIWI
            ->setIp('192.168.0.1')
            ->setToken('1-62aebd0e3a-3dae850976-73f96a4432')
            ->setPaymentMethodData($paymentMethodDataItem);

        return [
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_CARD,
                        'card_number' => '4200000000000000',
                        'card_month' => '03',
                        'card_year' => '19',
                        'card_security' => '123',
                        'capture' => true,
                    ],
                ],
            ],
            [
                [
                    'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '127.0.0.1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_QIWI,
                        'account' => '4200000000000000',
                    ],
                ],
            ],
            [
                [
                    'token' => '3-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '127.0.0.1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_WEBMONEY,
                    ],
                ],
            ],
            [
                [
                    'token' => '4-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '127.0.0.1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_WEBMONEY,
                        'purse_type' => PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_P,
                    ],
                ],
            ],
            [
                [
                    'token' => '5-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '127.0.0.1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_WEBMONEY,
                        'purse_type' => PaymentMethodDataItem::WEBMONEY_WALLET_PURSE_R,
                    ],
                ],
            ],
            [$processPaymentCard],
            [$processPaymentQIWI],
            [
                [
                    "token" => "6-62aebd0e3a-3dae1e0976-73f96a4bc1",
                    "ip" => "127.0.0.1",
                    "payment_method_data" => [
                        "type" => "tokenized",
                        "token_data" => "123456",
                        "token_type" => "googlepay",
                    ],
                ],
            ],
        ];
    }

    public function processPaymentProviderEmptyRequired()
    {
        return [
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_CARD,
                        'card_number' => '4200000000000000',
                        'card_security' => '123',
                    ],
                ],
            ],
            [
                [
                    'ip' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_CARD,
                        'card_number' => '4200000000000000',
                        'card_month' => '03',
                        'card_year' => '19',
                        'card_security' => '123',
                    ],
                ],
            ],
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_CARD,
                        'card_number' => '4200000000000000',
                        'card_month' => '03',
                        'card_year' => '19',
                        'card_security' => '123',
                    ],
                ],
            ],
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
                    'payment_method_data' => [
                        'card_number' => '4200000000000000',
                        'card_month' => '03',
                        'card_year' => '19',
                        'card_security' => '123',
                    ],
                ],
            ],
        ];
    }

    public function processPaymentProviderInvalidFields()
    {
        return [
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '120.0.0.1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_WEBMONEY,
                        'purse_type' => 'INCORRECT_PURSE_TYPE',
                    ],
                ],
            ],
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'ip' => '120.0.0.1',
                    'payment_method_data' => [
                        'type' => PaymentMethods::PAYMENT_METHOD_WEBMONEY,
                        'purse_type' => 'INCORRECT_PURSE_TYPE2',
                    ],
                ],
            ],
        ];
    }

    public function getPaymentProvider()
    {
        return [
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
            ],
            [new GetPaymentRequest('1-62aebd0e3a-3dae1e0976-73f96a4bc2')],
        ];
    }

    public function capturePaymentProvider()
    {
        return [
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
            ],
            [new CapturePaymentRequest('3-62aebd0e3a-3dae1e0976-73f96a4bc2')],
        ];
    }

    public function cancelPaymentProvider()
    {
        return [
            [
                'token' => '4-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'reason' => 'Some reason',
            ],
            [new CancelPaymentRequest('5-62aebd0e3a-3dae1e0976-73f96a4bc2')],
        ];
    }

    public function createPayoutProvider()
    {
        $createPayout = new CreatePayoutRequest();
        $payoutMethodData = new PayoutMethodDataItem();
        $payoutMethodData
            ->setAccount('12345678')
            ->setType('qiwi');

        $orderRequest = new OrderRequestItem();
        $orderRequest
            ->setAmount(1000.111)
            ->setCurrency('RUB');

        $createPayout
            ->setTransactionId('qqqqqqqqq')
            ->setWalletId(11111111)
            ->setFeeType('payout')
            ->setPayoutMethodData($payoutMethodData)
            ->setOrder($orderRequest);

        return [
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '7-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'wallet_id' => 123,
                    'fee_type' => 'wallet',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => 12345678,
                    'wallet_id' => 123,
                    'fee_type' => 'wallet',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '8-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                        'description' => 'text description',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '9-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                        'description' => 'text description',
                    ],
                    'custom_parameters' => null,
                ],
            ],
            [
                [
                    'transaction_id' => '9-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                        'description' => 'text description',
                    ],
                    'custom_parameters' => [],
                ],
            ],
            [
                [
                    'transaction_id' => '9-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                        'description' => 'text description',
                    ],
                    'custom_parameters' => [
                        'email' => 'text@email.develop',
                    ],
                ],
            ],
            [$createPayout],
        ];
    }

    public function createPayoutInvPropProvider()
    {
        return [
            [
                [
                    'transaction_id' => '1',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'fee_type' => 'fee_type',
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
        ];
    }

    public function createPayoutUnexpectedValueProvider()
    {
        return [
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => 1,
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => 'qwer',
                ],
            ],
            [
                [
                    'transaction_id' => true,
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => [],
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '[]',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 'amount',
                        'currency' => 'rub',
                    ],
                ],
            ],
        ];
    }

    public function createPayoutInvRequiredProvider()
    {
        return [
            [
                [
                    'transaction_id' => 0,
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => null,
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => 'fwefwef',
                    'payout_method_data' => [
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ], [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                    ],
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'order' => [
                        'amount' => 123.45,
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'currency' => 'rub',
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                    'order' => [
                        'amount' => 123.45,
                    ],
                ],
            ],
            [
                [
                    'transaction_id' => '6-62aebd0e3a-3dae1e0976-73f96a4bc2',
                    'payout_method_data' => [
                        'type' => 'card',
                        'account' => '12345',
                    ],
                ],
            ],
        ];
    }

    public function getPayoutProvider()
    {
        $getPayoutRequest = new GetPayoutRequest();
        $getPayoutRequest
            ->setWalletId(100000)
            ->setTransactionId('0b11111111');

        return [
            [
                1,
            ],
            [
                [
                    'transaction_id' => 'someid',
                    'wallet_id' => 1000009999999999999,
                ],
            ],
            [
                $getPayoutRequest,
            ],
            [
                new GetPayoutRequestById(1),
            ],
            [
                new GetPayoutRequestById(999999999999999999),
            ],
        ];
    }

    public function getSubscriptionProvider()
    {
        return [
            [
                '123432-token-token-token',
            ],
            [
                [
                    'token' => '123432-token-token-token',
                ],
            ],
            [
                new GetSubscriptionRequest('1234567'),
            ],
        ];
    }

    public function getRefundProvider()
    {
        return [
            [
                '941-64b901f656-fb9c727eeb-a03c327d40',
            ],
            [
                [
                    'token' => '123432-token-token-token',
                ],
            ],
            [
                new GetRefundRequest('token-token-token-token'),
            ],
        ];
    }


    public function createRefundProvider()
    {
        $createRefundResponse = new CreateRefundRequest();
        $refund = new RefundRequestItem();
        $refund
            ->setAmount(10.5)
            ->setCurrency('RUB')
            ->setReason('Refund payment');
        $receipt = new RefundReceiptRequestItem();
        $items = [];

        $taxes = ItemsReceiptRequestItem::getAvailableTaxes();
        for ($i = 0; $i <= 10; $i++) {
            $receiptItem = new ItemsReceiptRequestItem();
            $receiptItem
                ->setTax($taxes[$i % count($taxes)])
                ->setSum(2.79 + $i * 10)
                ->setQuantity(0.1 + $i)
                ->setPrice(0.2 + $i)
                ->setName('Product ' . $i);
            $items[] = $receiptItem;
        }

        $receipt->setItems($items);
        $createRefundResponse
            ->setToken('12345678')
            ->setRefund($refund)
            ->setReceipt($receipt);

        return [
            [
                [
                    'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                    'refund' => [
                        'amount' => 5,
                        'currency' => 'RUB',
                        'reason' => 'Refund payment #123',
                    ],
                    'receipt' => [
                        'items' => [
                            [
                                'name' => 'Товар 1',
                                'price' => 5,
                                'quantity' => 1,
                                'tax' => 'vat0',
                            ],
                        ],
                    ],
                ],
            ],
            [
                $createRefundResponse,
            ],
        ];
    }


    /**
     * @param array             $expectedContent
     * @param OrderResponseItem $order
     */
    private function checkOrderItem($expectedContent, $order)
    {
        $this->assertInstanceOf(OrderResponseItem::class, $order);
        $this->assertEquals($expectedContent['amount'], $order->getAmount());
        $this->assertEquals($expectedContent['currency'], $order->getCurrency());
        $this->assertEquals($expectedContent['description'], $order->getDescription());
    }


    /**
     * @param array              $expectedContent
     * @param RefundResponseItem $refund
     */
    private function checkRefundItem($expectedContent, $refund)
    {
        $this->assertInstanceOf(RefundResponseItem::class, $refund);
        $this->assertEquals($expectedContent['amount'], $refund->getAmount());
        $this->assertEquals($expectedContent['currency'], $refund->getCurrency());
        $this->assertEquals($expectedContent['reason'], $refund->getReason());
    }


    /**
     * @param array              $expectedContent
     * @param WalletResponseItem $wallet
     */
    private function checkWalletItem($expectedContent, $wallet)
    {
        /* @var WalletResponseItem $wallet */
        $this->assertInstanceOf(WalletResponseItem::class, $wallet);
        $this->assertEquals($expectedContent['id'], $wallet->getId());
        $this->assertEquals($expectedContent['amount'], $wallet->getAmount());
        $this->assertEquals($expectedContent['currency'], $wallet->getCurrency());
    }


    /**
     * @param array             $expectedContent
     * @param PaymentMethodItem $paymentMethod
     */
    private function checkPaymentMethodItem($expectedContent, $paymentMethod)
    {
        $this->assertInstanceOf(PaymentMethodItem::class, $paymentMethod);
        $this->assertEquals($expectedContent['type'], $paymentMethod->getType());
        $this->assertEquals($expectedContent['account'], $paymentMethod->getAccount());

        if (!empty($expectedContent['rrn'])) {
            $this->assertEquals($expectedContent['rrn'], $paymentMethod->getRrn());
        } else {
            $this->assertNull($paymentMethod->getRrn());
        }
    }


    /**
     * @param array                                  $expectedContent
     * @param GetRefundResponse|CreateRefundResponse $refundResponse
     */
    private function checkRefundResponse($expectedContent, $refundResponse)
    {
        $this->assertEquals($expectedContent['id'], $refundResponse->getId());

        $this->checkOrderItem($expectedContent['order'], $refundResponse->getOrder());
        $this->checkRefundItem($expectedContent['refund'], $refundResponse->getRefund());
        $this->checkWalletItem($expectedContent['wallet'], $refundResponse->getWallet());

        $this->assertEquals($expectedContent['token'], $refundResponse->getToken());
        $this->assertInstanceOf(\DateTime::class, $refundResponse->getCreateDate());
        $this->assertInstanceOf(\DateTime::class, $refundResponse->getUpdateDate());
        $this->assertEquals(new \DateTime($expectedContent['create_date']), $refundResponse->getCreateDate());
        $this->assertEquals(new \DateTime($expectedContent['update_date']), $refundResponse->getUpdateDate());
        $this->assertEquals($expectedContent['status'], $refundResponse->getStatus());

        $this->checkPaymentMethodItem($expectedContent['payment_method'], $refundResponse->getPaymentMethod());

        $customParameters = $refundResponse->getCustomParameters();
        if (!empty($expectedContent['custom_parameters'])) {
            $this->assertNotEmpty($customParameters);
            $this->assertArraySubset($expectedContent['custom_parameters'], $customParameters);
        } else {
            $this->assertNull($customParameters);
        }

        $this->assertEquals($expectedContent['is_test'], $refundResponse->getIsTest());
    }


    /**
     * @param array                                                                                  $expectedContent
     * @param GetPaymentResponse|CapturePaymentResponse|CancelPaymentResponse|ProcessPaymentResponse $paymentResponse
     */
    private function checkPaymentResponse($expectedContent, $paymentResponse)
    {
        $this->assertEquals($expectedContent['id'], $paymentResponse->getId());
        $this->assertEquals($expectedContent['token'], $paymentResponse->getToken());
        $this->assertInstanceOf(\DateTime::class, $paymentResponse->getCreateDate());
        $this->assertInstanceOf(\DateTime::class, $paymentResponse->getExpireDate());

        $this->assertEquals(new \DateTime($expectedContent['create_date']), $paymentResponse->getCreateDate());
        $this->assertEquals(new \DateTime($expectedContent['expire_date']), $paymentResponse->getExpireDate());
        $this->assertEquals($expectedContent['status'], $paymentResponse->getStatus());
        if (isset($expectedContent['status_description'])) {
            $this->assertEquals($expectedContent['status_description'], $paymentResponse->getStatusDescription());
        }

        if (isset($expectedContent['error_details'])) {
            $this->assertInstanceOf(ErrorDetailsItem::class, $paymentResponse->getErrorDetails());
            $this->assertEquals($expectedContent['error_details']['error'], $paymentResponse->getErrorDetails()->getError());
            $this->assertEquals($expectedContent['error_details']['description'], $paymentResponse->getErrorDetails()->getDescription());
        }

        $this->assertEquals($expectedContent['ip'], $paymentResponse->getIp());
        $this->assertEquals($expectedContent['is_test'], $paymentResponse->getIsTest());

        $this->checkOrderItem($expectedContent['order'], $paymentResponse->getOrder());
        $this->checkWalletItem($expectedContent['wallet'], $paymentResponse->getWallet());
        $this->checkPaymentMethodItem($expectedContent['payment_method'], $paymentResponse->getPaymentMethod());

        $cardItem = $paymentResponse->getPaymentMethod()->getCard();

        if (empty($expectedContent['payment_method']['card'])) {
            $this->assertNull($cardItem);
        } else {
            $this->assertNotNull($cardItem);
            $this->assertInstanceOf(CardItem::class, $cardItem);
            $this->checkCardData($expectedContent['payment_method']['card'], $cardItem);
        }

        if (method_exists($paymentResponse, 'getRefunds')) {
            $refunds = $paymentResponse->getRefunds();

            if (empty($expectedContent['refunds'])) {
                $this->assertNull($refunds);
            } else {
                $this->assertNotNull($refunds);
                $this->assertContainsOnlyInstancesOf(GetRefundResponse::class, $refunds);
                foreach ($refunds as $key => $refund) {
                    $values = $expectedContent['refunds'][$key];
                    $this->checkRefundResponse($values, $refund);
                }
            }
        }
    }

    /**
     * @param array                                  $expectedContent
     * @param CreatePayoutResponse|GetPayoutResponse $payoutResponse
     */
    private function checkPayoutMethodItem($expectedContent, $payoutResponse)
    {
        $this->assertInstanceOf(PayoutMethodItem::class, $payoutResponse->getPayoutMethod());
        $this->assertEquals($expectedContent['method'], $payoutResponse->getPayoutMethod()->getMethod());
        $this->assertEquals($expectedContent['type'], $payoutResponse->getPayoutMethod()->getType());
        $this->assertEquals($expectedContent['account'], $payoutResponse->getPayoutMethod()->getAccount());

        $cardItem = $payoutResponse->getPayoutMethod()->getCard();
        if (!empty($expectedContent['card'])) {
            $this->assertNotEmpty($cardItem);
            $this->checkCardData($expectedContent['card'], $cardItem);
        } else {
            $this->assertNotNull($cardItem);
            $this->assertInstanceOf(CardItem::class, $cardItem);
        }

        if (!empty($expectedContent['rrn'])) {
            $this->assertEquals($expectedContent['rrn'], $payoutResponse->getPayoutMethod()->getRrn());
        } else {
            $this->assertNull($payoutResponse->getPayoutMethod()->getRrn());
        }
    }

    /**
     * @param array                                  $expectedContent
     * @param CreatePayoutResponse|GetPayoutResponse $payoutResponse
     */
    private function checkPayoutResponse($expectedContent, $payoutResponse)
    {
        $this->assertEquals($expectedContent['id'], $payoutResponse->getId());
        $this->assertEquals($expectedContent['transaction_id'], $payoutResponse->getTransactionId());
        $this->assertEquals($expectedContent['status'], $payoutResponse->getStatus());

        $this->checkPayoutMethodItem($expectedContent['payout_method'], $payoutResponse);

        $this->assertInstanceOf(WalletPayoutResponseItem::class, $payoutResponse->getWallet());
        $this->assertEquals($expectedContent['wallet']['id'], $payoutResponse->getWallet()->getId());
        $this->assertEquals($expectedContent['wallet']['amount'], $payoutResponse->getWallet()->getAmount());
        $this->assertEquals($expectedContent['wallet']['currency'], $payoutResponse->getWallet()->getCurrency());

        $this->assertInstanceOf(MoneyItem::class, $payoutResponse->getTransfer());
        $this->assertEquals($expectedContent['transfer']['amount'], $payoutResponse->getTransfer()->getAmount());
        $this->assertEquals($expectedContent['transfer']['currency'], $payoutResponse->getTransfer()->getCurrency());

        $this->assertInstanceOf(MoneyItem::class, $payoutResponse->getRequest());
        $this->assertEquals($expectedContent['request']['amount'], $payoutResponse->getRequest()->getAmount());
        $this->assertEquals($expectedContent['request']['currency'], $payoutResponse->getRequest()->getCurrency());

        $this->assertInstanceOf(FeeItem::class, $payoutResponse->getFee());
        $this->assertEquals($expectedContent['fee']['type'], $payoutResponse->getFee()->getType());
        $this->assertEquals($expectedContent['fee']['amount'], $payoutResponse->getFee()->getAmount());
        $this->assertEquals($expectedContent['fee']['currency'], $payoutResponse->getFee()->getCurrency());

        $this->assertInstanceOf(\DateTime::class, $payoutResponse->getCreateDate());
        $this->assertEquals($expectedContent['create_date'], $payoutResponse->getCreateDate()->format('c'));

        $this->assertInstanceOf(\DateTime::class, $payoutResponse->getUpdateDate());
        $this->assertEquals($expectedContent['update_date'], $payoutResponse->getUpdateDate()->format('c'));

        if (!empty($expectedContent['description'])) {
            $this->assertEquals($expectedContent['description'], $payoutResponse->getDescription());
        } else {
            $this->assertNull($payoutResponse->getDescription());
        }

        $customParameters = $payoutResponse->getCustomParameters();
        if (!empty($expectedContent['custom_parameters'])) {
            $this->assertNotEmpty($customParameters);
            $this->assertArraySubset($expectedContent['custom_parameters'], $customParameters);
        } else {
            $this->assertNull($customParameters);
        }
    }

    /**
     * @param array    $expectedContent
     * @param CardItem $card
     */
    private function checkCardData($expectedContent, CardItem $card)
    {
        $expectedCardData = [
            $expectedContent['fingerprint'] ?: null,
            $expectedContent['category'] ?: null,
            $expectedContent['brand'] ?: null,
            $expectedContent['country'] ?: null,
            $expectedContent['bank'] ?: null,
            $expectedContent['type'] ?: null,
            $expectedContent['is3ds'] ?: null,
            $expectedContent['auth_type'] ?: null,
        ];

        $gotData = [
            $card->getFingerprint(),
            $card->getCategory(),
            $card->getBrand(),
            $card->getCountry(),
            $card->getBank(),
            $card->getType(),
            $card->getIs3ds(),
            $card->getAuthType(),
        ];

        $this->assertEquals($expectedCardData, $gotData);
    }
}
