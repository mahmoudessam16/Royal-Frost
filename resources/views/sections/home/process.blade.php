@php $p = $t['home']['process']; @endphp

<section class="border-t border-black/20 bg-paper">
    <x-container class="py-16 md:py-24 lg:py-32">
        <x-section-head :eyebrow="$p['eyebrow']" class="text-black">
            <span class="block">{{ $p['title'] }}</span>
            <span class="block">{{ $p['title2'] }}<span class="text-accent">{{ $p['accent'] }}</span></span>
        </x-section-head>

        <ol class="grid gap-y-10 pt-[55px] sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($p['steps'] as $n => $step)
                <li class="reveal group relative border-t-[1.2px] border-black/20 ps-3 pe-9 pt-8" style="--d: {{ $n * 80 }}ms">
                    <span aria-hidden="true" class="absolute start-0 -top-px h-0.5 w-10 bg-accent transition-[width] duration-500 group-hover:w-full"></span>
                    <p class="font-mono text-[13px] leading-[19.5px] text-accent">{{ str_pad($n + 1, 2, '0', STR_PAD_LEFT) }}</p>
                    <h3 class="pt-3 font-display text-[22px] leading-[33px] font-semibold text-black">{{ $step['title'] }}</h3>
                    <p class="pt-3 text-[15px] leading-[24.4px] text-black/55">{{ $step['desc'] }}</p>
                </li>
            @endforeach
        </ol>
    </x-container>
</section>
