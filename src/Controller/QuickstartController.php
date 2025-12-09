<?php

/**
 * Contrôleur Page Quickstart / Tutoriel
 */

declare(strict_types=1);

namespace App\Controller;

class QuickstartController extends BaseController
{
    public function index(): void
    {
        $this->render('quickstart', [
            'title' => 'Démarrage rapide',
        ]);
    }
}
