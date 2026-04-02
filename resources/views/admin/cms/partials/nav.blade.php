@php
    $active = $active ?? 'global';
    $items = [
        [
            'key' => 'global',
            'label' => 'Global Settings',
            'href' => route('cms.settings.edit'),
        ],
        [
            'key' => 'home',
            'label' => 'Home',
            'href' => route('cms.pages.edit', ['page' => 'home']),
        ],
        [
            'key' => 'contact',
            'label' => 'Contact',
            'href' => route('cms.pages.edit', ['page' => 'contact']),
        ],
    ];
@endphp

<div class="flex flex-wrap items-center gap-3">
    @foreach ($items as $item)
        <a
            href="{{ $item['href'] }}"
            @class([
                'inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold transition',
                'bg-[#613bf1] text-white shadow-[0_12px_24px_rgba(97,59,241,0.25)]' => $active === $item['key'],
                'border border-slate-200 bg-white text-slate-600 hover:border-slate-300 hover:text-slate-800' => $active !== $item['key'],
            ])
        >
            {{ $item['label'] }}
        </a>
    @endforeach
</div>
