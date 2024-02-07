<?php

namespace Tests\SigmaNet\SDK\Mocks;


class CreatePaymentRequestMock
{
    public static function getValidFields()
    {
        return array_merge(self::getAllFields(), self::getRequiredFields());
    }

    public static function getAllFields()
    {
        return [
            [
                'partner_payment_id' => 'test_payment_1',
                'order' => [
                    'currency' => 'RUB',
                    'amount' => 100,
                    'description' => 'Description description description description description description description',
                ],
                'settings' => [
                    'project_id' => 1000000,
                    'payment_method' => 'qiwi',
                    'success_url' => 'http://site.com/?success',
                    'fail_url' => 'http://site.com/?fail',
                    'expire_date' => '2017-12-25T00:07:19+00:00',
                    'wallet_id' => 99999999999,
                ],
                'custom_parameters' => [
                    'email' => 'vasia@gmail.com',
                    'order_id' => '515',
                    'some_strange_params' => 'passed',
                ],
                'receipt' => [
                    'items' => [
                        [
                            'name' => 'Товар 1',
                            'price' => 125.5,
                            'quantity' => 0.5,
                            'tax' => 'vat0',
                        ],
                        [
                            'name' => 'Товар 2',
                            'price' => 1250.51,
                            'quantity' => 1.51,
                            'sum' => 100.55,
                            'tax' => 'vat0',
                        ],
                    ],
                    'place' => 'http://site.ru',
                    'email' => 'email@email.email',
                    'phone' => '79999999999',
                ],
            ],
            [
                'order' => [
                    'currency' => 'EUR',
                    'amount' => 100,
                    'description' => 'Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты.',
                ],
                'settings' => [
                    'project_id' => 1,
                    'payment_method' => 'qiwi',
                    'success_url' => 'http://site.ru/?success',
                    'fail_url' => 'http://site.ru/?fail',
                    'expire_date' => '2017-12-25T00:07:19+00:00',
                    'wallet_id' => 1,
                    'capture' => false
                ],
                'custom_parameters' => [
                    'email' => 'misha@domain.email',
                    'order_id' => 51,
                    'param1' => 1,
                    'param2' => 2,
                    'param3' => 3,
                    'param4' => 4,
                    'param5' => 5,
                ],
                'receipt' => [
                    'items' => [
                        [
                            'name' => 'Товар 1',
                            'price' => 125.5,
                            'quantity' => 0.5,
                            'tax' => 'vat0',
                        ],
                        [
                            'name' => 'Товар 2',
                            'price' => 1250.51,
                            'quantity' => 1.51,
                            'sum' => 100.55,
                            'tax' => 'vat0',
                        ],
                    ],
                    'place' => 'http://site.ru',
                    'email' => 'email@email.email',
                    'phone' => '78888888888',
                ],
            ],
        ];
    }

    public static function getRequiredFields()
    {
        return [
            [
                'order' => [
                    'currency' => 'RUB',
                    'amount' => 1,
                ],
                'settings' => [
                    'project_id' => 1,
                ],
            ],
            [
                'order' => [
                    'currency' => 'USD',
                    'amount' => 2,
                ],
                'settings' => [
                    'project_id' => 2,
                ],
            ],
            [
                'order' => [
                    'currency' => 'EUR',
                    'amount' => 3,
                ],
                'settings' => [
                    'project_id' => 3,
                ],
            ],
        ];
    }
}
