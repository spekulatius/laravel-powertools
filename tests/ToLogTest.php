<?php

namespace Spekulatius\LaravelPowertools\Tests;

class ToLogTest extends TestCase
{
    // We simply include the trait on this and pass the values to test in.
    // This way we save ourself any setup really.
    use \Spekulatius\LaravelPowertools\Traits\ToLog;

    /** @test */
    public function it_should_mask_sensitive_data()
    {
        $input = [
            'password' => 'this could be a password or an encrypted password',
        ];

        $expected_output = [
            'password' => '[masked]',
        ];

        $this->assertSame($expected_output, $this->toLog($input));
    }

    /** @test */
    public function it_should_correctly_flatten_array_and_modify_values()
    {
        $input = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'json_data' => ['foo' => 'bar', 'baz' => ['qux' => 'quux']],
            'multiline_string' => "This is\na\nmultiline string.",
            'long_string' => str_repeat('a', 100),
            'created_at' => '2022-03-25 12:34:56',
            'updated_at' => '2022-03-26 09:45:12',
            'is_active' => true,
            'is_admin' => false,
        ];

        $expected_output = [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => '[masked]',
            'json_data' => ['foo' => 'bar', 'baz' => ['qux' => 'quux']],
            'multiline_string' => 'This is a multiline string.',
            'long_string' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa...',
            'created_at' => '2022-03-25 12:34:56',
            'updated_at' => '2022-03-26 09:45:12',
            'is_active' => true,
            'is_admin' => false,
        ];

        $this->assertSame($expected_output, $this->toLog($input));
    }

    /** @test */
    public function it_should_correctly_handle_null_values_and_empty_strings()
    {
        $input = [
            'id' => 1,
            'name' => null,
            'email' => 'john.doe@example.com',
            'phone' => '',
            'password' => null,
            'created_at' => null,
            'updated_at' => '2022-03-26 09:45:12',
            'is_active' => null,
            'is_admin' => false,
        ];

        $this->assertSame($input, $this->toLog($input));
    }

    /** @test */
    public function it_should_correctly_handle_carbon_values()
    {
        $input = [
            'created_at' => now(),
        ];

        $expected_output = [
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        $this->assertSame($expected_output, $this->toLog($input));
    }
}
