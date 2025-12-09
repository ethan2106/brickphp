<?php

/**
 * Contrôleur page de démonstration des composants
 */

declare(strict_types=1);

namespace App\Controller;

class ComponentsController extends BaseController
{
    public function index(): void
    {
        $this->render('examples/components', [
            'title' => 'Composants UI',
        ]);
    }
}
