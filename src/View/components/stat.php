<?php
/**
 * Composant Stats Card (Dashboard style)
 * 
 * Usage:
 * <?php component('stat', [
 *     'label' => 'Utilisateurs',
 *     'value' => '1,234',
 *     'icon' => 'fa-users',
 *     'color' => 'blue',
 *     'trend' => '+12%',
 *     'trendUp' => true,
 * ]); ?>
 */

$label = $label ?? 'Stat';
$value = $value ?? '0';
$icon = $icon ?? 'fa-chart-bar';
$color = $color ?? 'blue';
$trend = $trend ?? null;
$trendUp = $trendUp ?? true;

$colors = [
    'blue' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-100', 'text' => 'text-blue-500'],
    'green' => ['bg' => 'bg-green-500', 'light' => 'bg-green-100', 'text' => 'text-green-500'],
    'red' => ['bg' => 'bg-red-500', 'light' => 'bg-red-100', 'text' => 'text-red-500'],
    'purple' => ['bg' => 'bg-purple-500', 'light' => 'bg-purple-100', 'text' => 'text-purple-500'],
    'orange' => ['bg' => 'bg-orange-500', 'light' => 'bg-orange-100', 'text' => 'text-orange-500'],
    'cyan' => ['bg' => 'bg-cyan-500', 'light' => 'bg-cyan-100', 'text' => 'text-cyan-500'],
];
$c = $colors[$color] ?? $colors['blue'];
?>

<div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-100 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1"><?= e($label) ?></p>
            <p class="text-3xl font-bold text-gray-800"><?= e($value) ?></p>
            
            <?php if ($trend): ?>
            <p class="mt-2 flex items-center gap-1 text-sm <?= $trendUp ? 'text-green-600' : 'text-red-600' ?>">
                <i class="fa-solid <?= $trendUp ? 'fa-arrow-up' : 'fa-arrow-down' ?>" aria-hidden="true"></i>
                <?= e($trend) ?>
            </p>
            <?php endif; ?>
        </div>
        
        <div class="w-14 h-14 <?= $c['light'] ?> rounded-2xl flex items-center justify-center">
            <i class="fa-solid <?= e($icon) ?> <?= $c['text'] ?> text-2xl" aria-hidden="true"></i>
        </div>
    </div>
</div>
