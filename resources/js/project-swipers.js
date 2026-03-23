import Swiper from 'swiper';
import { A11y, EffectFade, Keyboard, Navigation } from 'swiper/modules';

// Keep one swiper per project card
const projectSwipers = new Map();

const updateProjectSwiperCounter = (swiper, article) => {
    const currentSlideElement = article.querySelector('[data-project-swiper-current]');

    if (! currentSlideElement) {
        return;
    }

    currentSlideElement.textContent = String(swiper.realIndex + 1);
};

const configureProjectSwiperState = (projectId, options = {}) => {
    const swiper = projectSwipers.get(projectId);

    if (! swiper) {
        return;
    }

    const {
        allowTouchMove = false,
        enableKeyboard = false,
        resetToFirstSlide = false,
    } = options;

    // Swipe only when the card is open
    swiper.allowTouchMove = allowTouchMove;

    if (enableKeyboard) {
        swiper.keyboard.enable();
    } else {
        swiper.keyboard.disable();
    }

    if (resetToFirstSlide) {
        swiper.slideTo(0, 0, false);
    }

    swiper.update();
};

export const initializeProjectSwipers = (root = document) => {
    root.querySelectorAll('[data-project-id]').forEach((article) => {
        const projectId = article.dataset.projectId;
        const swiperElement = article.querySelector('.js-project-swiper');

        if (! projectId || ! swiperElement || projectSwipers.has(projectId)) {
            return;
        }

        const previousButton = article.querySelector('.js-project-swiper-prev');
        const nextButton = article.querySelector('.js-project-swiper-next');

        const swiper = new Swiper(swiperElement, {
            modules: [A11y, EffectFade, Keyboard, Navigation],
            effect: 'fade',
            speed: 720,
            grabCursor: true,
            loop: true,
            watchSlidesProgress: true,
            threshold: 8,
            allowTouchMove: false,
            keyboard: {
                enabled: false,
                onlyInViewport: true,
            },
            navigation: {
                prevEl: previousButton,
                nextEl: nextButton,
            },
            fadeEffect: {
                crossFade: true,
            },
            on: {
                init(instance) {
                    updateProjectSwiperCounter(instance, article);
                },
                slideChange(instance) {
                    updateProjectSwiperCounter(instance, article);
                },
            },
        });

        projectSwipers.set(projectId, swiper);
    });
};

export const activateProjectSwiper = (projectId) => {
    // Wait for the expanded layout before resetting
    requestAnimationFrame(() => {
        configureProjectSwiperState(projectId, {
            allowTouchMove: true,
            enableKeyboard: true,
            resetToFirstSlide: true,
        });
    });
};

export const resetProjectSwiper = (projectId) => {
    configureProjectSwiperState(projectId, {
        allowTouchMove: false,
        enableKeyboard: false,
        resetToFirstSlide: true,
    });
};
