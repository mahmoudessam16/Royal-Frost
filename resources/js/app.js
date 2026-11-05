const root = document.documentElement;
root.classList.add('js');

// Scroll reveal
const items = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-in');
                    io.unobserve(e.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.05 },
    );
    items.forEach((el) => io.observe(el));
} else {
    items.forEach((el) => el.classList.add('is-in'));
}

// Header: solid bar after scrolling, mobile menu
const header = document.querySelector('[data-header]');
if (header) {
    const bar = header.querySelector('[data-header-bar]');
    const light = header.dataset.header === 'light';
    const menu = header.querySelector('[data-menu]');
    const toggle = header.querySelector('[data-menu-toggle]');

    const paint = () => {
        const solid = window.scrollY > 40 || (menu && !menu.hidden);
        bar.classList.toggle('is-solid', solid);
        bar.classList.toggle('is-light', light && !solid);
    };
    paint();
    window.addEventListener('scroll', paint, { passive: true });

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.hidden = !menu.hidden;
            toggle.setAttribute('aria-expanded', String(!menu.hidden));
            toggle.classList.toggle('is-open', !menu.hidden);
            paint();
        });
    }
}

// Product tabs
document.querySelectorAll('[data-tabs]').forEach((group) => {
    const tabs = group.querySelectorAll('[role="tab"]');
    const panels = group.querySelectorAll('[role="tabpanel"]');
    tabs.forEach((tab, i) => {
        tab.addEventListener('click', () => {
            tabs.forEach((t, j) => {
                const on = i === j;
                t.setAttribute('aria-selected', String(on));
                t.classList.toggle('text-accent', on);
                t.classList.toggle('text-muted', !on);
            });
            panels.forEach((p, j) => (p.hidden = i !== j));
        });
    });
});
