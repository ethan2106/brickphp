<?php
/**
 * Composant Table
 * 
 * Usage:
 * <?php component('table', [
 *     'headers' => ['Nom', 'Email', 'Actions'],
 *     'rows' => [
 *         ['Jean', 'jean@mail.com', '<a href="#">Éditer</a>'],
 *         ['Marie', 'marie@mail.com', '<a href="#">Éditer</a>'],
 *     ],
 *     'striped' => true,
 * ]); ?>
 */

$headers = $headers ?? [];
$rows = $rows ?? [];
$striped = $striped ?? false;
$hoverable = $hoverable ?? true;
$emptyMessage = $emptyMessage ?? 'Aucune donnée';
?>

<div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <?php if (!empty($headers)): ?>
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <?php foreach ($headers as $header): ?>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <?= e($header) ?>
                    </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <?php endif; ?>
            
            <tbody class="divide-y divide-gray-100">
                <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="<?= count($headers) ?>" class="px-6 py-12 text-center text-gray-500">
                        <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-3" aria-hidden="true"></i>
                        <p><?= e($emptyMessage) ?></p>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($rows as $index => $row): ?>
                <tr class="<?= $striped && $index % 2 ? 'bg-gray-50/50' : '' ?> <?= $hoverable ? 'hover:bg-blue-50/50' : '' ?> transition-colors">
                    <?php foreach ($row as $cell): ?>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <?= $cell ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
