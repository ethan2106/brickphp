/**
 * BrickPHP v3.0 - Vanilla JS
 *
 * Interactivité légère. Alpine.js gère le reste.
 */

document.addEventListener('DOMContentLoaded', () => {
    console.log('🧱 BrickPHP v3.0 loaded');

    // Auto-dismiss flash messages après 5s
    document.querySelectorAll('[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.3s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }, 5000);
    });
});
