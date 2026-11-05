@php $i = $t['home']['intro']; @endphp

<section class="bg-white">
    <x-container class="py-16 md:py-24 lg:py-32">
        <div class="grid items-center gap-10 lg:grid-cols-[1fr_477px] lg:gap-0">
            <div>
                <x-eyebrow class="reveal">{{ $i['eyebrow'] }}</x-eyebrow>
                <h2 class="reveal pt-6 font-display text-[clamp(2.75rem,5.5vw,4.5rem)] leading-[0.98] tracking-[-0.02em] text-ink" style="--d: 80ms">
                    @foreach ($i['title'] as $line)
                        <span class="block">{{ $line }}</span>
                    @endforeach
                    <span class="block text-accent">{{ $i['accent'] }}</span>
                </h2>
            </div>
            <div class="lg:pt-4">
                <p class="reveal text-[19px] leading-[1.625] text-[#171717]">{{ $i['lead'] }}</p>
                <p class="reveal max-w-[448px] pt-6 text-base leading-[26px] text-muted" style="--d: 100ms">{{ $i['body'] }}</p>
            </div>
        </div>

        <dl class="mt-12 grid grid-cols-2 border-t border-line pt-4 md:mt-20 lg:grid-cols-4">
            @foreach ($i['stats'] as $n => $label)
                <div class="reveal py-4 pe-8 lg:py-0 {{ $n > 0 ? 'lg:border-s lg:border-line lg:ps-8' : '' }} {{ $n % 2 === 1 ? 'border-s border-line ps-8' : '' }}" style="--d: {{ $n * 80 }}ms">
                    <dd class="font-display text-[clamp(2.5rem,4vw,3.8rem)] leading-[0.98] tracking-[-0.02em] text-accent" dir="ltr">+<span class="text-ink">00</span></dd>
                    <dt class="pt-2 pb-1 font-mono text-xs leading-[18px] tracking-[0.1em] text-muted uppercase">{{ $label }}</dt>
                </div>
            @endforeach
        </dl>
    </x-container>
</section>
