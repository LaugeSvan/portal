<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/helpers.php';

// Simple autoloader for controllers and models
spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . '/src/';
    $paths = [
        $baseDir . 'controllers/' . $class . '.php',
        $baseDir . 'models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

// No subdirectory normalisation needed for the built-in server.

$uri = rtrim($uri, '/') ?: '/';

// Public routes
switch ($uri) {
    case '/':
        redirect('/det-sker');
        break;

    case '/det-sker':
        $controller = new PageController();
        $controller->events();
        break;

    case '/om-bogoe':
        $controller = new PageController();
        $controller->aboutBogoe();
        break;

    case '/om-bogoe-portalen':
        $controller = new PageController();
        $controller->aboutPortal();
        break;

    case '/foreninger':
        $controller = new PageController();
        $controller->associations();
        break;

    case '/nyheder':
        $controller = new PageController();
        $controller->news();
        break;

    case '/admin':
        $controller = new AdminController();
        $controller->login();
        break;

    default:
        // Admin routes
        if (str_starts_with($uri, '/admin/')) {
            $controller = new AdminController();
            switch ($uri) {
                case '/admin/dashboard':
                    $controller->dashboard();
                    break;
                case '/admin/logout':
                    $controller->logout();
                    break;
                case '/admin/events':
                    $controller->events();
                    break;
                case '/admin/events/create':
                case '/admin/events/edit':
                    $controller->eventForm();
                    break;
                case '/admin/events/delete':
                    $controller->deleteEvent();
                    break;
                case '/admin/news':
                    $controller->news();
                    break;
                case '/admin/news/create':
                case '/admin/news/edit':
                    $controller->newsForm();
                    break;
                case '/admin/news/delete':
                    $controller->deleteNews();
                    break;
                case '/admin/associations':
                    $controller->associations();
                    break;
                case '/admin/associations/create':
                case '/admin/associations/edit':
                    $controller->associationForm();
                    break;
                case '/admin/associations/delete':
                    $controller->deleteAssociation();
                    break;
                case '/admin/ads':
                    $controller->ads();
                    break;
                case '/admin/ads/create':
                case '/admin/ads/edit':
                    $controller->adForm();
                    break;
                case '/admin/ads/delete':
                    $controller->deleteAd();
                    break;
                case '/admin/pages':
                    $controller->pages();
                    break;
                case '/admin/pages/edit':
                    $controller->pageSectionForm();
                    break;
                case '/admin/users':
                    $controller->users();
                    break;
                case '/admin/users/create':
                case '/admin/users/edit':
                    $controller->userForm();
                    break;
                case '/admin/users/delete':
                    $controller->deleteUser();
                    break;
                case '/admin/setup.php':
                    require __DIR__ . '/setup/setup.php';
                    break;
                default:
                    http_response_code(404);
                    echo '404 - Siden blev ikke fundet';
            }
        } else {
            http_response_code(404);
            echo '404 - Siden blev ikke fundet';
        }
}