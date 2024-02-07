<?php

use SigmaNet\SDK\Transport\Authorization\AuthorizationInterface;
use SigmaNet\SDK\Transport\Authorization\TokenAuthorization;
use PHPUnit\Framework\TestCase;

class TokenAuthorizationTest extends TestCase
{
    private static $authTokens = [
        [
            'username' => 'partner@mail.com',
            'token' => 'TOKEN',
        ],
        [
            'username' => 'somemail@example.com',
            'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.XbPfbIHMI6arZ3Y922BhjWgQzWXcXNrz0ogtVhfEd2o',
        ],
        [
            'username' => 'user',
            'token' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[\]1234567890!@#$%^&*()_+',
        ],
    ];

    public function testGetAuth()
    {
        foreach (self::$authTokens as $token) {
            $tokenAuthorization = new TokenAuthorization($token['username'], $token['token']);
            $this->assertInstanceOf(AuthorizationInterface::class, $tokenAuthorization);
            $expectedHeader = sprintf('%s %s:%s', 'Bearer', $token['username'], $token['token']);
            $this->assertEquals($tokenAuthorization->getAuthorizationHeader(), $expectedHeader);
        }
    }
}
