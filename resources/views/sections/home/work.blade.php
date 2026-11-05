@php $w = $t['home']['work']; @endphp

<section class="bg-white">
    <x-container class="py-16 md:py-24 lg:py-32">
        <x-section-head :eyebrow="$w['eyebrow']" class="text-ink">{{ $w['title'] }}</x-section-head>

        <div class="grid gap-x-10 gap-y-14 pt-14 md:grid-cols-2">
            @foreach ($w['items'] as $n => $item)
                <article class="reveal group {{ $n % 2 === 1 ? 'md:pt-16' : '' }}" style="--d: {{ ($n % 2) * 100 }}ms">
                    <div class="relative aspect-[524/327.5] overflow-hidden bg-stone">
                        <img src="{{ site_image('work-'.($n + 1).'.webp') }}" alt="" loading="lazy" decoding="async"
                             class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                    <div class="flex items-start justify-between gap-4 pt-5">
                        <div>
                            <p class="font-mono text-xs leading-[18px] text-accent">{{ $item['index'] }}</p>
                            <h3 class="h3-lg pt-2 text-ink transition-colors group-hover:text-accent">{{ $item['title'] }}</h3>
                            <p class="flex flex-wrap gap-x-5 pt-2 font-mono text-xs leading-[18px]">
                                <span class="text-muted">{{ $item['meta'][0] }}</span>
                                <span class="text-accent">{{ $item['meta'][1] }}</span>
                                <span class="text-muted">{{ $item['meta'][2] }}</span>
                            </p>
                        </div>
                        <span class="relative mt-2 grid size-9 shrink-0 place-items-center border-[1.2px] border-ink/20 transition-[transform,border-color] duration-300 group-hover:rotate-45 group-hover:border-accent">
                            <img src="{{ asset('icons/diag-arrow-dark.svg') }}" alt="" width="16" height="16" class="size-4 group-hover:hidden">
                            <img src="{{ asset('icons/diag-arrow-orange.svg') }}" alt="" width="16" height="16" class="hidden size-4 group-hover:block">
                        </span>
                    </div>
                    @if (! empty($item['desc']))
                        <div class="pt-4">
                            <p class="max-w-[512px] text-[15px] leading-[24.4px] text-muted">{{ $item['desc'] }}</p>
                            @if (! empty($item['result']))
                                <p class="max-w-[512px] pt-3 text-sm leading-[22.75px] text-ink">{{ $item['result'] }}</p>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </div>

        <div class="reveal pt-14">
            <a href="{{ route('services') }}" class="btn btn-sm btn-outline-dark">{{ $w['cta'] }} <x-arrow tone="dark" class="group-hover:brightness-0 group-hover:invert" /></a>
        </div>
    </x-container>
</section>
