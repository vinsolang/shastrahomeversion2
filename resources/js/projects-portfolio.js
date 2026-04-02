const prefersReducedMotion =
    typeof window !== 'undefined' && typeof window.matchMedia === 'function'
        ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
        : false;

const STANDALONE_MORPH_DURATION = 2200;
const STANDALONE_SCROLL_RESET_DURATION = 320;
const STANDALONE_VIEWPORT_SCROLL_MAX_DURATION = 650;
const previewAnimations = new Map();

const waitForAnimation = (animation) => {
    if (! animation) {
        return Promise.resolve();
    }

    return Promise.all([
        animation.finished.catch(() => {}),
        new Promise((resolve) => {
            window.setTimeout(resolve, STANDALONE_MORPH_DURATION);
        }),
    ]).then(() => {});
};

const easeOutCubic = (value) => 1 - ((1 - value) ** 3);

const getPreviewElement = (root, projectId) =>
    root?.querySelector(`[data-project-id="${projectId}"] [data-project-preview]`) ?? null;

const getStoryViewElement = (root, projectId) =>
    root?.querySelector(`[data-project-id="${projectId}"] .js-project-story-view`) ?? null;

const getProjectCardElement = (root, projectId) =>
    root?.querySelector(`[data-project-id="${projectId}"]`) ?? null;

const capturePreviewRect = (root, projectId) => {
    const preview = getPreviewElement(root, projectId);

    if (! preview) {
        return null;
    }

    return {
        element: preview,
        rect: preview.getBoundingClientRect(),
    };
};

const normalizeStoryViewPosition = (root, projectId) => {
    const storyView = getStoryViewElement(root, projectId);

    if (! storyView) {
        return Promise.resolve();
    }

    const initialScrollLeft = storyView.scrollLeft;

    if (initialScrollLeft <= 2) {
        storyView.scrollLeft = 0;

        return Promise.resolve();
    }

    return new Promise((resolve) => {
        const startedAt = performance.now();

        const step = (now) => {
            const progress = Math.min(1, (now - startedAt) / STANDALONE_SCROLL_RESET_DURATION);
            const easedProgress = easeOutCubic(progress);

            storyView.scrollLeft = initialScrollLeft * (1 - easedProgress);

            if (progress < 1) {
                window.requestAnimationFrame(step);

                return;
            }

            storyView.scrollLeft = 0;
            resolve();
        };

        window.requestAnimationFrame(step);
    });
};

const scrollProjectCardIntoView = (root, projectId) => {
    const projectCard = getProjectCardElement(root, projectId);

    if (! projectCard) {
        return Promise.resolve();
    }

    const currentScrollY = window.scrollY;
    const rect = projectCard.getBoundingClientRect();
    const viewportOffset = Math.max(88, Math.min(160, window.innerHeight * 0.16));
    const maxScrollY = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
    const targetScrollY = Math.max(
        0,
        Math.min(maxScrollY, currentScrollY + rect.top - viewportOffset),
    );
    const scrollDistance = targetScrollY - currentScrollY;

    if (Math.abs(scrollDistance) < 8) {
        return Promise.resolve();
    }

    const duration = Math.min(
        STANDALONE_VIEWPORT_SCROLL_MAX_DURATION,
        Math.max(320, Math.abs(scrollDistance) * 0.55),
    );

    return new Promise((resolve) => {
        const startedAt = performance.now();

        const step = (now) => {
            const progress = Math.min(1, (now - startedAt) / duration);
            const easedProgress = easeOutCubic(progress);

            window.scrollTo({
                top: currentScrollY + (scrollDistance * easedProgress),
                behavior: 'auto',
            });

            if (progress < 1) {
                window.requestAnimationFrame(step);

                return;
            }

            window.scrollTo({
                top: targetScrollY,
                behavior: 'auto',
            });
            resolve();
        };

        window.requestAnimationFrame(step);
    });
};

