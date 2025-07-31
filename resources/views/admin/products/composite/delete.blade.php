@extends('layouts.admin')

@section('content')
    <x-module-header title="Excluir Produto Composto" description="Confirme a exclusão do produto composto abaixo." />
    <x-card class="mx-auto">
        <p class="mb-6">Tem certeza que deseja excluir o produto composto <strong>{{ $product->name }}</strong>?</p>
        <form method="POST" action="#">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Confirmar Exclusão</button>
            <a href="#" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </form>
    </x-card>
@endsection
