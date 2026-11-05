@extends('layouts.app', ['title' => $t['nav']['services']])

@php
    $s = $t['services'];
    $supplyImages = ['building-materials', 'supply-industrial', 'supply-electrical', 'supply-plumbing', 'supply-office', 'supply-safety'];
    $contractImages = ['contracting-1', 'contracting-2', 'contracting-3', 'contracting-4', 'contracting-5'];
    $agriImages = ['agri-crops', 'agri-produce', 'agri-food', 'agri-olive', 'agri-quality', 'agri-shipping'];
@endphp

@section('content')
    <x-page-hero image="services-hero.webp" :eyebrow="$s['hero']['eyebrow']" :opacity="0.4" fade="top" size="text-[clamp(2.75rem,7.5vw,6rem)]">
        <span class="block">{{ $s['hero']['title'] }}</span>
        <span class="block text-accent">{{ $s['hero']['accent'] }}</span>
        <x-slot:body>{{ $s['hero']['body'] }}</x-slot:body>
    </x-page-hero>

    {{-- 01 General supplies --}}
    <section id="supplies" class="scroll-mt-24 bg-paper">
        <x-container class="py-16 md:py-24 lg:py-32">
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                <h2 class="reveal flex items-baseline gap-5 font-display text-[clamp(2.25rem,4.4vw,4rem)] leading-[0.98] tracking-[-0.02em] text-ink">
                    <span class="text-[1.25em] text-accent">01</span>{{ $s['supplies']['title'] }}
                </h2>
                <p class="reveal max-w-[426px] text-lg leading-[1.625] text-muted" style="--d: 80ms">{{ $s['supplies']['desc'] }}</p>
            </div>

            <div class="grid gap-x-10 gap-y-[77px] pt-[63px] sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($s['supplies']['items'] as $n => [$title, $text])
                    <article class="reveal group" style="--d: {{ ($n % 3) * 80 }}ms">
                        <div class="relative h-[210px] overflow-hidden bg-stone">
                            <img src="{{ site_image($supplyImages[$n].'.webp') }}" alt="" loading="lazy" decoding="async"
                                 class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <h3 class="pt-5 font-display text-[22px] leading-[33px] font-semibold text-ink transition-colors group-hover:text-accent">{{ $title }}</h3>
                        <p class="max-w-[336px] pt-2 text-[15px] leading-[24.4px] text-muted">{{ $text }}</p>
                    </article>
                @endforeach
            </div>

            <div class="reveal pt-12">
                <a href="{{ route('contact') }}" class="btn btn-lg btn-solid">{{ $s['supplies']['cta'] }} <x-arrow /></a>
            </div>
        </x-container>
    </section>

    {{-- 02 General contracting --}}
    <section id="contracting" class="scroll-mt-24 bg-[#f0efea]">
        <x-container class="py-16 md:py-24 lg:py-32">
            <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                <h2 class="reveal flex items-baseline gap-5 font-display text-[clamp(2.25rem,4.4vw,4rem)] leading-[0.98] tracking-[-0.02em] text-ink">
                    <span class="text-[1.25em] text-accent">02</span>{{ $s['contracting']['title'] }}
                </h2>
                <p class="reveal max-w-[383px] text-lg leading-[1.625] text-muted" style="--d: 80ms">{{ $s['contracting']['desc'] }}</p>
            </div>

            <div class="pt-4">
                @foreach ($s['contracting']['items'] as $n => [$title, $text])
                    <article class="reveal group grid items-center pt-12 lg:pt-[63px] {{ $n % 2 === 1 ? 'lg:grid-cols-[1fr_596px]' : 'lg:grid-cols-[596px_1fr]' }}">
                        <div class="relative aspect-[596/445] overflow-hidden bg-stone {{ $n % 2 === 1 ? 'lg:order-2' : '' }}">
                            <img src="{{ site_image($contractImages[$n].'.webp') }}" alt="" loading="lazy" decoding="async"
                                 class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                        <div class="px-0 py-8 lg:px-[67px] lg:py-0 {{ $n % 2 === 1 ? 'lg:order-1' : '' }}">
                            <h3 class="max-w-[366px] font-display text-[clamp(1.75rem,2.7vw,2.4rem)] leading-[1.12] tracking-[-0.01em] text-ink transition-colors group-hover:text-accent">{{ $title }}</h3>
                            <p class="max-w-[366px] pt-[11px] text-[15px] leading-[24.4px] text-muted">{{ $text }}</p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="reveal flex justify-center pt-12">
                <a href="{{ route('contact') }}" class="btn btn-lg btn-solid">{{ $s['contracting']['cta'] }} <x-arrow /></a>
            </div>
        </x-container>
    </section>

    {{-- 03 Trading & export --}}
    <section id="export" class="scroll-mt-24 bg-white">
        <x-container class="py-16 md:py-24 lg:py-32">
            <div class="grid gap-8 lg:grid-cols-[1fr_426px] lg:gap-10">
                <div>
                    <p class="reveal font-mono text-xs leading-[18px] tracking-[0.18em] text-ink uppercase">{{ $s['export']['label'] }}</p>
                    <h2 class="reveal flex gap-5 pt-[26px] font-display text-[clamp(2.25rem,4.4vw,4rem)] leading-[0.98] tracking-[-0.02em] text-ink" style="--d: 80ms">
                        <span class="text-[1.25em] leading-[0.98] text-accent">03</span><span class="max-w-[480px]">{{ $s['export']['title'] }}</span>
                    </h2>
                </div>
                <p class="reveal text-lg leading-[1.625] text-muted lg:pt-11" style="--d: 120ms">{{ $s['export']['desc'] }}</p>
            </div>

            <div class="space-y-16 pt-12">
                @foreach (array_chunk($s['export']['items'], 2) as $row => $pair)
                    {{-- Rows alternate wide/narrow: 640+408, 408+640, 640+408 --}}
                    <div class="grid gap-x-10 gap-y-16 {{ $row % 2 === 0 ? 'lg:grid-cols-[640fr_408fr]' : 'lg:grid-cols-[408fr_640fr]' }}">
                        @foreach ($pair as $k => [$title, $text])
                            @php $n = $row * 2 + $k; @endphp
                            <article class="reveal group" style="--d: {{ $k * 100 }}ms">
                                <div class="relative h-[260px] overflow-hidden bg-stone sm:h-[360px]">
                                    <img src="{{ site_image($agriImages[$n].'.webp') }}" alt="" loading="lazy" decoding="async"
                                         class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                                <h3 class="pt-5 font-display text-[22px] leading-[33px] font-semibold text-ink transition-colors group-hover:text-accent">{{ $title }}</h3>
                                <p class="pt-2 text-[15px] leading-[24.4px] text-muted">{{ $text }}</p>
                            </article>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="grid items-start gap-12 pt-16 lg:grid-cols-[1fr_460px] lg:gap-20">
                <div class="grid gap-x-[51px] gap-y-12 sm:grid-cols-2 lg:pt-4">
                    @foreach ($s['export']['points'] as $n => [$title, $text])
                        <div class="reveal border-t-[1.2px] border-black py-8" style="--d: {{ $n * 80 }}ms">
                            <h3 class="font-display text-2xl leading-9 font-semibold text-black">{{ $title }}</h3>
                            <p class="pt-3 text-base leading-[26px] text-black">{{ $text }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="reveal relative h-[300px] overflow-hidden bg-black sm:h-[355px]">
                    <img src="{{ site_image('agri-map.webp') }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full object-cover">
                </div>
            </div>

            <div class="reveal pt-12">
                <a href="{{ route('contact') }}" class="btn btn-lg btn-solid">{{ $s['export']['cta'] }} <x-arrow /></a>
            </div>
        </x-container>
    </section>

    <x-closing-cta :c="$s['cta']" image="cta-services.webp" />
@endsection
