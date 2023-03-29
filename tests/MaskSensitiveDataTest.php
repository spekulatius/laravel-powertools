<?php

namespace Spekulatius\LaravelPowertools\Tests;

class MaskSensitiveDataTest extends TestCase
{
    public function testMaskSensitiveData()
    {
        $data = collect([
            'username' => 'johndoe',
            'password' => 'secret',
            'email' => 'johndoe@example.com',
            'salt' => '12345',
            'phone' => '555-1234',
            'group' => 'admin',
            'role' => 'superuser',
            'token' => 'abc123',
            'acl' => 'user',
            'api key' => '12345',
            'secret key' => 'abcdef',
            'public key' => 'ghijkl',
            'checksum' => '123456',
        ]);

        $maskedData = $data->maskSensitiveData();

        $this->assertEquals('[masked]', $maskedData['password']);
        $this->assertEquals('[masked]', $maskedData['salt']);
        $this->assertEquals('[masked]', $maskedData['token']);
        $this->assertEquals('[masked]', $maskedData['acl']);
        $this->assertEquals('[masked]', $maskedData['api key']);
        $this->assertEquals('[masked]', $maskedData['secret key']);
        $this->assertEquals('[masked]', $maskedData['public key']);
        $this->assertEquals('[masked]', $maskedData['checksum']);
        $this->assertEquals('johndoe', $maskedData['username']);
        $this->assertEquals('johndoe@example.com', $maskedData['email']);
        $this->assertEquals('555-1234', $maskedData['phone']);
    }

    public function testMaskSensitiveDataWithCustomRegex()
    {
        // Append our custom regex to the configuration.
        $config = config('powertools.masked_fields', []);
        $config[] = '/authorization/i';
        \Illuminate\Support\Facades\Config::set('powertools.masked_fields', $config);

        $data = collect([
            'username' => 'johndoe',
            'authorization' => 'secret',
            'email' => 'johndoe@example.com',
        ]);

        $maskedData = $data->maskSensitiveData();

        $this->assertEquals('[masked]', $maskedData['authorization']);
    }
}
