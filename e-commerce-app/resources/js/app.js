import './bootstrap';
import 'preline';
import.meta.glob([
    '../images/**',
]);

document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
})
