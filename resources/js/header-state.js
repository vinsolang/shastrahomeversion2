export const registerSiteHeaderState = (target = window) => {
    target.siteHeader = () => ({
        open: false,
    });
};
