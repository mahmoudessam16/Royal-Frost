<?php

namespace App\Http\Middleware;

use App\Support\Content;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        App::setLocale($locale);
        // Lets route('home') etc. resolve the current language automatically.
        URL::defaults(['locale' => $locale]);
        $request->route()->forgetParameter('locale');

        View::share('locale', $locale);
        View::share('dir', $locale === 'ar' ? 'rtl' : 'ltr');
        View::share('t', Content::forLocale($locale));

        return $next($request);
    }
}