const animatePreviewMorph = (root, projectId, previousRect) => {
    if (prefersReducedMotion || ! previousRect) {
        return null;
    }

    const preview = getPreviewElement(root, projectId);

    if (! preview || typeof preview.animate !== 'function') {
        return null;
    }

    const currentRect = preview.getBoundingClientRect();
    const deltaX = previousRect.left - currentRect.left;
    const deltaY = previousRect.top - currentRect.top;
    const scaleX = previousRect.width / currentRect.width;
    const scaleY = previousRect.height / currentRect.height;

    if (
        Math.abs(deltaX) < 0.5 &&
        Math.abs(deltaY) < 0.5 &&
        Math.abs(scaleX - 1) < 0.01 &&
        Math.abs(scaleY - 1) < 0.01
    ) {
        return null;
    }

    previewAnimations.get(preview)?.cancel();
    preview.classList.add('project-row__preview--morphing');

    const animation = preview.animate(
        [
            {
                transformOrigin: 'top left',
                transform: `translate(${deltaX}px, ${deltaY}px) scale(${scaleX}, ${scaleY})`,
            },
            {
                transformOrigin: 'top left',
                transform: 'translate(0px, 0px) scale(1, 1)',
            },
        ],
        {
            duration: STANDALONE_MORPH_DURATION,
            easing: 'cubic-bezier(0.25, 1, 0.5, 1)',
            fill: 'both',
        },
    );

    previewAnimations.set(preview, animation);

    animation.finished
        .catch(() => {})
        .finally(() => {
            if (previewAnimations.get(preview) === animation) {
                previewAnimations.delete(preview);
            }

            preview.classList.remove('project-row__preview--morphing');
        });

    return animation;
};

