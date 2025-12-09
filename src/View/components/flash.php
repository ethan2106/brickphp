<?php
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

if ($flash):
    $colors = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-exclamation-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
    ];
    $type = $flash['type'] ?? 'info';
?>
<!-- Flash message with Vanilla JS auto-dismiss -->
<div data-flash 
     data-flash-duration="5000"
     class="container mx-auto px-4 mt-4 animate-fade-in">
    <div class="<?= $colors[$type] ?? $colors['info'] ?> border-l-4 p-4 rounded-r-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <i class="fa-solid <?= $icons[$type] ?? $icons['info'] ?>" aria-hidden="true"></i>
            <span><?= e($flash['message']) ?></span>
        </div>
        <button data-flash-close class="hover:opacity-70">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
</div>
<?php endif; ?>
