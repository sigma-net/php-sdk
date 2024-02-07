<?php

namespace SigmaNet\SDK\Model\Request\Payment;

use SigmaNet\SDK\Model\Request\AbstractRequestSerializer;

class PatchPaymentSerializer extends AbstractRequestSerializer
{
    /**
     * @inheritDoc
     */
    public function getSerializedData(): array
    {
        /** @var PatchPaymentRequest $paymentRequest */
        $paymentRequest = $this->request;
        $settings = $paymentRequest->getSettings();
        $customParameters = $paymentRequest->getCustomParameters();
        $serializedPayment = [
            'token' => $paymentRequest->getToken(),
        ];

        $emptyFilter = function ($param) {
            return !empty($param);
        };

        $serializedPayment['settings'] = [
            'payment_method' => $settings->getPaymentMethod(),
            'success_url' => $settings->getSuccessUrl(),
            'fail_url' => $settings->getFailUrl(),
            'expire_date' => $settings->getExpireDate() ? $settings->getExpireDate()->format('c') : null,
            'wallet_id' => $settings->getWalletId(),
            'hide_form_methods' => $settings->isHideFormMethods(),
            'hide_form_header' => $settings->isHideFormHeader(),
            'hide_form_tokenized_methods' => $settings->isHideFormTokenizedMethods(),
            'hide_form_remember_card' => $settings->isHideFormRememberCard(),
            'create_subscription' => $settings->isCreateSubscription(),
            'locale' => $settings->getLocale(),
        ];

        if (!empty($customParameters)) {
            $serializedPayment['custom_parameters'] = $customParameters;
            $serializedPayment['custom_parameters'] = array_filter($serializedPayment['custom_parameters'], $emptyFilter);
        }

        return $serializedPayment;
    }
}
