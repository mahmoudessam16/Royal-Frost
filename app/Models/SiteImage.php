<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteImage extends Model
{
    protected $fillable = ['key', 'path'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.images'));
        static::deleted(fn () => Cache::forget('site.images'));
    }

    /**
     * Every replaceable image: key => [label, section, hint].
     * The key is the default file name in public/images without its extension.
     */
    public static function catalog(): array
    {
        return [
            'Home' => [
                'hero' => ['Hero background', 'Wide photo, at least 2000 px wide'],
                'general-supplies' => ['General Supplies card', 'Landscape, about 3:2'],
                'contracting' => ['General Contracting card', 'Landscape, about 3:2'],
                'export-trade' => ['Trading and Export card', 'Landscape, about 3:2'],
                'building-materials' => ['Supply network: Building Materials', 'Square or 4:3'],
                'work-1' => ['Selected work 1', 'Landscape, about 16:10'],
                'work-2' => ['Selected work 2', 'Landscape, about 16:10'],
                'work-3' => ['Selected work 3', 'Landscape, about 16:10'],
                'work-4' => ['Selected work 4', 'Landscape, about 16:10'],
                'map' => ['Export map', 'Transparent or light background'],
                'cta-bg' => ['Closing call-to-action background', 'Wide photo (shown faded)'],
            ],
            'About' => [
                'about-hero' => ['About hero background', 'Wide photo, at least 2000 px wide'],
                'cta-about' => ['About closing call-to-action background', 'Wide photo (shown faded)'],
            ],
            'Services: General Supplies' => [
                'supply-industrial' => ['Industrial Supplies', 'Landscape, about 3:2'],
                'supply-electrical' => ['Electrical Supplies', 'Landscape, about 3:2'],
                'supply-plumbing' => ['Plumbing Supplies', 'Landscape, about 3:2'],
                'supply-office' => ['Office Essentials', 'Landscape, about 3:2'],
                'supply-safety' => ['Business & Facility Supplies', 'Landscape, about 3:2'],
            ],
            'Services: General Contracting' => [
                'contracting-1' => ['Construction Works', 'About 4:3'],
                'contracting-2' => ['Interior & Exterior Finishes', 'About 4:3'],
                'contracting-3' => ['Electrical Works', 'About 4:3'],
                'contracting-4' => ['Civil Works', 'About 4:3'],
                'contracting-5' => ['Maintenance & Renovation', 'About 4:3'],
            ],
            'Services: Trading & Export' => [
                'services-hero' => ['Services hero background', 'Wide photo, at least 2000 px wide'],
                'agri-crops' => ['Agricultural Crops', 'Landscape, about 16:9'],
                'agri-produce' => ['Fresh Produce', 'Landscape'],
                'agri-food' => ['Food Products', 'Landscape'],
                'agri-olive' => ['Olive Oil', 'Landscape, about 16:9'],
                'agri-quality' => ['Quality Control & Packaging', 'Landscape, about 16:9'],
                'agri-shipping' => ['Shipping & Export Coordination', 'Landscape'],
                'agri-map' => ['Export map block', 'About 4:3'],
                'cta-services' => ['Services closing call-to-action background', 'Wide photo (shown faded)'],
            ],
            'Contact' => [
                'contact-map' => ['Contact map', 'Wide, about 7:3'],
            ],
        ];
    }

    /** key => uploaded path (relative to public/uploads) */
    public static function overrides(): array
    {
        try {
            return Cache::rememberForever('site.images', fn () => static::query()->pluck('path', 'key')->all());
        } catch (\Throwable) {
            return []; // table not migrated yet
        }
    }

    /** Public URL for a default file name such as "hero.webp". */
    public static function url(string $file): string
    {
        $key = pathinfo($file, PATHINFO_FILENAME);
        $path = static::overrides()[$key] ?? null;

        if ($path && is_file(public_path('uploads/'.$path))) {
            return asset('uploads/'.$path).'?v='.filemtime(public_path('uploads/'.$path));
        }

        return asset('images/'.$file);
    }

    public static function defaultUrl(string $key): string
    {
        return asset('images/'.$key.'.webp');
    }
}
