<?php

namespace App\Support;

use App\Models\SiteContent;
use Illuminate\Support\Facades\Cache;

/**
 * Site copy = defaults from lang/{locale}/site.php, overlaid with whatever
 * has been edited in the admin panel (site_contents table).
 */
class Content
{
    public const LOCALES = ['en', 'ar'];

    public static function defaults(string $locale): array
    {
        return trans('site', [], $locale);
    }

    public static function forLocale(string $locale): array
    {
        return Cache::rememberForever("site.content.$locale", function () use ($locale) {
            $content = static::defaults($locale);

            try {
                foreach (SiteContent::where('locale', $locale)->get() as $row) {
                    if (isset($content[$row->group]) && is_array($row->data)) {
                        $content[$row->group] = static::merge($content[$row->group], $row->data);
                    }
                }
            } catch (\Throwable) {
                // table not migrated yet: use the defaults
            }

            return $content;
        });
    }

    public static function flush(): void
    {
        foreach (static::LOCALES as $locale) {
            Cache::forget("site.content.$locale");
        }
    }

    /** Edited values win. Associative arrays merge key by key; lists are replaced as a whole. */
    private static function merge(array $base, array $override): array
    {
        foreach ($override as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_array($value) && isset($base[$key]) && is_array($base[$key]) && ! array_is_list($base[$key])) {
                $base[$key] = static::merge($base[$key], $value);
            } else {
                $base[$key] = $value;
            }
        }

        return $base;
    }
}
