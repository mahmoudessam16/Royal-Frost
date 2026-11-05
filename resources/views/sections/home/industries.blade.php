@php $s = $t['home']['industries']; @endphp

<section class="bg-paper">
    <x-container class="py-16 md:py-24 lg:py-32">
        <x-section-head :eyebrow="$s['eyebrow']" class="text-ink">{{ $s['title'] }}</x-section-head>
        <ul class="flex max-w-[1088px] flex-wrap gap-3 pt-12">
            @foreach ($s['chips'] as $n => $chip)
                <li class="reveal border-[1.2px] border-line px-5 py-3 font-display text-[15px] leading-[22.5px] text-ink transition-colors duration-200 hover:border-accent hover:bg-accent hover:text-white" style="--d: {{ $n * 40 }}ms">{{ $chip }}</li>
            @endforeach
        </ul>
    </x-container>
</section>
