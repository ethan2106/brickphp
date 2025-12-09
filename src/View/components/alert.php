<?php
/**
 * Composant Alert - Vanilla JS
 * 
 * Usage:
 * <?php component('alert', [
 *     'type' => 'success',
 *     'message' => 'Opération réussie !',
 *     'dismissible' => true,
 * ]); ?>
 */

$type = $type ?? 'info';
$message = $message ?? '';
$title = $title ?? null;
$dismissible = $dismissible ?? false;

$styles = [
    'success' => [
        'bg' => 'bg-green-50 border-green-400',
        'text' => 'text-green-800',
        'icon' => 'fa-check-circle text-green-500',
    ],
    'error' => [
        'bg' => 'bg-red-50 border-red-400',
        'text' => 'text-red-800',
        'icon' => 'fa-exclamation-circle text-red-500',
    ],
    'warning' => [
        'bg' => 'bg-yellow-50 border-yellow-400',
        'text' => 'text-yellow-800',
        'icon' => 'fa-exclamation-triangle text-yellow-500',
    ],
    'info' => [
        'bg' => 'bg-blue-50 border-blue-400',
        'text' => 'text-blue-800',
        'icon' => 'fa-info-circle text-blue-500',
    ],
];
$s = $styles[$type] ?? $styles['info'];
?>

<div <?= $dismissible ? 'data-alert' : '' ?> class="<?= $s['bg'] ?> border-l-4 rounded-r-xl p-4 animate-fade-in">
    <div class="flex items-start gap-3">
        <i class="fa-solid <?= $s['icon'] ?> mt-0.5" aria-hidden="true"></i>
        <div class="flex-1">
            <?php if ($title): ?>
            <p class="font-bold <?= $s['text'] ?>"><?= e($title) ?></p>
            <?php endif; ?>
            <p class="<?= $s['text'] ?>"><?= e($message) ?></p>
        </div>
        <?php if ($dismissible): ?>
        <button data-alert-close class="<?= $s['text'] ?> hover:opacity-70">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
        <?php endif; ?>
    </div>
</div>
