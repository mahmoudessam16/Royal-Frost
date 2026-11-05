@php $c = $t['home']['clients']; @endphp

<section class="border-y border-line bg-stone/60">
    <x-container class="py-12 md:py-16">
        <x-section-head :eyebrow="$c['eyebrow']" class="text-ink">{{ $c['title'] }}</x-section-head>
        <ul class="mt-12 grid grid-cols-2 gap-px bg-line md:grid-cols-4">
            @for ($n = 0; $n < 8; $n++)
                <li class="reveal bg-paper py-10 text-center font-display text-[15px] leading-[22.5px] font-bold tracking-[-0.025em] text-muted/70 transition-colors duration-300 hover:bg-white hover:text-ink" style="--d: {{ ($n % 4) * 60 }}ms">{{ $c['name'] }}</li>
            @endfor
        </ul>
    </x-container>
</section>
