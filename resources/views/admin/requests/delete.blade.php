@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Excluir Requisição #{{ $request->id }}</h1>
        <p class="text-gray-600">Você está prestes a excluir esta requisição e todos os seus itens. Esta ação não pode ser desfeita.</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Informações da Requisição</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">ID da Requisição</p>
                    <p class="font-semibold">{{ $request->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Usuário</p>
                    <p class="font-semibold">{{ $request->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Data da Requisição</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($request->requested_at)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total de Itens</p>
                    <p class="font-semibold">{{ $request->items->count() }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Itens da Requisição</h3>
            
            @if(count($request->items) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantidade
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($request->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->product->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantity }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-4 text-center text-gray-500">
                    Nenhum item encontrado para esta requisição.
                </div>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('requests.show', $request) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Cancelar
            </a>
            <form action="{{ route('requests.destroy', $request) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
@endsection