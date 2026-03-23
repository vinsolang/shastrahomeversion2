export const registerProjectsPortfolioState = (target = window) => {
    target.projectsPortfolio = (config = {}) => {
        const projects = Array.isArray(config.projects) ? config.projects : [];
        const tabs = Array.isArray(config.tabs) ? config.tabs : [];
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
            activeCategory: tabs[0] ?? null,
            expandedProjectId: null,
            setCategory(category) {
                if (! this.tabs.includes(category)) {
                    return;
                }

                this.activeCategory = category;

                // Close the open card if the new filter hides it
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
            toggleProject(projectId) {
                if (! this.isProjectVisible(projectId)) {
                    return;
                }

                const previousProjectId = this.expandedProjectId;

                if (this.expandedProjectId === projectId) {
                    this.expandedProjectId = null;
                    window.resetProjectSwiper?.(projectId);

                    return;
                }

                if (previousProjectId !== null) {
                    // Reset the old swiper before opening the new one
                    window.resetProjectSwiper?.(previousProjectId);
                }

                this.expandedProjectId = projectId;
                window.activateProjectSwiper?.(projectId);
            },
            isExpanded(projectId) {
                return this.expandedProjectId === projectId;
            },
        };
    };
};
