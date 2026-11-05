@php $e = $t['home']['export']; @endphp

<section class="bg-paper">
    <x-container class="py-16 md:py-24 lg:py-32">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-0">
            <div>
                <x-eyebrow class="reveal">{{ $e['eyebrow'] }}</x-eyebrow>
                <h2 class="h2 reveal max-w-[512px] pt-6 text-black" style="--d: 80ms">{{ $e['title'] }}<span class="text-accent">{{ $e['accent'] }}</span></h2>
                <p class="reveal max-w-[512px] pt-6 text-[17px] leading-[1.625] text-black/60" style="--d: 140ms">{{ $e['body'] }}</p>
                <ul class="reveal flex flex-wrap gap-x-8 gap-y-3 pt-10" style="--d: 200ms">
                    @foreach ($e['regions'] as $region)
                        <li class="group flex items-center gap-2 font-display text-[15px] leading-[22.5px] text-black/75 transition-colors hover:text-accent">
                            <span aria-hidden="true" class="size-1.5 rounded-full bg-accent transition-transform group-hover:scale-150"></span>{{ $region }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="reveal relative h-[300px] overflow-hidden sm:h-[404px]">
                <img src="{{ site_image('map.webp') }}" alt="{{ $e['map_alt'] }}" loading="lazy" decoding="async" class="absolute inset-0 size-full object-contain">
            </div>
        </div>
    </x-container>
</section>
