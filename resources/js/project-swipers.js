import Swiper from 'swiper';
import { A11y, EffectFade, Keyboard, Navigation } from 'swiper/modules';

const projectSwipers = new Map();
const projectStoryViews = new Map();
const suppressedProjectToggles = new Set();
const suppressionTimeouts = new Map();

const updateProjectSwiperCounter = (swiper, article) => {
    const currentSlideElement = article.querySelector('[data-project-swiper-current]');

    if (! currentSlideElement) {
        return;
    }

    currentSlideElement.textContent = String(swiper.realIndex + 1);
};

const playProjectVideo = (videoElement) => {
    videoElement.muted = true;
    videoElement.loop = true;
    videoElement.playsInline = true;

    const playPromise = videoElement.play();

    if (playPromise && typeof playPromise.catch === 'function') {
        playPromise.catch(() => {});
    }
};

const pauseProjectVideo = (videoElement, reset = false) => {
    videoElement.pause();

    if (reset) {
        videoElement.currentTime = 0;
    }
};

const syncEmbeddedProjectMediaPlayback = (article, swiper) => {
    if (! article) {
        return;
    }

    article.querySelectorAll('.js-project-swiper video').forEach((videoElement) => {
        const slideElement = videoElement.closest('.swiper-slide');
        const isActiveSlide = slideElement?.classList.contains('swiper-slide-active') ?? false;

        if (isActiveSlide) {
            playProjectVideo(videoElement);

            return;
        }

        pauseProjectVideo(videoElement, swiper.allowTouchMove === false);
    });
};

const getStoryPanelVisibilityRatio = (storyView, panelElement) => {
    const viewportLeft = storyView.scrollLeft;
    const viewportRight = viewportLeft + storyView.clientWidth;
    const panelLeft = panelElement.offsetLeft;
    const panelRight = panelLeft + panelElement.offsetWidth;
    const visibleWidth = Math.max(0, Math.min(viewportRight, panelRight) - Math.max(viewportLeft, panelLeft));
    const baselineWidth = Math.max(1, Math.min(panelElement.offsetWidth, storyView.clientWidth));

    return visibleWidth / baselineWidth;
};

const syncStandaloneProjectMediaPlayback = (article, storyView) => {
    if (! article || ! storyView) {
        return;
    }

    let activePanel = null;
    let activeRatio = 0;

    article.querySelectorAll('.project-story-panel').forEach((panelElement) => {
        const ratio = getStoryPanelVisibilityRatio(storyView, panelElement);

        if (ratio > activeRatio) {
            activeRatio = ratio;
            activePanel = panelElement;
        }
    });

    article.querySelectorAll('[data-project-story-view] video').forEach((videoElement) => {
        const panelElement = videoElement.closest('.project-story-panel');
        const isActivePanel = activePanel !== null && panelElement === activePanel;

        if (isActivePanel) {
            playProjectVideo(videoElement);

            return;
        }

        pauseProjectVideo(videoElement, storyView.dataset.active !== 'true');
    });
};

const clearProjectToggleSuppression = (projectId) => {
    const existingTimeout = suppressionTimeouts.get(projectId);

    if (existingTimeout) {
        window.clearTimeout(existingTimeout);
        suppressionTimeouts.delete(projectId);
    }

    suppressedProjectToggles.delete(projectId);
};

const suppressProjectToggle = (projectId, delay = 180) => {
    if (! projectId) {
        return;
    }

    clearProjectToggleSuppression(projectId);
    suppressedProjectToggles.add(projectId);

    const timeoutId = window.setTimeout(() => {
        suppressionTimeouts.delete(projectId);
        suppressedProjectToggles.delete(projectId);
    }, delay);

    suppressionTimeouts.set(projectId, timeoutId);
};

const resolveProjectSwiper = (projectId) => {
    const mappedSwiper = projectSwipers.get(projectId);

    if (mappedSwiper) {
        return mappedSwiper;
    }

    return document.querySelector(`[data-project-id="${projectId}"] .js-project-swiper`)?.swiper ?? null;
};

const resolveProjectStoryView = (projectId) => {
    const mappedStoryView = projectStoryViews.get(projectId);

    if (mappedStoryView) {
        return mappedStoryView;
    }

    return document.querySelector(`[data-project-id="${projectId}"] .js-project-story-view`) ?? null;
};

