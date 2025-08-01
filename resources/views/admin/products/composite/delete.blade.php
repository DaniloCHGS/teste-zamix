@extends('layouts.admin')

@section('content')
    <x-module-header title="Excluir Produto Composto" description="Confirme a exclusão do produto composto." />
    <x-card class="mx-auto">
        <p class="text-lg text-gray-800 mb-4">Você tem certeza que deseja excluir o produto <strong>{{ $product->name }}</strong>?</p>
        <p class="text-gray-600">Esta ação não poderá ser desfeita.</p>

        <form method="POST" action="{{ route('products.composite.destroy', $product) }}" class="mt-6">
            @csrf
            @method('DELETE')

            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Sim, Excluir</button>
            <a href="{{ route('products.composite.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>
@endsection