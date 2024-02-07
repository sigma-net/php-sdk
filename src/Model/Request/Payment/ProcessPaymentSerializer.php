<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\PaymentMethods;
use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class ProcessPaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var ProcessPaymentRequest $processPaymentRequest */
        $processPaymentRequest = $this->request;
        $serializedData = [
            'token' => $processPaymentRequest->getToken(),
            'ip' => $processPaymentRequest->getIp(),
            'payment_method_data' => [],
        ];

        $paymentMethodDataItem = $processPaymentRequest->getPaymentMethodData();

        if ($paymentMethodDataItem) {
            $serializedData['payment_method_data']['type'] = $paymentMethodDataItem->getType();

            if ($paymentMethodDataItem->getType() === PaymentMethods::PAYMENT_METHOD_CARD) {
                $serializedData['payment_method_data']['card_number'] = $paymentMethodDataItem->getCardNumber();
                $serializedData['payment_method_data']['card_month'] = $paymentMethodDataItem->getCardMonth();
                $serializedData['payment_method_data']['card_year'] = $paymentMethodDataItem->getCardYear();
                $serializedData['payment_method_data']['card_security'] = $paymentMethodDataItem->getCardSecurity();
                $serializedData['payment_method_data']['cardholder'] = $paymentMethodDataItem->getCardholder();
            }

            if ($paymentMethodDataItem->getType() === PaymentMethods::PAYMENT_METHOD_WEBMONEY && $paymentMethodDataItem->getPurseType() !== null) {
                $serializedData['payment_method_data']['purse_type'] = $paymentMethodDataItem->getPurseType();
            }

            if ($paymentMethodDataItem->getType() === PaymentMethods::PAYMENT_METHOD_CARD_TOKENIZED) {
                $serializedData['payment_method_data']['token_data'] = $paymentMethodDataItem->getTokenData();
                $serializedData['payment_method_data']['token_type'] = $paymentMethodDataItem->getTokenType();
            }

            if ($paymentMethodDataItem->getType() === PaymentMethods::PAYMENT_METHOD_SBP && $paymentMethodDataItem->getReturnImage()) {
                $serializedData['payment_method_data']['return_image'] = $paymentMethodDataItem->getReturnImage();
            }

            if ($paymentMethodDataItem->getAccount() !== null) {
                $serializedData['payment_method_data']['account'] = $paymentMethodDataItem->getAccount();
            }

            if ($paymentMethodDataItem->getCapture() !== null) {
                $serializedData['payment_method_data']['capture'] = $paymentMethodDataItem->getCapture();
            }
        }

        return $serializedData;
    }
}
