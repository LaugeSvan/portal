<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private PDO $db;

    protected function setUp(): void
    {
        $this->db = getDB();
        // Clean up test data before each test
        $this->db->exec("DELETE FROM users WHERE username LIKE 'test_%'");
    }

    public function test_create_user(): void
    {
        $userId = User::create(
            'test_user',
            'test@example.com',
            'testpassword123',
            'editor'
        );

        $this->assertGreaterThan(0, $userId);

        $user = User::findById($userId);
        $this->assertSame('test_user', $user['username']);
        $this->assertSame('test@example.com', $user['email']);
    }

    public function test_find_by_username(): void
    {
        User::create('test_findme', 'findme@example.com', 'password123', 'editor');

        $user = User::findByUsername('test_findme');
        $this->assertSame('test_findme', $user['username']);
    }

    public function test_find_by_username_returns_null_for_missing(): void
    {
        $user = User::findByUsername('nonexistent_user_12345');
        $this->assertNull($user);
    }

    public function test_verify_password(): void
    {
        User::create('test_verify', 'verify@example.com', 'correctpassword', 'editor');
        $user = User::findByUsername('test_verify');

        $this->assertTrue(User::verifyPassword('correctpassword', $user['password_hash']));
        $this->assertFalse(User::verifyPassword('wrongpassword', $user['password_hash']));
    }

    public function test_delete_user(): void
    {
        $userId = User::create('test_delete', 'delete@example.com', 'password123', 'editor');
        $this->assertNotNull(User::findById($userId));

        User::delete($userId);
        $this->assertNull(User::findById($userId));
    }
}
