@php
    $p = $t['home']['products'];
    $imgs = ['building-materials', 'supply-industrial', 'supply-electrical', 'supply-plumbing', 'supply-office', 'supply-safety'];
@endphp

<section class="bg-white">
    <x-container class="py-16 md:py-24 lg:py-32">
        <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
            <div class="pt-6">
                <h2 class="h2 reveal text-ink">{{ $p['title'] }}</h2>
                <p class="reveal max-w-[710px] pt-5 text-[17px] leading-[1.625] text-muted" style="--d: 80ms">{{ $p['body'] }}</p>
            </div>
            <div class="reveal shrink-0">
                <a href="{{ route('services') }}" class="btn btn-sm btn-outline-dark">{{ $p['view_all'] }} <x-arrow tone="dark" class="group-hover:brightness-0 group-hover:invert" /></a>
            </div>
        </div>

        <div data-tabs>
            <div role="tablist" class="mt-12 flex gap-6 overflow-x-auto border-b border-line pb-5 whitespace-nowrap">
                @foreach ($p['tabs'] as $n => $tab)
                    <button type="button" role="tab" aria-selected="{{ $n === 0 ? 'true' : 'false' }}"
                            class="font-display text-[15px] leading-[22.5px] transition-colors hover:text-ink {{ $n === 0 ? 'text-accent' : 'text-muted' }}">{{ $tab['label'] }}</button>
                @endforeach
            </div>

            @foreach ($p['tabs'] as $n => $tab)
                <div role="tabpanel" @if ($n > 0) hidden @endif class="grid items-center gap-10 pt-10 md:grid-cols-[512px_1fr] md:gap-16">
                    <div class="group relative aspect-[4/3] w-full overflow-hidden bg-stone md:aspect-auto md:h-[384px] md:max-w-[512px]">
                        <img src="{{ site_image($imgs[$n].'.webp') }}" alt="{{ $tab['label'] }}" loading="lazy" decoding="async"
                             class="absolute inset-0 size-full object-cover transition-transform duration-700 hover:scale-105">
                    </div>
                    <div class="flex max-w-[339px] flex-col items-start gap-[21px] py-[3px]">
                        <p class="font-mono text-xs leading-[18px] tracking-[0.1em] text-accent uppercase">{{ $tab['category'] }}</p>
                        <h3 class="font-display text-[clamp(2rem,3.5vw,2.8rem)] leading-[0.98] tracking-[-0.02em] text-ink">{{ $tab['label'] }}</h3>
                        <p class="text-base leading-[26px] text-muted">{{ $tab['desc'] }}</p>
                        <a href="{{ route('contact') }}" class="btn btn-sm btn-solid">{{ $p['quote'] }} <x-arrow /></a>
                    </div>
                </div>
            @endforeach
        </div>
    </x-container>
</section>
