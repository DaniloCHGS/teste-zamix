@props(['type' => 'info', 'dismissible' => false])

@php
    $classes = [
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
    ];
    
    $icons = [
        'info' => 'info',
        'success' => 'check-circle',
        'warning' => 'alert-triangle',
        'error' => 'x-circle',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'border px-4 py-3 rounded-lg relative ' . $classes[$type]]) }} role="alert">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <i data-lucide="{{ $icons[$type] }}" class="w-5 h-5"></i>
        </div>
        <div class="ml-3 flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $type === 'info' ? 'bg-blue-100 text-blue-500 hover:bg-blue-200 focus:ring-blue-600' : ($type === 'success' ? 'bg-green-100 text-green-500 hover:bg-green-200 focus:ring-green-600' : ($type === 'warning' ? 'bg-yellow-100 text-yellow-500 hover:bg-yellow-200 focus:ring-yellow-600' : 'bg-red-100 text-red-500 hover:bg-red-200 focus:ring-red-600')) }}">
                        <span class="sr-only">Fechar</span>
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div> 