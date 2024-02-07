# Sigma.net PHP SDK

Documentation: https://sigma.net/dashboard/docs/api/

## Requirements

PHP 7.4 and later.

## Dependencies

The bindings require the following extensions in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer.
- [`json`](https://secure.php.net/manual/en/book.json.php)
- [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)
- [`php-fig/log`](https://github.com/php-fig/log)
- [`guzzlehttp/psr7`](https://github.com/guzzle/psr7)

Optionally
- [`guzzlehttp/guzzle`](https://github.com/guzzle/guzzle) for use guzzle instead of cURL.

## Composer

You can install the lib via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require sigma-net/php-sdk 
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

If you use Composer, these dependencies should be handled automatically.

## Getting Started

We recommend using the GuzzleHttp Client

### Init client

```php
$guzzleClient = new GuzzleHttp\Client();
$transport = new SigmaNet\SDK\Transport\GuzzleApiTransport($guzzleClient);
$client = new SigmaNet\SDK\Client($transport);
$client->setAuth('login', 'secret'); // or for basic authorization $client->setAuth('login', 'password', SigmaNet\SDK\Transport\Authorization\BasicAuthorization::class);
```

All requests are processed in similar steps:
1. Create request instance of `SigmaNet\SDK\Model\Request\AbstractRequest`
1. Request serialization
1. Sending a request to the server
1. You have a response object instance of `SigmaNet\SDK\Model\Response\AbstractResponse` or throws exception if request fail

All requests are creating by suitable objects or can be created on the basis of arrays, integers and strings

#### Create payment

Creating request with object
```php
// Create a request object
$createPaymentRequest = new SigmaNet\SDK\Model\Request\Payment\CreatePaymentRequest();

// Set up $createPaymentRequest with required params

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\CreatePaymentResponse $createPaymentResponse */
    $createPaymentResponse = $client->createPayment($createPaymentRequest);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with array
```php
$requestArray = [
    'order' => [/*...*/],
    'settings' => [/*...*/],
    'custom_parameters' => [/*...*/],
    'receipt' => [/*...*/],
];

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\CreatePaymentResponse $createPaymentResponse */
    $createPaymentResponse = $client->createPayment($requestArray);
} catch (\Exception $e) {
    // ...
}
```

#### Process payment

Creating request with object
```php
// Create a request object
$processPayment = new SigmaNet\SDK\Model\Request\Payment\ProcessPaymentRequest();

// Set up $processPayment with required params

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\ProcessPaymentResponse $processPaymentResponse */
    $processPaymentResponse = $client->processPayment($processPayment);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with array
```php
$requestArray = [
    'token' => 'token',
    'ip' => '127.0.0.1',
    'payment_method_data' => [/*...*/],
];

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\ProcessPaymentResponse $processPaymentResponse */
    $processPaymentResponse = $client->processPayment($requestArray);
} catch (\Exception $e) {
    // ...
}
```

#### Capture payment

Creating request with object
```php
// Create a request object
$capturePaymentRequest = new SigmaNet\SDK\Model\Request\Payment\CapturePaymentRequest('token-string-from-create-payment-step');

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\CapturePaymentResponse $capturePaymentResponse */
    $capturePaymentResponse = $client->capturePayment($capturePaymentRequest);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with token
```php
try {
    /** @var SigmaNet\SDK\Model\Response\Payment\CapturePaymentResponse $capturePaymentResponse */
    $processPaymentResponse = $client->processPayment('token-string-from-create-payment-step');
} catch (\Exception $e) {
    // ...
}
```

#### Get payment info

Creating request with object
```php
// Create a request object
$getPaymentRequest = new SigmaNet\SDK\Model\Request\Payment\GetPaymentRequest('token-string-from-create-payment-step');

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\GetPaymentResponse $getPaymentResponse */
    $getPaymentResponse = $client->getPayment($getPaymentRequest);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with token
```php
try {
    /** @var SigmaNet\SDK\Model\Response\Payment\GetPaymentResponse $getPaymentResponse */
    $getPaymentResponse = $client->getPayment('token-string-from-create-payment-step');
} catch (\Exception $e) {
    // ...
}
```

#### Cancel payment

Creating request with object
```php
// Create a request object
$cancelPaymentRequest = new SigmaNet\SDK\Model\Request\Payment\CancelPaymentRequest('token-string-from-create-payment-step');

try {
    /** @var SigmaNet\SDK\Model\Response\Payment\CancelPaymentResponse $cancelPaymentResponse */
    $cancelPaymentResponse = $client->cancelPayment($cancelPaymentRequest);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with token
```php
try {
    /** @var SigmaNet\SDK\Model\Response\Payment\CancelPaymentResponse $cancelPaymentResponse */
    $cancelPaymentResponse = $client->cancelPayment('token-string-from-create-payment-step');
} catch (\Exception $e) {
    // ...
}
```

#### Create payout

Creating request with object
```php
// Create a request object
$createPayoutRequest = new SigmaNet\SDK\Model\Request\Payout\CreatePayoutRequest();

// Set up $createPayoutRequest with required params

try {
    /** @var SigmaNet\SDK\Model\Response\Payout\CreatePayoutResponse $createPayoutResponse */
    $createPayoutResponse = $client->createPayout($createPayoutRequest);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with array
```php
$requestArray = [
    'transaction_id' => 'transaction_id',
    'wallet_id' => 123,
    'fee_type' => 'fee_type',
    'payout_method_data' => [/*...*/],
    'order' => [/*...*/],
];

try {
    /** @var SigmaNet\SDK\Model\Response\Payout\CreatePayoutResponse $createPayoutResponse */
    $createPayoutResponse = $client->createPayout($requestArray);
} catch (\Exception $e) {
    // ...
}
```

#### Get payout info

Creating request with object
```php
// Create a request object
$getPayoutRequest = new SigmaNet\SDK\Model\Request\Payout\GetPayoutRequest();

// Set up $getPayoutRequest with required params

try {
    /** @var SigmaNet\SDK\Model\Response\Payout\GetPayoutResponse $getPayoutResponse */
    $getPayoutResponse = $client->getPayout($getPayoutRequest);
} catch (\Exception $e) {
    // ...
}
```

or you can create request with array
```php
$requestArray = [
    'transaction_id' => 'transaction_id',
    'wallet_id' => 123,
];

try {
    /** @var SigmaNet\SDK\Model\Response\Payout\GetPayoutResponse $getPayoutResponse */
    $getPayoutResponse = $client->getPayout($requestArray);
} catch (\Exception $e) {
    // ...
}
```

or create by id
```php
try {
    /** @var SigmaNet\SDK\Model\Response\Payout\GetPayoutResponse $getPayoutResponse */
    $getPayoutResponse = $client->getPayout(123);
} catch (\Exception $e) {
    // ...
}
```

#### Payments report

Download report file
```php
$paymentsReport = new SigmaNet\SDK\Model\Request\Reports\PaymentsReportRequest();
$paymentsReport->setDatetimeFrom(new \DateTime('2 weeks ago'))
            ->setDatetimeTo(new \DateTime());

$response = $client->getPaymentsReport($paymentsReport);

http_response_code($response->getStatusCode());
$stream = $response->getBody();

foreach ($response->getHeaders() as $key => $header) {
    header($key . ': ' . join(',', $header));
}

echo $stream->getContents();
```

#### Payouts report

Download report file
```php
$payoutsReportRequest = new SigmaNet\SDK\Model\Request\Reports\PayoutsReportRequest();
$payoutsReportRequest->setDatetimeFrom(new \DateTime('2 weeks ago'))
            ->setDatetimeTo(new \DateTime());

$response = $client->getPayoutsReport($payoutsReportRequest);

http_response_code($response->getStatusCode());
$stream = $response->getBody();

foreach ($response->getHeaders() as $key => $header) {
    header($key . ': ' . join(',', $header));
}

echo $stream->getContents();
```

#### Exceptions

- `SigmaNet\SDK\Exception\TransportException` - throws in the case of an api transport error. For example, when authorization data is not provided.
- `SigmaNet\SDK\Exception\JsonParseException` - the server response doesn't contain a valid json.
- `SigmaNet\SDK\Exception\ServerResponse\ResponseException` - 4xx and 5xx server errors.
- `SigmaNet\SDK\Exception\Response\ResponseParseException` - create response errors.
- `SigmaNet\SDK\Exception\Request\RequestParseException` - create request errors.

### Processing notification from server

This code is responsible for processing the payment result.
You need to create handler, make it available on URL in your application and specify the URL in the project settings in [sigma.net](http://sigma.net/).
This handler will be called after the user makes a payment using the form on sigma.net

```php
$notification = new Notification();
$notification->setApiKey('api-key');
$notification->process();
```

You can use manual response to server:

```php
$notification->process(false);

// if success
$notification->successResponse();
// if error
$notification->errorResponse('Error message');
```

If you use a proxy server, you can skip the IP check

```php
$notification->setSkipIpCheck();
```

## Custom Api Transport

You can create your own api transport by extending `SigmaNet\SDK\Transport\AbstractApiTransport`

```php
class MyApiTransport extends AbstractApiTransport {
    protected function sendRequest(Psr7\Request $request) {
        // Implementing the sendRequest() method
    }
}
```