export const registerProjectsPortfolioState = (target = window) => {
    target.projectsPortfolio = (config = {}) => {
        const projects = Array.isArray(config.projects) ? config.projects : [];
        const tabs = Array.isArray(config.tabs) ? config.tabs : [];
        const isStandalonePage = Boolean(config.isStandalone);
        // Keep lookup cheap for Alpine actions
        const projectsById = projects.reduce((map, project) => {
            if (project?.id) {
                map[project.id] = project;
            }

            return map;
        }, {});

        return {
            tabs,
            projectsById,
            isStandalonePage,
            activeCategory: tabs[0] ?? null,
            expandedProjectId: null,
            isTransitioning: false,
            setCategory(category) {
                if (! this.tabs.includes(category)) {
                    return;
                }

                this.activeCategory = category;

                if (this.expandedProjectId !== null && ! this.isProjectVisible(this.expandedProjectId)) {
                    window.resetProjectSwiper?.(this.expandedProjectId);
                    this.expandedProjectId = null;
                }
            },
            isProjectVisible(projectId) {
                const project = this.projectsById[projectId];

                if (! project) {
                    return false;
                }

                if (this.activeCategory === null) {
                    return true;
                }

                return Array.isArray(project.categories) && project.categories.includes(this.activeCategory);
            },
            visibleProjectCount() {
                return Object.keys(this.projectsById).filter((projectId) => this.isProjectVisible(projectId)).length;
            },
            handleCardClick(event, projectId) {
                if (event.target.closest('[data-gallery-control]')) {
                    return;
                }

                if (this.isTransitioning) {
                    return;
                }

                if (window.shouldIgnoreProjectToggle?.(projectId)) {
                    return;
                }

                if (this.isExpanded(projectId) && event.target.closest('[data-project-story-view]')) {
                    return;
                }

                this.toggleProject(projectId, { source: 'pointer' });
            },
            toggleProject(projectId, options = {}) {
                if (! this.isProjectVisible(projectId) || this.isTransitioning) {
                    return;
                }

                const previousProjectId = this.expandedProjectId;
                const previewRects = this.isStandalonePage
                    ? new Map(
                        [projectId, previousProjectId]
                            .filter(Boolean)
                            .map((id) => [id, capturePreviewRect(this.$root, id)?.rect ?? null]),
                    )
                    : null;

                if (this.expandedProjectId === projectId) {
                    if (this.isStandalonePage) {
                        this.isTransitioning = true;
                        window.deactivateProjectSwiper?.(projectId);
                    } else {
                        window.resetProjectSwiper?.(projectId);
                    }

                    this.expandedProjectId = null;

                    if (this.isStandalonePage && options.source !== 'keyboard') {
                        this.$nextTick(() => {
                            normalizeStoryViewPosition(this.$root, projectId)
                                .finally(() => {
                                    const collapseAnimation = animatePreviewMorph(
                                        this.$root,
                                        projectId,
                                        previewRects?.get(projectId) ?? null,
                                    );

                                    waitForAnimation(collapseAnimation).finally(() => {
                                        window.resetProjectSwiper?.(projectId);
                                        this.isTransitioning = false;
                                    });
                                });
                        });

                        return;
                    }

                    window.resetProjectSwiper?.(projectId);
                    this.isTransitioning = false;

                    return;
                }

                if (this.isStandalonePage && previousProjectId !== null && options.source !== 'keyboard') {
                    this.isTransitioning = true;
                    window.deactivateProjectSwiper?.(previousProjectId);
                    this.expandedProjectId = null;

                    this.$nextTick(() => {
                        normalizeStoryViewPosition(this.$root, previousProjectId)
                            .finally(() => {
                                const previousPreviewAnimation = animatePreviewMorph(
                                    this.$root,
                                    previousProjectId,
                                    previewRects?.get(previousProjectId) ?? null,
                                );

                                waitForAnimation(previousPreviewAnimation).finally(() => {
                                    window.resetProjectSwiper?.(previousProjectId);
                                    scrollProjectCardIntoView(this.$root, projectId)
                                        .finally(() => {
                                            const nextPreviewRect =
                                                capturePreviewRect(this.$root, projectId)?.rect
                                                ?? previewRects?.get(projectId)
                                                ?? null;

                                            this.expandedProjectId = projectId;

                                            this.$nextTick(() => {
                                                const activePreviewAnimation = animatePreviewMorph(
                                                    this.$root,
                                                    projectId,
                                                    nextPreviewRect,
                                                );

                                                waitForAnimation(activePreviewAnimation).finally(() => {
                                                    window.activateProjectSwiper?.(projectId);
                                                    this.isTransitioning = false;
                                                });
                                            });
                                        });
                                });
                            });
                    });

                    return;
                }

                if (previousProjectId !== null) {
                    if (this.isStandalonePage) {
                        window.deactivateProjectSwiper?.(previousProjectId);
                    } else {
                        window.resetProjectSwiper?.(previousProjectId);
                    }
                }

                this.expandedProjectId = projectId;

                this.$nextTick(() => {
                    let activationScheduled = false;

                    if (this.isStandalonePage && options.source !== 'keyboard') {
                        const activePreviewAnimation = animatePreviewMorph(
                            this.$root,
                            projectId,
                            previewRects?.get(projectId) ?? null,
                        );

                        if (previousProjectId !== null) {
                            const previousPreviewAnimation = animatePreviewMorph(
                                this.$root,
                                previousProjectId,
                                previewRects?.get(previousProjectId) ?? null,
                            );

                            if (previousPreviewAnimation) {
                                waitForAnimation(previousPreviewAnimation).finally(() => {
                                    window.resetProjectSwiper?.(previousProjectId);
                                });
                            } else {
                                window.resetProjectSwiper?.(previousProjectId);
                            }
                        }

                        if (activePreviewAnimation) {
                            activationScheduled = true;
                            waitForAnimation(activePreviewAnimation).finally(() => {
                                window.activateProjectSwiper?.(projectId);
                            });
                        }
                    }

                    if (! activationScheduled) {
                        window.activateProjectSwiper?.(projectId);
                    }
                });
            },
            isExpanded(projectId) {
                return this.expandedProjectId === projectId;
            },
        };
    };
};
