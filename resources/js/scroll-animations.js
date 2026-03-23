import AOS from 'aos';

export const initializeScrollAnimations = () => {
    AOS.init({
        once: true,
        duration: 700,
        easing: 'ease-out-cubic',
        offset: 72,
        disable: () => window.matchMedia('(prefers-reduced-motion: reduce)').matches,
    });

    if (document.readyState === 'complete') {
        AOS.refreshHard();

        return;
    }

    window.addEventListener(
        'load',
        () => {
            AOS.refreshHard();
        },
        { once: true },
    );
};
