<?php
/**
 * Composant Modal - Vanilla JS
 * 
 * Usage:
 * <?php component('modal', [
 *     'id' => 'confirm-modal',
 *     'title' => 'Confirmer',
 *     'content' => '<p>Êtes-vous sûr ?</p>',
 *     'size' => 'md',
 * ]); ?>
 * 
 * Ouvrir: <button data-modal-open="confirm-modal">Ouvrir</button>
 */

$id = $id ?? 'modal';
$title = $title ?? '';
$content = $content ?? '';
$size = $size ?? 'md';
$footer = $footer ?? null;

$sizes = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
    'full' => 'max-w-full mx-4',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
?>

<div data-modal="<?= e($id) ?>"
     class="hidden fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="<?= e($id) ?>-title"
     role="dialog"
     aria-modal="true">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
         data-modal-close></div>
    
    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full <?= $sizeClass ?> bg-white rounded-2xl shadow-2xl transform transition-all animate-scale-in">
            
            <!-- Header -->
            <?php if ($title): ?>
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 id="<?= e($id) ?>-title" class="text-xl font-bold text-gray-800"><?= e($title) ?></h3>
                <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
            <?php endif; ?>
            
            <!-- Content -->
            <div class="p-6">
                <?= $content ?>
            </div>
            
            <!-- Footer -->
            <?php if ($footer): ?>
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-100 bg-gray-50 rounded-b-2xl">
                <?= $footer ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
