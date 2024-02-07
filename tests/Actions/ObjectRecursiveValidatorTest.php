<?php


namespace Tests\SigmaNet\SDK\Actions;


use SigmaNet\SDK\Actions\ObjectRecursiveValidator;
use SigmaNet\SDK\Actions\RequestCreator;
use SigmaNet\SDK\Exception\Validation\EmptyRequiredPropertyException;
use SigmaNet\SDK\Model\Request\Payment\CreatePaymentRequest;
use PHPUnit\Framework\TestCase;
use Tests\SigmaNet\SDK\Mocks\CreatePaymentRequestMock;

class ObjectRecursiveValidatorTest extends TestCase
{
    public function testValidate()
    {
        $data = CreatePaymentRequestMock::getValidFields();

        foreach ($data as $paymentRequestMock) {
            /** @var CreatePaymentRequest $paymentRequest */
            $paymentRequest = RequestCreator::create(CreatePaymentRequest::class, $paymentRequestMock);
            $this->validatePayment($paymentRequest);
        }
    }

    public function testValidateRequiredError()
    {
        $data = CreatePaymentRequestMock::getValidFields();
        $paymentRequestMock = reset($data);
        /** @var CreatePaymentRequest $paymentRequest */
        $paymentRequest = RequestCreator::create(CreatePaymentRequest::class, $paymentRequestMock);
        $paymentRequest->setOrder(null);

        $this->setExpectedException(EmptyRequiredPropertyException::class);
        $this->validatePayment($paymentRequest);
    }

    public function testValidateThoughFieldsEmptyError()
    {
        $data = CreatePaymentRequestMock::getValidFields();
        $paymentRequestMock = reset($data);

        /** @var CreatePaymentRequest $paymentRequest */
        $paymentRequest = RequestCreator::create(CreatePaymentRequest::class, $paymentRequestMock);
        $paymentRequest->getReceipt()
            ->setEmail(null)
            ->setPhone(null);
        $this->setExpectedException(EmptyRequiredPropertyException::class);
        $this->validatePayment($paymentRequest);
    }

    public function testValidateThoughFields()
    {
        $data = CreatePaymentRequestMock::getValidFields();
        $paymentRequestMock = reset($data);

        /** @var CreatePaymentRequest $paymentRequest */
        $paymentRequest = RequestCreator::create(CreatePaymentRequest::class, $paymentRequestMock);

        $paymentRequest->getReceipt()
            ->setEmail(null)
            ->setPhone('79999999999');
        $this->validatePayment($paymentRequest);

        $paymentRequest->getReceipt()
            ->setEmail('mail@test.test')
            ->setPhone(null);
        $this->validatePayment($paymentRequest);

        $paymentRequest->getReceipt()
            ->setEmail('mail@test.test')
            ->setPhone('79999999999');
        $this->validatePayment($paymentRequest);
    }

    private function validatePayment(CreatePaymentRequest $paymentRequest)
    {
        ObjectRecursiveValidator::validate($paymentRequest);
        $this->addToAssertionCount(1);
    }
}
