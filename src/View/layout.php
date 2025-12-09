<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title ?? 'App') ?> - <?= APP_NAME ?></title>

    <!--
    ╔══════════════════════════════════════════════════════════════╗
    ║  BrickPHP SUPERCAR - PHP + Tailwind + Alpine.js              ║
    ║                                                               ║
    ║  Dev:  npm run dev    (Tailwind watch)                       ║
    ║  Prod: npm run build  (Tailwind minified)                    ║
    ╚══════════════════════════════════════════════════════════════╝
    -->

    <!-- Font Awesome (local) - MUST be first -->
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">

    <!-- Tailwind CSS -->
    <?php if (defined('APP_DEBUG') && APP_DEBUG && !file_exists(__DIR__ . '/../../public/css/app.css')): ?>
        <script src="https://cdn.tailwindcss.com"></script>
    <?php else: ?>
        <link rel="stylesheet" href="/css/app.css">
    <?php endif; ?>

    <!-- Alpine.js (local) -->
    <script defer src="/assets/js/alpine.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-purple-50 font-sans">

    <!-- Skip link accessibilité -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:bg-white focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg focus:z-50">
        Aller au contenu
    </a>

    <!-- Header -->
    <?php require __DIR__ . '/components/header.php'; ?>

    <!-- Flash messages -->
    <?php require __DIR__ . '/components/flash.php'; ?>

    <!-- Contenu principal -->
    <main id="main-content" class="container mx-auto px-4 py-8">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php require __DIR__ . '/components/footer.php'; ?>

    <!-- Vanilla JS (optionnel) -->
    <script src="/js/app.js" defer></script>

</body>
</html>
