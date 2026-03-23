<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/News.php';
require_once __DIR__ . '/../models/Association.php';
require_once __DIR__ . '/../models/Ad.php';

class PageController
{
    private function render(string $view, array $data = []): void
    {
        $ads = Ad::published();
        extract($data, EXTR_SKIP);
        $currentPath = $_SERVER['REQUEST_URI'] ?? '/';
        $viewFile = __DIR__ . '/../views/pages/' . $view . '.php';
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/layout/nav.php';
        if (is_file($viewFile)) {
            include $viewFile;
        }
        include __DIR__ . '/../views/layout/footer.php';
    }

    public function events(): void
    {
        $events = Event::publishedUpcoming();
        $this->render('det-sker', [
            'events' => $events,
        ]);
    }

    public function aboutBogoe(): void
    {
        $this->render('om-bogoe');
    }

    public function aboutPortal(): void
    {
        $this->render('om-bogoe-portalen');
    }

    public function associations(): void
    {
        $associations = Association::published();
        $this->render('foreninger', [
            'associations' => $associations,
        ]);
    }

    public function news(): void
    {
        $news = News::published();
        $this->render('nyheder', [
            'news' => $news,
        ]);
    }
}

