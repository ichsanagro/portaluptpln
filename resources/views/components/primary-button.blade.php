<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex w-full justify-center rounded-md bg-blue-800 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500']) }}>
    {{ $slot }}
</button>
