<?php
declare(strict_types=1);

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/Association.php';

class AssociationController
{
    public function index(): void
    {
        $associations = Association::published();
        $viewFile = __DIR__ . '/../views/pages/foreninger.php';
        include $viewFile;
    }
}

