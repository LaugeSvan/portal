<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/Event.php';

class EventController
{
    public function index(): void
    {
        $events = Event::publishedUpcoming();
        $viewFile = __DIR__ . '/../views/pages/det-sker.php';
        include $viewFile;
    }
}

