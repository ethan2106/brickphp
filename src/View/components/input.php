<?php
/**
 * Composant Input
 * 
 * CORRECTIONS APPLIQUÉES (v1.1):
 * - Support $attributes pour attributs additionnels (ex: v-model Vue.js)
 * - Dark mode compatible styling
 * 
 * Usage:
 * <?php component('input', [
 *     'name' => 'email',
 *     'label' => 'Email',
 *     'type' => 'email',
 *     'placeholder' => 'vous@exemple.com',
 *     'required' => true,
 *     'icon' => 'fa-envelope',
 *     'value' => $oldValue ?? '',
 *     'error' => $errors['email'] ?? null,
 *     'attributes' => 'data-validate="email"', // Attributs additionnels
 * ]); ?>
 */

$name = $name ?? 'input';
$label = $label ?? null;
$type = $type ?? 'text';
$placeholder = $placeholder ?? '';
$required = $required ?? false;
$icon = $icon ?? null;
$value = $value ?? '';
$error = $error ?? null;
$class = $class ?? '';
$id = $id ?? $name;
$disabled = $disabled ?? false;
$autocomplete = $autocomplete ?? null;
$attributes = $attributes ?? ''; // FIX: Support pour attributs additionnels
?>

<div class="<?= $class ?>">
    <?php if ($label): ?>
    <label for="<?= e($id) ?>" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        <?= e($label) ?>
        <?php if ($required): ?><span class="text-red-500">*</span><?php endif; ?>
    </label>
    <?php endif; ?>
    
    <div class="relative">
        <?php if ($icon): ?>
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i class="fa-solid <?= e($icon) ?> text-gray-400" aria-hidden="true"></i>
        </div>
        <?php endif; ?>
        
        <input type="<?= e($type) ?>"
               id="<?= e($id) ?>"
               name="<?= e($name) ?>"
               value="<?= e($value) ?>"
               placeholder="<?= e($placeholder) ?>"
               <?= $required ? 'required' : '' ?>
               <?= $disabled ? 'disabled' : '' ?>
               <?= $autocomplete ? 'autocomplete="' . e($autocomplete) . '"' : '' ?>
               <?= $attributes ?>
               class="w-full <?= $icon ? 'pl-11' : 'px-4' ?> pr-4 py-3 rounded-xl border 
                      <?= $error ? 'border-red-300 focus:border-red-400 focus:ring-red-100 dark:border-red-500 dark:focus:border-red-400' : 'border-gray-200 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-100 dark:focus:border-blue-500' ?>
                      bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                      placeholder-gray-400 dark:placeholder-gray-500
                      focus:ring-2 outline-none transition-all
                      disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
    </div>
    
    <?php if ($error): ?>
    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
        <i class="fa-solid fa-exclamation-circle" aria-hidden="true"></i>
        <?= e($error) ?>
    </p>
    <?php endif; ?>
</div>
