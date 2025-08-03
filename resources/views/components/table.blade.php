@props(['striped' => true, 'hover' => true])

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'min-w-full leading-normal']) }}>
            {{ $slot }}
        </table>
    </div>
</div> 