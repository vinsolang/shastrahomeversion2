const body = document.querySelector('body'),
    sidebar = body.querySelector('.sidebar'),
    toggle = body.querySelector('.toggle'),
    mobileToggle = body.querySelector('#mobile-sidebar-toggle'),
    backdrop = body.querySelector('#sidebar-backdrop');

if (toggle) {
    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('close');
    });
}

function closeMobileSidebar() {
    sidebar.classList.remove('mobile-open');
    if (backdrop) backdrop.classList.add('hidden');
}

if (mobileToggle) {
    mobileToggle.addEventListener('click', () => {
        sidebar.classList.toggle('mobile-open');
        if (backdrop) backdrop.classList.toggle('hidden', !sidebar.classList.contains('mobile-open'));
    });
}

if (backdrop) {
    backdrop.addEventListener('click', closeMobileSidebar);
}

window.addEventListener('resize', () => {
    if (window.innerWidth >= 640) {
        closeMobileSidebar();
    }
});
