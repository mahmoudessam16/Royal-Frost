{{-- $c = ['eyebrow','title' (array of lines),'body','primary','secondary'], $image = file in public/images --}}
@props(['c', 'image' => 'cta-bg.webp'])

<section class="relative overflow-hidden bg-ink">
    <img src="{{ site_image($image) }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full object-cover opacity-20">
    <x-container class="relative py-24 md:py-36">
        <x-eyebrow class="reveal">{{ $c['eyebrow'] }}</x-eyebrow>
        <h2 class="reveal max-w-[896px] pt-6 font-display text-[clamp(2.75rem,6.9vw,5.5rem)] leading-[0.98] tracking-[-0.02em] text-paper" style="--d: 80ms">
            @foreach ((array) $c['title'] as $line)
                <span class="block">{{ $line }}</span>
            @endforeach
        </h2>
        <p class="reveal max-w-[512px] pt-6 text-[17px] leading-[1.625] text-white/60" style="--d: 140ms">{{ $c['body'] }}</p>
        <div class="reveal flex flex-wrap gap-4 pt-10" style="--d: 200ms">
            <a href="{{ route('contact') }}" class="btn btn-lg btn-solid">{{ $c['primary'] }}</a>
            <a href="{{ route('contact') }}" class="btn btn-lg btn-outline-light">{{ $c['secondary'] }}</a>
        </div>
    </x-container>
</section>
