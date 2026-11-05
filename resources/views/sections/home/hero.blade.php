@php $h = $t['home']['hero']; @endphp

<section class="relative flex h-[max(680px,min(100svh,56.25vw))] items-center overflow-hidden bg-ink">
    <img src="{{ site_image('hero.webp') }}" alt="" fetchpriority="high" decoding="async" class="absolute inset-0 size-full object-cover">
    <div aria-hidden="true" class="absolute inset-0 bg-black/20"></div>
    <div aria-hidden="true" class="absolute inset-y-0 start-0 w-[64%] bg-gradient-to-r from-black/55 to-transparent rtl:bg-gradient-to-l"></div>

    <x-container class="relative pt-16">
        <div class="max-w-[835px]">
            <p class="inline-flex h-7 items-center bg-accent px-2 font-mono text-xs leading-[18px] tracking-[0.18em] text-white uppercase">{{ $h['eyebrow'] }}</p>
            <h1 class="reveal pt-8 font-display text-[clamp(3rem,5vw,8rem)] leading-[0.98] tracking-[-0.02em] text-paper">{{ $h['title'] }}<span class="text-white">{{ $h['accent'] }}</span></h1>
            <p class="reveal max-w-[508px] pt-8 text-lg leading-[1.4625] text-white md:text-xl" style="--d: 100ms">{{ $h['body'] }}</p>
            <div class="reveal flex flex-wrap gap-4 pt-10" style="--d: 200ms">
                <a href="{{ route('contact') }}" class="btn btn-lg btn-solid">{{ $h['primary'] }} <x-arrow /></a>
                <a href="{{ route('services') }}" class="btn btn-lg btn-outline-light">{{ $h['secondary'] }}</a>
            </div>
        </div>
    </x-container>
</section>
