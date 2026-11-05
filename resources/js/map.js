import mapStyle from './map-style.json'; // Snazzy Maps "Interface map" (style 1243)

const el = document.getElementById('office-map');

if (el) {
    const lat = parseFloat(el.dataset.lat);
    const lng = parseFloat(el.dataset.lng);
    const zoom = parseInt(el.dataset.zoom, 10) || 14;

    // Orange teardrop pin in the brand colour
    const pinSvg =
        "<svg xmlns='http://www.w3.org/2000/svg' width='44' height='56' viewBox='0 0 44 56'>" +
        "<path d='M22 1C10.4 1 1 10.1 1 21.4 1 36.5 22 55 22 55s21-18.5 21-33.6C43 10.1 33.6 1 22 1z' fill='#d46b38' stroke='#fff' stroke-width='2'/>" +
        "<circle cx='22' cy='21' r='8' fill='#fff'/></svg>";

    // If the key is rejected (wrong key, billing off, domain not allowed), fall back to a plain embed.
    const fallback = () => {
        el.innerHTML = `<iframe title="${el.dataset.title}" class="size-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=${lat},${lng}&z=${zoom}&output=embed"></iframe>`;
    };
    window.gm_authFailure = fallback;

    window.initOfficeMap = () => {
        const position = { lat, lng };

        const map = new google.maps.Map(el, {
            center: position,
            zoom,
            styles: mapStyle,
            backgroundColor: '#f9f5ed',
            disableDefaultUI: true,
            zoomControl: true,
            fullscreenControl: true,
            clickableIcons: false,
            gestureHandling: 'cooperative', // two-finger / ctrl+scroll, so the page can still scroll
        });

        const marker = new google.maps.Marker({
            position,
            map,
            title: el.dataset.title,
            icon: {
                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(pinSvg),
                scaledSize: new google.maps.Size(44, 56),
                anchor: new google.maps.Point(22, 56),
            },
        });

        const info = new google.maps.InfoWindow({
            content: `<div style="font:14px/1.5 sans-serif;color:#151719;padding:2px 4px"><strong>${el.dataset.title}</strong><br>${el.dataset.address}</div>`,
        });
        marker.addListener('click', () => info.open({ map, anchor: marker }));
        info.open({ map, anchor: marker });
    };

    // Load Google's script only when the map is about to scroll into view.
    const load = () => {
        const s = document.createElement('script');
        s.async = true;
        s.onerror = fallback;
        s.src =
            'https://maps.googleapis.com/maps/api/js?key=' + encodeURIComponent(el.dataset.key) +
            '&callback=initOfficeMap&loading=async&v=weekly&language=' + encodeURIComponent(document.documentElement.lang) +
            '&region=EG';
        document.head.appendChild(s);
    };

    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            if (entries.some((e) => e.isIntersecting)) {
                io.disconnect();
                load();
            }
        }, { rootMargin: '300px' });
        io.observe(el);
    } else {
        load();
    }
}
