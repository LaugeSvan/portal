<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    private PDO $db;

    protected function setUp(): void
    {
        $this->db = getDB();
        $this->db->exec("DELETE FROM events WHERE title LIKE 'Test %'");
    }

    public function test_create_event(): void
    {
        $eventId = Event::create([
            'title' => 'Test Event',
            'description' => 'A test event',
            'event_date' => '2026-06-15',
            'location' => 'Test Location',
        ]);

        $this->assertGreaterThan(0, $eventId);

        $event = Event::findById($eventId);
        $this->assertSame('Test Event', $event['title']);
    }

    public function test_published_events(): void
    {
        // Create unpublished event
        Event::create([
            'title' => 'Test Unpublished',
            'event_date' => '2026-07-01',
            'is_published' => false,
        ]);

        // Create published event
        Event::create([
            'title' => 'Test Published',
            'event_date' => '2026-07-02',
            'is_published' => true,
        ]);

        $published = Event::published();
        $titles = array_column($published, 'title');

        $this->assertContains('Test Published', $titles);
        $this->assertNotContains('Test Unpublished', $titles);
    }

    public function test_delete_event(): void
    {
        $eventId = Event::create([
            'title' => 'Test To Delete',
            'event_date' => '2026-08-01',
        ]);

        Event::delete($eventId);
        $this->assertNull(Event::findById($eventId));
    }
}
