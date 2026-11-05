@props(['eyebrow'])
<div {{ $attributes }}>
    <x-eyebrow class="reveal">{{ $eyebrow }}</x-eyebrow>
    <h2 class="h2 reveal pt-6" style="--d: 80ms">{{ $slot }}</h2>
</div>
