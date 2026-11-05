{{-- Dark hero used on About and Services. $image is a file in public/images; $fade="top"|"bottom" picks the gradient. --}}
@props(['image', 'eyebrow', 'opacity' => 0.45, 'fade' => 'bottom', 'size' => 'text-[clamp(2.75rem,6.9vw,5.5rem)]'])

<section class="relative flex h-[max(620px,39.4vw)] items-end overflow-hidden bg-ink">
    <img src="{{ site_image($image) }}" alt="" fetchpriority="high" decoding="async"
         class="absolute inset-0 size-full object-cover" style="opacity: {{ $opacity }}">
    @if ($fade === 'top')
        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-ink from-[12%] to-transparent to-[40%]"></div>
    @else
        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-b from-transparent from-[75%] to-black/20"></div>
    @endif

    <x-container class="relative pt-40 pb-12 md:pb-16">
        <p class="inline-flex h-7 items-center bg-accent px-2 font-mono text-xs leading-[18px] tracking-[0.18em] text-white uppercase">{{ $eyebrow }}</p>
        <h1 class="reveal max-w-[896px] pt-6 font-display {{ $size }} leading-[0.98] tracking-[-0.02em] text-paper">{{ $slot }}</h1>
        <p class="reveal max-w-[637px] pt-6 text-lg leading-[1.4] text-white/70 md:text-xl" style="--d: 100ms">{{ $body }}</p>
    </x-container>
</section>
