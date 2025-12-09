<?php
/**
 * Composant Card - Réutilisable
 * 
 * Usage:
 * <?php component('card', [
 *     'title' => 'Mon titre',
 *     'icon' => 'fa-user',
 *     'color' => 'blue',
 *     'content' => 'Mon contenu...'
 * ]); ?>
 */

$title = $title ?? '';
$icon = $icon ?? null;
$color = $color ?? 'blue';
$content = $content ?? '';
$footer = $footer ?? null;

$colors = [
    'blue' => 'bg-blue-100 text-blue-500',
    'green' => 'bg-green-100 text-green-500',
    'red' => 'bg-red-100 text-red-500',
    'purple' => 'bg-purple-100 text-purple-500',
    'orange' => 'bg-orange-100 text-orange-500',
    'cyan' => 'bg-cyan-100 text-cyan-500',
    'gray' => 'bg-gray-100 text-gray-500',
];
$iconBg = $colors[$color] ?? $colors['blue'];
?>

<div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <?php if ($title || $icon): ?>
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center gap-4">
            <?php if ($icon): ?>
            <div class="w-12 h-12 <?= $iconBg ?> rounded-xl flex items-center justify-center">
                <i class="fa-solid <?= e($icon) ?> text-xl" aria-hidden="true"></i>
            </div>
            <?php endif; ?>
            <?php if ($title): ?>
            <h3 class="text-lg font-bold text-gray-800"><?= e($title) ?></h3>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="p-6">
        <?= $content ?>
    </div>
    
    <?php if ($footer): ?>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        <?= $footer ?>
    </div>
    <?php endif; ?>
</div>
