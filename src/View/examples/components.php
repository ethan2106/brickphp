<?php
/**
 * Page Composants UI - BrickPHP SUPERCAR
 *
 * Démonstration des composants PHP réutilisables + Alpine.js
 */
$title = 'Composants UI';

// Données de démonstration
$users = [
    ['id' => 1, 'name' => 'Alice Dupont', 'email' => 'alice@example.com', 'role' => 'Admin', 'status' => 'active'],
    ['id' => 2, 'name' => 'Bob Martin', 'email' => 'bob@example.com', 'role' => 'User', 'status' => 'active'],
    ['id' => 3, 'name' => 'Claire Bernard', 'email' => 'claire@example.com', 'role' => 'Editor', 'status' => 'inactive'],
];

$stats = [
    ['label' => 'Utilisateurs', 'value' => 1234, 'icon' => 'fa-users', 'color' => 'blue'],
    ['label' => 'Revenus', 'value' => '€12,450', 'icon' => 'fa-euro-sign', 'color' => 'green'],
    ['label' => 'Commandes', 'value' => 89, 'icon' => 'fa-shopping-cart', 'color' => 'purple'],
];
?>

<div class="space-y-12">

    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">🧱 Composants UI</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
            Composants PHP réutilisables + Alpine.js pour l'interactivité.
            <br><strong>Pas de build, pas de node_modules complexes.</strong>
        </p>
    </div>

    <!-- ============================================================
         SECTION: Alertes
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-bell text-blue-500 mr-2"></i>Alertes
        </h2>

        <div class="space-y-4">
            <?php component('alert', ['type' => 'success', 'message' => 'Opération réussie ! Les données ont été sauvegardées.']); ?>
            <?php component('alert', ['type' => 'error', 'message' => 'Une erreur est survenue. Veuillez réessayer.']); ?>
            <?php component('alert', ['type' => 'warning', 'message' => 'Attention : cette action est irréversible.']); ?>
            <?php component('alert', ['type' => 'info', 'message' => 'Information : une mise à jour est disponible.']); ?>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <code class="text-sm text-gray-700">
                &lt;?php component('alert', ['type' => 'success', 'message' => '...']); ?&gt;
            </code>
        </div>
    </section>

    <!-- ============================================================
         SECTION: Badges
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-tag text-purple-500 mr-2"></i>Badges
        </h2>

        <div class="flex flex-wrap gap-3">
            <?php component('badge', ['text' => 'Nouveau', 'color' => 'blue']); ?>
            <?php component('badge', ['text' => 'Populaire', 'color' => 'green']); ?>
            <?php component('badge', ['text' => 'En attente', 'color' => 'yellow']); ?>
            <?php component('badge', ['text' => 'Urgent', 'color' => 'red']); ?>
            <?php component('badge', ['text' => 'Archive', 'color' => 'gray']); ?>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <code class="text-sm text-gray-700">
                &lt;?php component('badge', ['text' => 'Nouveau', 'color' => 'blue']); ?&gt;
            </code>
        </div>
    </section>

    <!-- ============================================================
         SECTION: Boutons
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-hand-pointer text-green-500 mr-2"></i>Boutons
        </h2>

        <div class="flex flex-wrap gap-3">
            <?php component('button', ['text' => 'Primary', 'color' => 'blue']); ?>
            <?php component('button', ['text' => 'Success', 'color' => 'green']); ?>
            <?php component('button', ['text' => 'Danger', 'color' => 'red']); ?>
            <?php component('button', ['text' => 'Avec icône', 'color' => 'purple', 'icon' => 'fa-save']); ?>
            <?php component('button', ['text' => 'Outline', 'color' => 'blue', 'outline' => true]); ?>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <code class="text-sm text-gray-700">
                &lt;?php component('button', ['text' => 'Save', 'color' => 'blue', 'icon' => 'fa-save']); ?&gt;
            </code>
        </div>
    </section>

    <!-- ============================================================
         SECTION: Cards
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-square text-indigo-500 mr-2"></i>Cards
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            <?php component('card', [
                'title' => 'Card Simple',
                'content' => 'Contenu de la card avec du texte descriptif.',
            ]); ?>

            <?php component('card', [
                'title' => 'Avec Footer',
                'content' => 'Cette card a un footer avec des actions.',
                'footer' => '<button class="text-blue-500 hover:underline">En savoir plus →</button>',
            ]); ?>

            <?php component('card', [
                'title' => 'Card Colorée',
                'content' => 'Une card avec une bordure colorée.',
                'color' => 'green',
            ]); ?>
        </div>
    </section>

    <!-- ============================================================
         SECTION: Stats
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-chart-bar text-cyan-500 mr-2"></i>Statistiques
        </h2>

        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($stats as $stat): ?>
                <?php component('stat', $stat); ?>
            <?php endforeach; ?>
        </div>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <code class="text-sm text-gray-700">
                &lt;?php component('stat', ['label' => 'Users', 'value' => 1234, 'icon' => 'fa-users', 'color' => 'blue']); ?&gt;
            </code>
        </div>
    </section>

    <!-- ============================================================
         SECTION: Table
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-table text-orange-500 mr-2"></i>Table
        </h2>

        <?php component('table', [
            'columns' => ['ID', 'Nom', 'Email', 'Rôle', 'Status'],
            'rows' => array_map(fn($u) => [
                $u['id'],
                $u['name'],
                $u['email'],
                $u['role'],
                '<span class="px-2 py-1 text-xs rounded-full ' .
                    ($u['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') . '">' .
                    ucfirst($u['status']) . '</span>'
            ], $users),
        ]); ?>
    </section>

    <!-- ============================================================
         SECTION: Alpine.js - Interactivité
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-bolt text-yellow-500 mr-2"></i>Alpine.js - Interactivité
        </h2>

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Dropdown Alpine -->
            <div class="border border-gray-200 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-3">Dropdown</h3>
                <div x-data="{ open: false }" class="relative inline-block">
                    <button @click="open = !open" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg flex items-center gap-2">
                        Menu <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl border py-2 z-10">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Option 1</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Option 2</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Option 3</a>
                    </div>
                </div>
                <pre class="mt-3 text-xs bg-gray-50 p-2 rounded overflow-x-auto"><code>x-data="{ open: false }"
@click="open = !open"
x-show="open"</code></pre>
            </div>

            <!-- Modal Alpine -->
            <div class="border border-gray-200 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-3">Modal</h3>
                <div x-data="{ show: false }">
                    <button @click="show = true" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg">
                        Ouvrir Modal
                    </button>

                    <!-- Backdrop + Modal -->
                    <template x-if="show">
                        <div class="fixed inset-0 z-40">
                            <div class="fixed inset-0 bg-black/50" @click="show = false"></div>
                            <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl shadow-2xl p-6 z-50 w-96">
                                <h3 class="text-xl font-bold mb-4">Modal Alpine.js</h3>
                                <p class="text-gray-600 mb-4">Simple, léger, sans dépendances.</p>
                                <button @click="show = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">Fermer</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tabs Alpine -->
            <div class="border border-gray-200 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-3">Tabs</h3>
                <div x-data="{ tab: 'tab1' }">
                    <div class="flex gap-1 border-b border-gray-200 mb-4">
                        <button @click="tab = 'tab1'"
                                :class="tab === 'tab1' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="px-4 py-2 border-b-2 font-medium">Tab 1</button>
                        <button @click="tab = 'tab2'"
                                :class="tab === 'tab2' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500'"
                                class="px-4 py-2 border-b-2 font-medium">Tab 2</button>
                    </div>
                    <div x-show="tab === 'tab1'" class="text-gray-600">Contenu du premier onglet.</div>
                    <div x-show="tab === 'tab2'" class="text-gray-600">Contenu du deuxième onglet.</div>
                </div>
            </div>

            <!-- Counter Alpine -->
            <div class="border border-gray-200 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-3">Compteur</h3>
                <div x-data="{ count: 0 }" class="flex items-center gap-4">
                    <button @click="count--" class="w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xl">-</button>
                    <span x-text="count" class="text-3xl font-bold text-gray-800 w-12 text-center"></span>
                    <button @click="count++" class="w-10 h-10 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xl">+</button>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================
         SECTION: Inputs
         ============================================================ -->
    <section class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fa-solid fa-keyboard text-teal-500 mr-2"></i>Formulaires
        </h2>

        <form class="grid md:grid-cols-2 gap-6" onsubmit="return false;">
            <?php component('input', [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
                'placeholder' => 'vous@exemple.com',
                'required' => true,
            ]); ?>

            <?php component('input', [
                'name' => 'password',
                'label' => 'Mot de passe',
                'type' => 'password',
                'placeholder' => '••••••••',
            ]); ?>

            <?php component('input', [
                'name' => 'message',
                'label' => 'Message',
                'type' => 'textarea',
                'placeholder' => 'Votre message...',
                'rows' => 3,
            ]); ?>

            <div class="md:col-span-2">
                <?php component('button', ['text' => 'Envoyer', 'color' => 'blue', 'icon' => 'fa-paper-plane', 'type' => 'submit']); ?>
            </div>
        </form>
    </section>

</div>
