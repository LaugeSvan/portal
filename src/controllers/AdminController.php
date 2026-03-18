<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/News.php';
require_once __DIR__ . '/../models/Association.php';
require_once __DIR__ . '/../models/Page.php';
require_once __DIR__ . '/../models/ActivityLog.php';

class AdminController
{
    private function log(string $action, ?string $entityType = null, ?int $entityId = null, ?string $description = null): void
    {
        ActivityLog::log($action, $entityType, $entityId, $description);
    }
    private function render(string $view, array $data = []): void
    {
        requireLogin();
        extract($data, EXTR_SKIP);
        $currentPath = $_SERVER['REQUEST_URI'] ?? '/admin';
        $viewFile = __DIR__ . '/../views/admin/' . $view . '.php';
        include __DIR__ . '/../views/admin/layout.php';
    }

    private function getLoginAttempts(): int
    {
        return (int)($_SESSION['login_attempts'] ?? 0);
    }

    private function incrementLoginAttempts(): void
    {
        $_SESSION['login_attempts'] = $this->getLoginAttempts() + 1;
        $_SESSION['login_last_attempt'] = time();
    }

    private function canAttemptLogin(): bool
    {
        $attempts = $this->getLoginAttempts();
        $last = (int)($_SESSION['login_last_attempt'] ?? 0);
        if ($attempts < 5) {
            return true;
        }
        return (time() - $last) > 15 * 60;
    }

