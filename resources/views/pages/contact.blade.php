@extends('layouts.app', ['title' => $t['nav']['cta'], 'headerLight' => true])

@php
    $c = $t['contact'];
    $f = $c['form'];
@endphp

@section('content')
    <div class="bg-paper">
        {{-- Intro --}}
        <x-container class="pt-36 pb-10 md:pt-40">
            <x-eyebrow class="reveal">{{ $c['eyebrow'] }}</x-eyebrow>
            <h1 class="reveal max-w-[1088px] pt-6 font-display text-[clamp(2.75rem,6.9vw,5.5rem)] leading-[0.98] tracking-[-0.02em] text-ink" style="--d: 80ms">{{ $c['title'] }}<span class="text-accent">{{ $c['accent'] }}</span></h1>
            <p class="reveal max-w-[576px] pt-6 text-[17px] leading-[1.625] text-muted" style="--d: 140ms">{{ $c['body'] }}</p>
        </x-container>

        <form method="POST" action="{{ route('contact.send') }}" id="contact-form" class="scroll-mt-28" novalidate>
            @csrf
            <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

            {{-- What do you need? --}}
            <x-container class="pt-11 pb-[72px]">
                <fieldset class="max-w-[1088px]">
                    <legend class="font-display text-2xl leading-9 font-semibold text-ink">{{ $c['need'] }}</legend>
                    <div class="grid gap-4 pt-8 sm:grid-cols-3 lg:max-w-[755px]">
                        @foreach ($c['options'] as $key => $label)
                            <label class="reveal group relative flex min-h-32 cursor-pointer flex-col justify-between border-[1.2px] border-line p-6 transition-colors duration-200 hover:border-accent/60 has-[:checked]:border-accent has-[:checked]:bg-accent/5 has-[:focus-visible]:outline-2 has-[:focus-visible]:outline-offset-2 has-[:focus-visible]:outline-accent" style="--d: {{ $loop->index * 80 }}ms">
                                <input type="radio" name="need" value="{{ $key }}" class="sr-only" @checked(old('need', 'supplies') === $key)>
                                <span class="font-mono text-xs leading-[18px] text-accent">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="pt-6 font-display text-lg leading-[27px] font-semibold text-ink">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            </x-container>

            {{-- Details + form --}}
            <x-container class="pb-24">
                <div class="grid gap-12 lg:grid-cols-[445fr_579fr] lg:gap-16">
                    <div class="reveal self-start border-y-[1.2px] border-line">
                        @foreach ($c['info'] as [$label, $value])
                            <div class="border-b-[1.2px] border-line py-5 last:border-b-0">
                                <p class="label">{{ $label }}</p>
                                <p class="pt-1 font-display text-lg leading-[27px] text-ink" @if ($loop->index < 3) dir="ltr" style="text-align: start" @endif>{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        @if (session('sent'))
                            <p role="status" class="mb-8 border-[1.2px] border-accent bg-accent/5 p-4 text-[15px] leading-6 text-ink">{{ $f['sent'] }}</p>
                        @endif
                        @if (session('error'))
                            <p role="alert" class="mb-8 border-[1.2px] border-red-600 bg-red-50 p-4 text-[15px] leading-6 text-red-800">{{ $f['error'] }}</p>
                        @endif

                        <div class="grid gap-x-8 gap-y-6 sm:grid-cols-2">
                            @foreach ([
                                ['name', 'text', true, 'name'],
                                ['company', 'text', false, 'organization'],
                                ['email', 'email', true, 'email'],
                                ['phone', 'tel', false, 'tel'],
                            ] as [$key, $type, $required, $auto])
                                <div>
                                    <label for="f-{{ $key }}" class="label block pb-2">{{ $f[$key] }}@if ($required) <span class="text-accent">*</span>@endif</label>
                                    <input id="f-{{ $key }}" name="{{ $key }}" type="{{ $type }}" value="{{ old($key) }}" autocomplete="{{ $auto }}"
                                           placeholder="{{ $f[$key.'_ph'] }}" @required($required) class="field @error($key) !border-red-600 @enderror" @if ($type !== 'text') dir="ltr" @endif>
                                    @error($key)<p class="pt-1 text-xs text-red-700">{{ $message }}</p>@enderror
                                </div>
                            @endforeach

                            <div class="sm:col-span-2">
                                <label for="f-subject" class="label block pb-2">{{ $f['subject'] }}</label>
                                <input id="f-subject" name="subject" type="text" value="{{ old('subject') }}" placeholder="{{ $f['subject_ph'] }}" class="field">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="f-message" class="label block pb-2">{{ $f['message'] }}</label>
                                <textarea id="f-message" name="message" rows="5" placeholder="{{ $f['message_ph'] }}" class="field min-h-[145px] resize-y leading-6">{{ old('message') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-solid mt-8 cursor-pointer">{{ $f['send'] }} <x-arrow /></button>
                    </div>
                </div>
            </x-container>
        </form>

        {{-- Map --}}
        <x-container class="pb-24">
            <div class="reveal relative h-[300px] overflow-hidden border-[1.2px] border-line bg-ink sm:h-[466px]">
                <img src="{{ site_image('contact-map.webp') }}" alt="" loading="lazy" decoding="async" class="absolute inset-0 size-full object-cover opacity-40">
                <div class="absolute inset-0 grid place-items-center">
                    <div class="flex flex-col items-center">
                        <span class="relative grid size-4 place-items-center">
                            <span class="absolute -inset-1.5 animate-ping rounded-full bg-accent/30"></span>
                            <span class="relative size-4 rounded-full bg-accent"></span>
                        </span>
                        <span class="pt-4 font-mono text-xs leading-[18px] tracking-[0.1em] whitespace-nowrap text-paper">{{ $c['map'] }}</span>
                    </div>
                </div>
            </div>
            <p class="flex flex-wrap gap-x-4 gap-y-1 pt-6 text-sm leading-[21px] text-muted">
                <span class="font-mono text-xs leading-[18px]">{{ $c['access_label'] }}</span>
                <span>{{ $c['access'] }}</span>
            </p>
        </x-container>
    </div>
@endsection
