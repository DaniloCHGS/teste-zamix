@extends('layouts.admin')

@section('content')
    <x-module-header title="Excluir Produto Simples" description="Confirme a exclusão do produto abaixo." />
    <x-card class="mx-auto">
        <p class="mb-6">Tem certeza que deseja excluir o produto <strong>{{ $product->name }}</strong>?</p>
        <form method="POST" action="{{ route('products.simple.destroy', $product->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmar Exclusão</button>
            <a href="{{ route('products.simple.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>
@endsection
