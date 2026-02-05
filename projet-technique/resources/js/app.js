import './bootstrap';
import 'preline';
import { HSStaticMethods, HSDropdown } from 'preline';
import { createIcons, icons } from 'lucide';

// Expose Preline components globally
window.HSStaticMethods = HSStaticMethods;
window.HSDropdown = HSDropdown;
window.createIcons = createIcons;
window.lucideIcons = icons;

console.log('JS: Preline and Lucide successfully imported and exposed to window');

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content Loaded - Initializing UI Components');

    // Initialize Lucide Icons
    if (typeof createIcons === 'function') {
        createIcons({ icons });
        console.log('Lucide: Icons initialized');
    }

    // Initialize Preline
    if (window.HSStaticMethods) {
        console.log('Preline: Executing manual autoInit');
        window.HSStaticMethods.autoInit();

        // Specifically check if HSDropdown is available
        if (window.HSDropdown) {
            console.log('Preline: HSDropdown is available');
        } else {
            console.warn('Preline: HSDropdown is NOT available in window');
        }
    } else {
        console.error('Preline: HSStaticMethods NOT found. Check bundling or import order.');
    }
});

// Watch for changes (Vite HMR)
if (import.meta.hot) {
    import.meta.hot.afterUpdate(() => {
        if (window.HSStaticMethods) {
            window.HSStaticMethods.autoInit();
        }
    });
}