    public function login(): void
    {
        if (isLoggedIn()) {
            redirect('/admin/dashboard');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->canAttemptLogin()) {
                $error = 'For mange loginforsøg. Prøv igen om lidt.';
            } elseif (!isset($_POST['csrf_token']) || !verifyCsrfToken((string)$_POST['csrf_token'])) {
                $error = 'Ugyldig sikkerhedstoken. Prøv igen.';
            } else {
                $username = trim((string)($_POST['username'] ?? ''));
                $password = (string)($_POST['password'] ?? '');
                $user = User::findByUsername($username);
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['login_attempts'] = 0;
                    $this->log('login', 'user', (int)$user['id'], 'Succesfuldt login');
                    redirect('/admin/dashboard');
                } else {
                    $this->incrementLoginAttempts();
                    $error = 'Forkert brugernavn eller adgangskode.';
                }
            }
        }

        $csrfToken = generateCsrfToken();
        $viewFile = __DIR__ . '/../views/admin/login.php';
        $currentPath = '/admin';
        $data = compact('error', 'csrfToken', 'currentPath');
        extract($data, EXTR_SKIP);
        include $viewFile;
    }

    public function logout(): void
    {
        $this->log('logout', 'user', isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null, 'Log ud');
        session_destroy();
        redirect('/admin');
    }

    public function dashboard(): void
    {
        $stats = [
            'events' => count(Event::all()),
            'news' => count(News::all()),
            'associations' => count(Association::all()),
            'users' => count(User::all()),
        ];
        $this->render('dashboard', [
            'stats' => $stats,
            'activity' => ActivityLog::recent(10),
        ]);
    }

    public function events(): void
    {
        $events = Event::all();
        $this->render('events', ['events' => $events]);
    }

    public function eventForm(): void
    {
        $pdo = getDB();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $event = $id ? Event::find($id) : null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string)$_POST['csrf_token'])) {
                $error = 'Ugyldig sikkerhedstoken.';
            } else {
                $data = $_POST;
                $data['is_published'] = isset($_POST['is_published']) ? 1 : 0;
                $data['sort_order'] = (int)($_POST['sort_order'] ?? 0);

                if (!empty($_FILES['image']['name'] ?? '')) {
                    $upload = $this->handleUpload('image');
                    if ($upload['ok']) {
                        $data['image_path'] = $upload['path'];
                    } else {
                        $error = $upload['error'];
                    }
                }

                if (!$error) {
                    if ($event) {
                        Event::update($event['id'], $data);
                        $this->log('update', 'event', (int)$event['id'], 'Opdaterede begivenhed');
                    } else {
                        $idNew = Event::create($data);
                        $this->log('create', 'event', $idNew, 'Oprettede begivenhed');
                    }
                    redirect('/admin/events');
                }
            }
        }

        $this->render('events_form', [
            'event' => $event,
            'error' => $error,
        ]);
    }

    public function deleteEvent(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && verifyCsrfToken((string)($_POST['csrf_token'] ?? ''))) {
            $id = (int)$_POST['id'];
            Event::delete($id);
            $this->log('delete', 'event', $id, 'Slettede begivenhed');
        }
        redirect('/admin/events');
    }

    public function news(): void
    {
        $news = News::all();
        $this->render('news', ['news' => $news]);
    }

    public function newsForm(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $article = $id ? News::find($id) : null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string)$_POST['csrf_token'])) {
                $error = 'Ugyldig sikkerhedstoken.';
            } else {
                $data = $_POST;
                $data['is_published'] = isset($_POST['is_published']) ? 1 : 0;

                if (!empty($_FILES['image']['name'] ?? '')) {
                    $upload = $this->handleUpload('image');
                    if ($upload['ok']) {
                        $data['image_path'] = $upload['path'];
                    } else {
                        $error = $upload['error'];
                    }
                }

                if (!$error) {
                    if ($article) {
                        News::update($article['id'], $data);
                        $this->log('update', 'news', (int)$article['id'], 'Opdaterede nyhed');
                    } else {
                        $idNew = News::create($data);
                        $this->log('create', 'news', $idNew, 'Oprettede nyhed');
                    }
                    redirect('/admin/news');
                }
            }
        }

        $this->render('news_form', [
            'article' => $article,
            'error' => $error,
        ]);
    }

    public function deleteNews(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && verifyCsrfToken((string)($_POST['csrf_token'] ?? ''))) {
            $id = (int)$_POST['id'];
            News::delete($id);
            $this->log('delete', 'news', $id, 'Slettede nyhed');
        }
        redirect('/admin/news');
    }

    public function associations(): void
    {
        $associations = Association::all();
        $this->render('associations', ['associations' => $associations]);
    }

    public function associationForm(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $association = $id ? Association::find($id) : null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string)$_POST['csrf_token'])) {
                $error = 'Ugyldig sikkerhedstoken.';
            } else {
                $data = $_POST;
                $data['is_published'] = isset($_POST['is_published']) ? 1 : 0;
                $data['sort_order'] = (int)($_POST['sort_order'] ?? 0);

                if (!empty($_FILES['logo']['name'] ?? '')) {
                    $upload = $this->handleUpload('logo');
                    if ($upload['ok']) {
                        $data['logo_path'] = $upload['path'];
                    } else {
                        $error = $upload['error'];
                    }
                }

                if (!$error) {
                    if ($association) {
                        Association::update($association['id'], $data);
                        $this->log('update', 'association', (int)$association['id'], 'Opdaterede forening');
                    } else {
                        $idNew = Association::create($data);
                        $this->log('create', 'association', $idNew, 'Oprettede forening');
                    }
                    redirect('/admin/associations');
                }
            }
        }

        $this->render('associations_form', [
            'association' => $association,
            'error' => $error,
        ]);
    }

    public function deleteAssociation(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && verifyCsrfToken((string)($_POST['csrf_token'] ?? ''))) {
            $id = (int)$_POST['id'];
            Association::delete($id);
            $this->log('delete', 'association', $id, 'Slettede forening');
        }
        redirect('/admin/associations');
    }

    public function pages(): void
    {
        $sections = Page::sectionsByPage();
        $this->render('pages', ['sections' => $sections]);
    }

    public function pageSectionForm(): void
    {
        $pageSlug = (string)($_GET['page'] ?? '');
        $sectionKey = (string)($_GET['section'] ?? '');
        if ($pageSlug === '' || $sectionKey === '') {
            redirect('/admin/pages');
        }

        $section = Page::getSection($pageSlug, $sectionKey);
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string)$_POST['csrf_token'])) {
                $error = 'Ugyldig sikkerhedstoken.';
            } else {
                $content = (string)($_POST['content'] ?? '');
                Page::upsertSection($pageSlug, $sectionKey, $content, 'html');
                $this->log('update', 'page_content', null, "Opdaterede sektion {$pageSlug}.{$sectionKey}");
                redirect('/admin/pages');
            }
        }

        $this->render('pages_form', [
            'pageSlug' => $pageSlug,
            'sectionKey' => $sectionKey,
            'section' => $section,
            'error' => $error,
        ]);
    }

    public function users(): void
    {
        requireSudoAdmin();
        $users = User::all();
        $this->render('users', ['users' => $users]);
    }

    public function userForm(): void
    {
        requireSudoAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $user = $id ? User::find($id) : null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !verifyCsrfToken((string)$_POST['csrf_token'])) {
                $error = 'Ugyldig sikkerhedstoken.';
            } else {
                $data = [
                    'username' => trim((string)($_POST['username'] ?? '')),
                    'email' => trim((string)($_POST['email'] ?? '')),
                    'role' => (string)($_POST['role'] ?? 'editor'),
                ];
                $password = (string)($_POST['password'] ?? '');
                if ($password !== '') {
                    $data['password'] = $password;
                }

                if (!$error) {
                    if ($user) {
                        User::update($user['id'], $data);
                        $this->log('update', 'user', (int)$user['id'], 'Opdaterede bruger');
                    } else {
                        if ($password === '') {
                            $error = 'Adgangskode er påkrævet for nye brugere.';
                        } else {
                            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                            $newId = User::create($data);
                            $this->log('create', 'user', $newId, 'Oprettede bruger');
                        }
                    }
                    if (!$error) {
                        redirect('/admin/users');
                    }
                }
            }
        }

        $this->render('users_form', [
            'user' => $user,
            'error' => $error,
        ]);
    }

    public function deleteUser(): void
    {
        requireSudoAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            if (!verifyCsrfToken((string)($_POST['csrf_token'] ?? ''))) {
                redirect('/admin/users');
            }
            if ($id && $id !== (int)($_SESSION['user_id'] ?? 0)) {
                User::delete($id);
                $this->log('delete', 'user', $id, 'Slettede bruger');
            }
        }
        redirect('/admin/users');
    }

    private function handleUpload(string $field): array
    {
        if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['ok' => false, 'error' => 'Ingen fil valgt.'];
        }

        $file = $_FILES[$field];
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return ['ok' => false, 'error' => 'Filupload mislykkedes.'];
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedTypes, true)) {
            return ['ok' => false, 'error' => 'Kun billeder (JPG, PNG, WEBP, GIF) er tilladt.'];
        }

        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => 'bin',
        };

        $uploadsDir = __DIR__ . '/../../public/assets/uploads';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0775, true);
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        $targetPath = $uploadsDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['ok' => false, 'error' => 'Kunne ikke gemme filen.'];
        }

        $publicPath = '/assets/uploads/' . $filename;
        return ['ok' => true, 'path' => $publicPath];
    }
}

