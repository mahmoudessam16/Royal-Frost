@php $w = $t['home']['why']; @endphp

<section class="bg-white">
    <x-container class="py-16 md:py-24 lg:py-32">
        <x-eyebrow class="reveal">{{ $w['eyebrow'] }}</x-eyebrow>
        <div class="flex flex-col justify-between gap-6 pt-6 sm:flex-row sm:items-center">
            <h2 class="h2 reveal text-ink" style="--d: 80ms">{{ $w['title'] }}</h2>
            <a href="{{ route('about') }}" class="btn btn-lg btn-solid reveal self-start">{{ $w['cta'] }} <x-arrow /></a>
        </div>

        <ol class="pt-12 md:pt-16">
            @foreach ($w['items'] as $n => $label)
                <li class="reveal group flex h-[88px] items-center gap-6 border-t border-ink/15 md:h-[115px] md:gap-12" style="--d: {{ $n * 80 }}ms">
                    <span class="w-10 shrink-0 font-display text-[clamp(1.5rem,2.4vw,2.4rem)] leading-none tracking-[-0.02em] transition-colors duration-300 group-hover:text-accent {{ $n === 0 ? 'text-accent' : 'text-ink/20' }}">{{ str_pad($n + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="font-display text-[clamp(1.75rem,3.1vw,3.125rem)] leading-none font-light tracking-[-0.02em] text-ink transition-transform duration-300 group-hover:translate-x-2 rtl:group-hover:-translate-x-2">{{ $label }}</span>
                </li>
            @endforeach
        </ol>
    </x-container>
</section>
