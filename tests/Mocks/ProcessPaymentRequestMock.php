<?php


namespace Tests\SigmaNet\SDK\Mocks;


class ProcessPaymentRequestMock
{
    public static function getValidFields()
    {
        return [
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '127.0.0.1',
                'payment_method_data' => [
                    'type' => 'card',
                    'card_number' => '4200000000000000',
                    'card_month' => '03',
                    'card_year' => '19',
                    'card_security' => '123',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'type' => 'qiwi',
                    'account' => 'qwerty1234567',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'type' => 'webmoney',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'type' => 'webmoney',
                    'purse_type' => 'R',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'type' => 'webmoney',
                    'purse_type' => 'P',
                ],
            ],
        ];
    }

    public static function getNonRequiredFields()
    {
        return [
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '127.0.0.1',
                'payment_method_data' => [
                    'type' => 'card',
                    'card_number' => '4200000000000000',
                    'card_month' => '03',
                    'card_year' => '19',
                ],
            ],
            [
                'ip' => '127.0.0.1',
                'payment_method_data' => [
                    'type' => 'card',
                    'card_number' => '4200000000000000',
                    'card_month' => '03',
                    'card_year' => '19',
                ],
            ],
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '127.0.0.1',
                'payment_method_data' => [
                    'type' => 'card',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'type' => 'qiwi',
                    'account' => 'qwerty1234567',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'type' => 'qiwi',
                ],
            ],
            [
                'token' => '2-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '172.0.0.2',
                'payment_method_data' => [
                    'account' => 'qwerty1234567',
                ],
            ],
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '127.0.0.1',
                'payment_method_data' => [],
            ],
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
                'ip' => '127.0.0.1',
            ],
            [
                'token' => '1-62aebd0e3a-3dae1e0976-73f96a4bc1',
            ],
            [],
        ];
    }
}
