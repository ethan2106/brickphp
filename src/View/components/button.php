<?php
/**
 * Composant Button
 * 
 * Usage:
 * <?php component('button', [
 *     'text' => 'Cliquer',
 *     'type' => 'submit',
 *     'variant' => 'primary',
 *     'icon' => 'fa-save',
 *     'href' => '/dashboard', // Si lien
 *     'size' => 'md',
 * ]); ?>
 */

$text = $text ?? 'Button';
$type = $type ?? 'button';
$variant = $variant ?? 'primary';
$icon = $icon ?? null;
$href = $href ?? null;
$size = $size ?? 'md';
$class = $class ?? '';
$disabled = $disabled ?? false;

$variants = [
    'primary' => 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white shadow-lg hover:shadow-xl',
    'secondary' => 'bg-gray-100 hover:bg-gray-200 text-gray-700',
    'success' => 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white shadow-lg',
    'danger' => 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white shadow-lg',
    'warning' => 'bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white shadow-lg',
    'ghost' => 'bg-transparent hover:bg-gray-100 text-gray-600',
    'outline' => 'bg-transparent border-2 border-blue-500 text-blue-500 hover:bg-blue-50',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm rounded-lg',
    'md' => 'px-5 py-2.5 rounded-xl',
    'lg' => 'px-8 py-4 text-lg rounded-2xl',
];

$baseClass = 'inline-flex items-center justify-center gap-2 font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 disabled:opacity-50 disabled:cursor-not-allowed';
$variantClass = $variants[$variant] ?? $variants['primary'];
$sizeClass = $sizes[$size] ?? $sizes['md'];

$fullClass = "{$baseClass} {$variantClass} {$sizeClass} {$class}";

if ($href): ?>
<a href="<?= e($href) ?>" class="<?= $fullClass ?>">
    <?php if ($icon): ?><i class="fa-solid <?= e($icon) ?>" aria-hidden="true"></i><?php endif; ?>
    <span><?= e($text) ?></span>
</a>
<?php else: ?>
<button type="<?= e($type) ?>" class="<?= $fullClass ?>" <?= $disabled ? 'disabled' : '' ?>>
    <?php if ($icon): ?><i class="fa-solid <?= e($icon) ?>" aria-hidden="true"></i><?php endif; ?>
    <span><?= e($text) ?></span>
</button>
<?php endif; ?>
