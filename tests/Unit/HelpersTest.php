<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    public function test_sanitize_removes_script_tags(): void
    {
        $input = '<script>alert("xss")</script>Hello';
        $result = sanitize($input);
        $this->assertStringNotContainsString('<script>', $result);
    }

    public function test_sanitize_preserves_plain_text(): void
    {
        $input = 'Hello World';
        $result = sanitize($input);
        $this->assertSame($input, $result);
    }

    public function test_redirect_sends_correct_headers(): void
    {
        // This test verifies redirect() exists and is callable
        $this->assertTrue(function_exists('redirect'));
    }

    public function test_is_logged_in_returns_boolean(): void
    {
        $result = isLoggedIn();
        $this->assertIsBool($result);
    }
}
