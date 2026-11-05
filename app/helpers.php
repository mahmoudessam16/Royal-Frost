<?php

use App\Models\SiteImage;

if (! function_exists('site_image')) {
    /**
     * URL of a site image. Pass the default file name (e.g. "hero.webp");
     * returns the uploaded replacement from the admin panel when there is one.
     */
    function site_image(string $file): string
    {
        return SiteImage::url($file);
    }
}