const bindStandaloneStoryView = (projectId, article, storyView) => {
    if (! projectId || ! storyView || projectStoryViews.has(projectId)) {
        return;
    }

    projectStoryViews.set(projectId, storyView);
    storyView.dataset.active = 'false';

    const syncPlayback = () => {
        syncStandaloneProjectMediaPlayback(article, storyView);
    };

    storyView.addEventListener(
        'wheel',
        (event) => {
            if (storyView.dataset.active !== 'true') {
                return;
            }

            const horizontalDelta = event.deltaX;
            const verticalDelta = event.deltaY;
            const usesNativeHorizontalGesture = Math.abs(horizontalDelta) > 0.5;

            if (usesNativeHorizontalGesture) {
                suppressProjectToggle(projectId, 220);

                return;
            }

            const isLikelyMouseWheel =
                Math.abs(horizontalDelta) < 0.5
                && Math.abs(verticalDelta) >= 40
                && ! event.ctrlKey;

            if (! isLikelyMouseWheel) {
                return;
            }

            const delta =
                event.deltaMode === 1
                    ? verticalDelta * 16
                    : event.deltaMode === 2
                        ? verticalDelta * window.innerHeight
                        : verticalDelta;

            if (Math.abs(delta) < 4 || storyView.scrollWidth <= storyView.clientWidth + 1) {
                return;
            }

            const maxScrollLeft = storyView.scrollWidth - storyView.clientWidth;
            const nextScrollLeft = Math.max(0, Math.min(maxScrollLeft, storyView.scrollLeft + delta));

            if (nextScrollLeft === storyView.scrollLeft) {
                return;
            }

            event.preventDefault();
            storyView.scrollTo({
                left: nextScrollLeft,
                behavior: 'auto',
            });
            suppressProjectToggle(projectId, 220);
            syncPlayback();
        },
        { passive: false },
    );
    storyView.addEventListener(
        'scroll',
        () => {
            if (storyView.dataset.active === 'true') {
                syncPlayback();
            }
        },
        { passive: true },
    );

    syncPlayback();
};

const configureProjectSwiperState = (projectId, options = {}) => {
    const {
        allowTouchMove = false,
        enableKeyboard = false,
        resetToFirstSlide = false,
    } = options;

    const storyView = resolveProjectStoryView(projectId);

    if (storyView) {
        storyView.dataset.active = allowTouchMove ? 'true' : 'false';

        if (resetToFirstSlide) {
            storyView.scrollTo({ left: 0, behavior: 'auto' });
        }

        syncStandaloneProjectMediaPlayback(storyView.closest('[data-project-id]'), storyView);

        return;
    }

    const swiper = resolveProjectSwiper(projectId);

    if (! swiper) {
        return;
    }

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
    syncEmbeddedProjectMediaPlayback(swiper.el.closest('[data-project-id]'), swiper);
};

const bindGestureSuppression = (projectId) => ({
    touchStart(instance) {
        instance.__gestureMoved = false;
        clearProjectToggleSuppression(projectId);
    },
    sliderFirstMove(instance) {
        instance.__gestureMoved = true;
        suppressProjectToggle(projectId);
    },
    touchEnd(instance) {
        if (instance.__gestureMoved) {
            suppressProjectToggle(projectId);

            return;
        }

        clearProjectToggleSuppression(projectId);
    },
});

export const initializeProjectSwipers = (root = document) => {
    root.querySelectorAll('[data-project-id]').forEach((article) => {
        const projectId = article.dataset.projectId;
        const isStandalone = article.closest('.portfolio-section--standalone') !== null;

        if (! projectId) {
            return;
        }

        if (isStandalone) {
            bindStandaloneStoryView(projectId, article, article.querySelector('.js-project-story-view'));

            return;
        }

        const swiperElement = article.querySelector('.js-project-swiper');

        if (! swiperElement || projectSwipers.has(projectId)) {
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
                ...bindGestureSuppression(projectId),
                init(instance) {
                    updateProjectSwiperCounter(instance, article);
                    syncEmbeddedProjectMediaPlayback(article, instance);
                },
                slideChange(instance) {
                    updateProjectSwiperCounter(instance, article);
                    syncEmbeddedProjectMediaPlayback(article, instance);
                },
            },
        });

        projectSwipers.set(projectId, swiper);
    });
};

export const activateProjectSwiper = (projectId) => {
    requestAnimationFrame(() => {
        configureProjectSwiperState(projectId, {
            allowTouchMove: true,
            enableKeyboard: true,
            resetToFirstSlide: true,
        });
    });
};

export const deactivateProjectSwiper = (projectId) => {
    configureProjectSwiperState(projectId, {
        allowTouchMove: false,
        enableKeyboard: false,
        resetToFirstSlide: false,
    });
};

export const resetProjectSwiper = (projectId) => {
    configureProjectSwiperState(projectId, {
        allowTouchMove: false,
        enableKeyboard: false,
        resetToFirstSlide: true,
    });
};

export const shouldIgnoreProjectToggle = (projectId) => suppressedProjectToggles.has(projectId);
