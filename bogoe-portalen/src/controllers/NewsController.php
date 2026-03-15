<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/News.php';

class NewsController
{
    public function index(): void
    {
        $news = News::published();
        $viewFile = __DIR__ . '/../views/pages/nyheder.php';
        include $viewFile;
    }
}

