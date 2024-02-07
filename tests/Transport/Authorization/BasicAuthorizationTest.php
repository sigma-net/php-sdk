<?php

use SigmaNet\SDK\Transport\Authorization\AuthorizationInterface;
use SigmaNet\SDK\Transport\Authorization\BasicAuthorization;
use PHPUnit\Framework\TestCase;

class BasicAuthorizationTest extends TestCase
{
    private static $authTokens = [
        [
            'username' => 'partner@mail.com',
            'password' => 'password',
        ],
        [
            'username' => 'somemail@example.com',
            'password' => 'qwerty',
        ],
        [
            'username' => 'user@domain',
            'password' => '@d3l$№tagamm@',
        ],
        [
            'username' => 'admin@domain',
            'password' => 'qwertyuiop!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~',
        ],
        [
            'username' => 'support',
            'password' => '1',
        ],
    ];

    public function testGetAuth()
    {
        foreach (self::$authTokens as $token) {
            $tokenAuthorization = new BasicAuthorization($token['username'], $token['password']);
            $this->assertInstanceOf(AuthorizationInterface::class, $tokenAuthorization);
            $expectedHeader = base64_encode(sprintf('%s:%s', $token['username'], $token['password']));
            $expectedHeader = sprintf('%s %s', 'Basic', $expectedHeader);
            $this->assertEquals($tokenAuthorization->getAuthorizationHeader(), $expectedHeader);
        }
    }
}
