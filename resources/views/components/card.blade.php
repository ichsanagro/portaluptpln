<div {{ $attributes->merge(['class' => 'overflow-hidden bg-white shadow-sm sm:rounded-xl']) }}>
    {{-- The main content of the card will be injected here --}}
    {{ $slot }}
</div>
