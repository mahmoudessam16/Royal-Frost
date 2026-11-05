@php
    $current = Route::currentRouteName();
    $other = $locale === 'en' ? 'ar' : 'en';
    $links = [
        ['home', $t['nav']['home']],
        ['about', $t['nav']['about']],
        ['services', $t['nav']['services']],
    ];
@endphp

<header data-header="{{ $light ? 'light' : 'dark' }}" class="pointer-events-none fixed inset-x-0 top-3 z-50 px-4 md:top-[34px]">
    <div data-header-bar class="hbar pointer-events-auto mx-auto flex w-full max-w-[1089px] items-center justify-between px-[14px] py-[11px]">
        <a href="{{ route('home') }}" class="font-display text-[28.6px] leading-[28.6px] font-bold tracking-[-0.025em]">
            {{ $t['meta']['name'] }}
        </a>

        <nav aria-label="Main" class="hidden items-center gap-[17px] lg:flex">
            @foreach ($links as [$route, $label])
                <a href="{{ route($route) }}" class="hbar-link" @if ($current === $route) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-3">
            <div class="hidden items-center gap-1 font-mono text-xs leading-[18px] sm:flex" aria-label="Language">
                <a href="{{ route($current, ['locale' => 'en']) }}" hreflang="en" lang="en"
                   class="transition-colors hover:text-accent {{ $locale === 'en' ? 'text-accent' : 'opacity-70' }}">EN</a>
                <span class="opacity-40">/</span>
                <a href="{{ route($current, ['locale' => 'ar']) }}" hreflang="ar" lang="ar"
                   class="transition-colors hover:text-accent {{ $locale === 'ar' ? 'text-accent' : 'opacity-70' }}">AR</a>
            </div>
            <a href="{{ route($current, ['locale' => $other]) }}" hreflang="{{ $other }}"
               class="font-mono text-xs underline-offset-4 hover:text-accent hover:underline sm:hidden">{{ strtoupper($other) }}</a>
            <a href="{{ route('contact') }}" class="btn btn-sm btn-solid hidden !text-white md:inline-flex">{{ $t['nav']['cta'] }}</a>
            <button type="button" data-menu-toggle aria-label="Menu" aria-expanded="false"
                    class="flex size-10 flex-col items-center justify-center gap-1.5 lg:hidden">
                <span class="menu-bar"></span>
                <span class="menu-bar"></span>
            </button>
        </div>
    </div>

    <div data-menu hidden class="pointer-events-auto mx-auto mt-px flex max-w-[1089px] flex-col bg-ink/95 p-4 text-white backdrop-blur-md lg:hidden">
        @foreach ($links as [$route, $label])
            <a href="{{ route($route) }}" class="py-3 font-display text-lg transition-colors hover:text-accent {{ $current === $route ? 'text-accent' : '' }}">{{ $label }}</a>
        @endforeach
        <a href="{{ route('contact') }}" class="btn btn-sm btn-solid mt-2 !text-white">{{ $t['nav']['cta'] }}</a>
    </div>
</header>
