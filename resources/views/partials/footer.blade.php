@php $f = $t['footer']; @endphp

<footer class="overflow-hidden border-t border-black/20 bg-paper">
    <x-container class="pt-16 md:pt-24">
        <div class="flex flex-col gap-12 lg:flex-row lg:justify-between">
            <div class="max-w-[224px]">
                <p class="font-display text-[22px] leading-[33px] font-bold tracking-[-0.025em] text-black">{{ $t['meta']['name'] }}</p>
                <p class="pt-5 text-[15px] leading-[24.4px] text-black/55">{{ $f['tagline'] }}</p>
            </div>

            <div class="grid grid-cols-2 gap-10 sm:grid-cols-3 lg:w-[704px]">
                <div>
                    <p class="font-mono text-[11px] leading-[16.5px] tracking-[0.18em] text-black/40 uppercase">{{ $f['company'] }}</p>
                    <ul class="space-y-3 pt-5 font-display text-[15px] leading-[22.5px] text-black/75">
                        <li><a class="transition-colors hover:text-accent" href="{{ route('home') }}">{{ $t['nav']['home'] }}</a></li>
                        <li><a class="transition-colors hover:text-accent" href="{{ route('about') }}">{{ $t['nav']['about'] }}</a></li>
                        <li><a class="transition-colors hover:text-accent" href="{{ route('services') }}">{{ $t['nav']['services'] }}</a></li>
                        <li><a class="transition-colors hover:text-accent" href="{{ route('contact') }}">{{ $f['contact_us'] }}</a></li>
                    </ul>
                </div>
                <div>
                    <p class="font-mono text-[11px] leading-[16.5px] tracking-[0.18em] text-black/40 uppercase">{{ $t['nav']['services'] }}</p>
                    <ul class="space-y-3 pt-5 font-display text-[15px] leading-[22.5px] text-black/75">
                        @foreach ($f['service_links'] as $anchor => $label)
                            <li><a class="transition-colors hover:text-accent" href="{{ route('services') }}#{{ $anchor }}">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <p class="font-mono text-[11px] leading-[16.5px] tracking-[0.18em] text-black/40 uppercase">{{ $f['contact'] }}</p>
                    <ul class="space-y-3 pt-5 text-[15px] leading-[22.5px]">
                        <li class="text-black/75" dir="ltr" style="text-align: start"><a class="transition-colors hover:text-accent" href="tel:{{ preg_replace('/\s+/', '', $f['phone']) }}">{{ $f['phone'] }}</a></li>
                        <li class="text-black/75"><a class="transition-colors hover:text-accent" href="mailto:{{ $f['email'] }}">{{ $f['email'] }}</a></li>
                        <li class="text-black/55">{{ $f['address'] }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div aria-hidden="true" class="pt-12 select-none md:pt-20">
            <p class="h-[0.9em] overflow-hidden font-display text-[clamp(64px,17.7vw,226px)] leading-[1.18] tracking-[-0.024em] whitespace-nowrap text-black/5 md:h-[266.5px]">{{ $t['meta']['name'] }}</p>
        </div>

        <div class="flex flex-col gap-3 border-t border-black/10 py-6 text-[13px] leading-[19.5px] text-black/45 sm:flex-row sm:items-center sm:justify-between">
            <p>{{ $f['rights'] }}</p>
            <div class="flex items-center gap-6">
                <a href="#" class="transition-colors hover:text-accent">{{ $f['privacy'] }}</a>
                <a href="#" class="transition-colors hover:text-accent">{{ $f['terms'] }}</a>
                <span class="font-mono">
                    <a href="{{ route(Route::currentRouteName(), ['locale' => 'en']) }}" class="transition-colors hover:text-accent {{ $locale === 'en' ? 'text-accent' : '' }}">EN</a>
                    /
                    <a href="{{ route(Route::currentRouteName(), ['locale' => 'ar']) }}" class="transition-colors hover:text-accent {{ $locale === 'ar' ? 'text-accent' : '' }}">AR</a>
                </span>
            </div>
        </div>
    </x-container>
</footer>
