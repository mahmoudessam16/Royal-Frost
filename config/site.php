<?php

return [
    /*
    | Office location shown on the Contact page map (Nasr City, Cairo).
    | Override in .env with SITE_MAP_LAT / SITE_MAP_LNG to move the pin.
    */
    'map' => [
        'lat' => (float) env('SITE_MAP_LAT', 30.0561),
        'lng' => (float) env('SITE_MAP_LNG', 31.3301),
        'zoom' => (int) env('SITE_MAP_ZOOM', 14),
        // Google Maps JavaScript API key. Without it the page shows a plain Google Maps embed instead.
        'key' => env('GOOGLE_MAPS_API_KEY'),
    ],
];
