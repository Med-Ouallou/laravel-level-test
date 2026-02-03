import './bootstrap';
import 'preline';
import { HSStaticMethods, HSDropdown } from 'preline';
import { createIcons, icons } from 'lucide';

window.HSStaticMethods = HSStaticMethods;
window.HSDropdown = HSDropdown;
window.createIcons = createIcons;
window.lucideIcons = icons;

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content Loaded - Initializing UI');
    createIcons({ icons });

    if (window.HSStaticMethods) {
        console.log('Preline: manual autoInit');
        window.HSStaticMethods.autoInit();
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
