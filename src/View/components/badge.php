<?php
/**
 * Composant Badge/Tag
 * 
 * Usage:
 * <?php component('badge', ['text' => 'Nouveau', 'color' => 'green']); ?>
 */

$text = $text ?? '';
$color = $color ?? 'blue';
$size = $size ?? 'md';
$icon = $icon ?? null;

$colors = [
    'blue' => 'bg-blue-100 text-blue-700',
    'green' => 'bg-green-100 text-green-700',
    'red' => 'bg-red-100 text-red-700',
    'yellow' => 'bg-yellow-100 text-yellow-700',
    'purple' => 'bg-purple-100 text-purple-700',
    'gray' => 'bg-gray-100 text-gray-700',
    'orange' => 'bg-orange-100 text-orange-700',
    'cyan' => 'bg-cyan-100 text-cyan-700',
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-sm',
    'lg' => 'px-3 py-1.5 text-base',
];

$colorClass = $colors[$color] ?? $colors['blue'];
$sizeClass = $sizes[$size] ?? $sizes['md'];
?>

<span class="inline-flex items-center gap-1 <?= $colorClass ?> <?= $sizeClass ?> font-medium rounded-full">
    <?php if ($icon): ?><i class="fa-solid <?= e($icon) ?>" aria-hidden="true"></i><?php endif; ?>
    <?= e($text) ?>
</span>
