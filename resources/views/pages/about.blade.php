@extends('layouts.app', ['title' => $t['nav']['about']])

@php $a = $t['about']; @endphp

@section('content')
    {{-- Hero --}}
    <x-page-hero image="about-hero.webp" :eyebrow="$a['hero']['eyebrow']" :opacity="0.45" fade="bottom">
        {{ $a['hero']['title'] }}<span class="text-accent">{{ $a['hero']['accent'] }}</span>
        <x-slot:body>{{ $a['hero']['body'] }}</x-slot:body>
    </x-page-hero>

    {{-- Company overview + stats --}}
    <section class="bg-white">
        <x-container class="py-16 md:py-24 lg:py-32">
            <div class="grid gap-10 lg:grid-cols-2 lg:gap-20">
                <div>
                    <x-eyebrow class="reveal">{{ $a['overview']['eyebrow'] }}</x-eyebrow>
                    <h2 class="reveal max-w-[505px] pt-6 font-display text-[clamp(2.25rem,3.6vw,3.5rem)] leading-[0.98] tracking-[-0.02em] text-ink" style="--d: 80ms">{{ $a['overview']['title'] }}</h2>
                </div>
                <div class="lg:pt-4">
                    <p class="reveal max-w-[505px] text-[17px] leading-[1.625] font-medium text-black">{{ $a['overview']['lead'] }}</p>
                    <p class="reveal max-w-[505px] pt-6 text-[17px] leading-[1.625] text-muted" style="--d: 100ms">{{ $a['overview']['body'] }}</p>
                </div>
            </div>

            <dl class="mt-12 grid grid-cols-2 border-t border-line pt-4 md:mt-20 lg:grid-cols-4">
                @foreach ($a['overview']['stats'] as $n => [$value, $label])
                    <div class="reveal py-4 pe-8 lg:py-0 {{ $n > 0 ? 'lg:border-s lg:border-line lg:ps-8' : '' }} {{ $n % 2 === 1 ? 'border-s border-line ps-8' : '' }}" style="--d: {{ $n * 80 }}ms">
                        <dd class="font-display text-[clamp(2.5rem,4vw,3.8rem)] leading-[0.98] tracking-[-0.02em] text-accent" dir="ltr">+<span class="text-ink">{{ $value }}</span></dd>
                        <dt class="pt-2 pb-1 font-mono text-xs leading-[18px] tracking-[0.1em] text-muted uppercase">{{ $label }}</dt>
                    </div>
                @endforeach
            </dl>
        </x-container>
    </section>

    {{-- Mission & vision --}}
    <section class="bg-paper">
        <x-container class="grid gap-12 py-16 md:py-24 lg:grid-cols-2 lg:gap-16 lg:py-32">
            @foreach ([$a['mission'], $a['vision']] as $n => $item)
                <div class="reveal" style="--d: {{ $n * 100 }}ms">
                    <p class="font-mono text-xs leading-[18px] tracking-[0.1em] text-accent uppercase">{{ $item['label'] }}</p>
                    <p class="pt-5 font-display text-[clamp(1.75rem,2.6vw,2.4rem)] leading-[0.98] tracking-[-0.02em] text-black">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </x-container>
    </section>

    {{-- Values --}}
    <section class="bg-white">
        <x-container class="py-16 md:py-24 lg:py-32">
            <x-section-head :eyebrow="$a['values']['eyebrow']" class="text-ink">{{ $a['values']['title'] }}</x-section-head>
            <div class="grid pt-14 md:grid-cols-2">
                @foreach ($a['values']['items'] as $n => [$title, $text])
                    <div class="reveal group border-t-[1.2px] border-line py-8 md:pe-12" style="--d: {{ ($n % 2) * 100 }}ms">
                        <h3 class="font-display text-2xl leading-9 font-semibold text-ink transition-colors group-hover:text-accent">{{ $title }}</h3>
                        <p class="max-w-[384px] pt-3 text-base leading-[26px] text-muted">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </x-container>
    </section>

    {{-- Story --}}
    <section class="border-y border-line bg-stone/60">
        <x-container class="py-16 md:py-24 lg:py-32">
            <x-section-head :eyebrow="$a['story']['eyebrow']" class="text-ink">{{ $a['story']['title'] }}</x-section-head>
            <div class="pt-14">
                @foreach ($a['story']['items'] as [$year, $title, $text])
                    <div class="reveal group grid gap-2 border-t-[1.2px] border-ink/12 py-7 md:grid-cols-[120px_1fr] md:gap-10">
                        <p class="font-display text-[28.8px] leading-[28.2px] tracking-[-0.02em] text-accent" dir="ltr" style="text-align: start">{{ $year }}</p>
                        <div>
                            <h3 class="font-display text-xl leading-[30px] font-semibold text-ink">{{ $title }}</h3>
                            <p class="max-w-[512px] pt-2 text-base leading-[26px] text-muted">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-container>
    </section>

    {{-- Why us --}}
    <section class="bg-white">
        <x-container class="py-16 md:py-24 lg:py-32">
            <x-section-head :eyebrow="$a['why']['eyebrow']" class="max-w-[565px] text-ink">{{ $a['why']['title'] }}</x-section-head>
            <div class="pt-[52px]">
                @foreach ($a['why']['items'] as $n => [$title, $text])
                    <div class="reveal group flex flex-col gap-4 border-t border-black/20 py-7 md:flex-row md:items-center md:gap-9">
                        <span class="w-11 shrink-0 font-display text-[clamp(1.75rem,2.4vw,2.4rem)] leading-[0.98] tracking-[-0.02em] transition-colors duration-300 group-hover:text-accent {{ $n === 0 ? 'text-accent' : 'text-black/30' }}">{{ str_pad($n + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="flex flex-1 flex-col justify-between gap-4 py-2.5 lg:flex-row lg:items-center">
                            <h3 class="font-display text-[clamp(1.75rem,3.1vw,3.125rem)] leading-none font-light tracking-[-0.02em] text-ink transition-transform duration-300 group-hover:translate-x-2 rtl:group-hover:-translate-x-2">{{ $title }}</h3>
                            <p class="max-w-[492px] text-base leading-[26px] text-muted lg:w-[492px]">{{ $text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-container>
    </section>

    <x-closing-cta :c="$a['cta']" image="cta-about.webp" />
@endsection
