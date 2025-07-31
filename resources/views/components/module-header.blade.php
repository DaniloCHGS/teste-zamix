{{-- resources/views/components/module-header.blade.php --}}
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-2">{{ $title }}</h1>
    @isset($description)
        <p class="text-gray-600">{{ $description }}</p>
    @endisset
</div>
