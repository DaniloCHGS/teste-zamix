@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Detalhes da Requisição #{{ $request->id }}</h1>
            <p class="text-gray-600">Visualize os detalhes completos da requisição.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('requests.edit', $request) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
            <a href="{{ route('requests.delete', $request) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Excluir
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
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
                    <p class="text-gray-600 text-sm">Criado em</p>
                    <p class="font-semibold">{{ $request->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Última Atualização</p>
                    <p class="font-semibold">{{ $request->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total de Itens</p>
                    <p class="font-semibold">{{ $request->items->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Itens da Requisição</h2>
            
            @if(count($request->items) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->id }}
                                </td>
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
    </div>

    <div class="mt-6">
        <a href="{{ route('requests.index') }}" class="text-blue-500 hover:underline">
            &larr; Voltar para a lista de requisições
        </a>
    </div>
@endsection