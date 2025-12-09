<header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="<?php route('home'); ?>" class="flex items-center gap-2 text-xl font-bold text-gray-800 hover:text-blue-600 transition-colors">
                <i class="fa-solid fa-cube text-blue-500" aria-hidden="true"></i>
                <span><?= APP_NAME ?></span>
            </a>

            <!-- Navigation Desktop -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="<?php route('home'); ?>"
                   class="text-gray-600 hover:text-blue-600 font-medium transition-colors <?= active_class('home', 'text-blue-600') ?>">
                    Accueil
                </a>
                <a href="<?php route('components'); ?>"
                   class="text-gray-600 hover:text-purple-600 font-medium transition-colors <?= active_class('components', 'text-purple-600') ?>">
                    <i class="fa-solid fa-puzzle-piece mr-1" aria-hidden="true"></i> Composants
                </a>

                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Utilisateur connecté - Dropdown Vanilla JS -->
                    <div class="relative" data-dropdown>
                        <button data-dropdown-trigger
                                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition-all">
                            <i class="fa-solid fa-user-circle text-blue-500" aria-hidden="true"></i>
                            <span><?= e($_SESSION['user']['name']) ?></span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform" data-dropdown-icon aria-hidden="true"></i>
                        </button>

                        <div data-dropdown-menu
                             class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="<?php route('profile'); ?>" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-user" aria-hidden="true"></i> Profil
                            </a>
                            <a href="<?php route('settings'); ?>" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fa-solid fa-gear" aria-hidden="true"></i> Paramètres
                            </a>
                            <hr class="my-2 border-gray-100">
                            <form action="<?php route('logout'); ?>" method="POST">
                                <?= csrf_field() ?>
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Utilisateur non connecté -->
                    <a href="<?php route('login'); ?>"
                       class="px-4 py-2 rounded-xl text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        Connexion
                    </a>
                    <a href="<?php route('register'); ?>"
                       class="px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-medium shadow-lg transition-all">
                        Inscription
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Hamburger Mobile -->
            <button type="button"
                    class="md:hidden p-2 rounded-lg hover:bg-gray-100"
                    data-modal-open="mobile-menu"
                    aria-label="Menu">
                <i class="fa-solid fa-bars text-xl text-gray-600" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

<!-- Menu Mobile - Modal Vanilla JS -->
<div data-modal="mobile-menu" class="hidden md:hidden fixed inset-0 z-50">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50" data-modal-close></div>

    <!-- Panel -->
    <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-2xl transform transition-transform duration-200">

        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
            <span class="font-bold text-gray-800"><?= APP_NAME ?></span>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100">
                <i class="fa-solid fa-xmark text-gray-600" aria-hidden="true"></i>
            </button>
        </div>

        <nav class="p-4 space-y-2">
            <a href="<?php route('home'); ?>" class="block px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700 font-medium">
                <i class="fa-solid fa-home mr-2" aria-hidden="true"></i> Accueil
            </a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="<?php route('profile'); ?>" class="block px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700 font-medium">
                    <i class="fa-solid fa-user mr-2" aria-hidden="true"></i> Profil
                </a>
                <form action="<?php route('logout'); ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl hover:bg-red-50 text-red-600 font-medium">
                        <i class="fa-solid fa-sign-out-alt mr-2" aria-hidden="true"></i> Déconnexion
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php route('login'); ?>" class="block px-4 py-3 rounded-xl hover:bg-gray-100 text-gray-700 font-medium">
                    <i class="fa-solid fa-sign-in-alt mr-2" aria-hidden="true"></i> Connexion
                </a>
                <a href="<?php route('register'); ?>" class="block px-4 py-3 rounded-xl bg-blue-500 text-white font-medium text-center">
                    <i class="fa-solid fa-user-plus mr-2" aria-hidden="true"></i> Inscription
                </a>
            <?php endif; ?>
        </nav>
    </div>
</div>
