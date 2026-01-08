@props(['icon', 'title', 'value'])

<div class="overflow-hidden rounded-xl bg-white p-5 shadow-sm">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg {{ $icon_bg_color ?? 'bg-gray-100' }} {{ $icon_text_color ?? 'text-gray-600' }}">
                {{ $icon }}
            </div>
        </div>
        <div class="ml-5 w-0 flex-1">
            <dl>
                <dt class="truncate text-sm font-medium text-slate-500">{{ $title }}</dt>
                <dd class="text-3xl font-bold text-slate-900">{{ $value }}</dd>
            </dl>
        </div>
    </div>
</div>
