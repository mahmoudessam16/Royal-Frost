@php
    $c = $t['home']['core'];
    $imgs = ['general-supplies', 'contracting', 'export-trade'];
@endphp

<section class="bg-paper">
    <x-container class="py-16 md:py-24 lg:py-32">
        <x-section-head :eyebrow="$c['eyebrow']" class="text-black">
            @foreach ($c['title'] as $line)
                <span class="block">{{ $line }}</span>
            @endforeach
        </x-section-head>

        <div class="pt-12 md:pt-16">
            @foreach ($c['items'] as $n => $item)
                <article class="reveal group grid items-center gap-6 border-t border-black/15 py-10 lg:grid-cols-12 lg:gap-10">
                    <p class="font-display text-[clamp(2.5rem,3.5vw,3.5rem)] leading-none tracking-[-0.02em] text-black/20 transition-colors duration-300 group-hover:text-accent lg:col-span-1">{{ str_pad($n + 1, 2, '0', STR_PAD_LEFT) }}</p>
                    <div class="lg:col-span-4">
                        <h3 class="font-display text-[clamp(1.875rem,2.6vw,2.6rem)] leading-[0.98] tracking-[-0.02em] text-black">{{ $item['title'] }}</h3>
                        <a href="{{ route('services') }}#{{ $item['anchor'] }}" class="btn mt-4 !min-h-0 gap-2 font-normal text-sm leading-[21px] text-accent hover:underline">
                            {{ $item['link'] }} <x-arrow tone="orange" />
                        </a>
                    </div>
                    <div class="lg:col-span-3">
                        <p class="max-w-[242px] text-base leading-[26px] text-black">{{ $item['desc'] }}</p>
                        <ul class="flex max-w-[242px] flex-wrap gap-x-3 gap-y-1.5 pt-4 font-mono text-xs leading-[18px] text-black/80">
                            @foreach ($item['tags'] as $tag)
                                <li>{{ $tag }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="relative h-[210px] overflow-hidden bg-black lg:col-span-4">
                        <img src="{{ site_image($imgs[$n].'.webp') }}" alt="" loading="lazy" decoding="async"
                             class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                </article>
            @endforeach
        </div>
    </x-container>
</section>
