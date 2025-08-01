@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Requisições</h1>
        <p class="text-gray-600">Gerencie as requisições de produtos.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        <div>
            <a href="{{ route('requests.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nova Requisição
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @if(count($requests) > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuário
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Data da Requisição
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Qtd. Itens
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Criado em
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($requests as $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($request->requested_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->items->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('requests.show', $request) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                    <a href="{{ route('requests.edit', $request) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    <a href="{{ route('requests.delete', $request) }}" class="text-red-600 hover:text-red-900">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center text-gray-500">
                Nenhuma requisição encontrada. <a href="{{ route('requests.create') }}" class="text-blue-500 hover:underline">Criar uma nova requisição</a>.
            </div>
        @endif
    </div>
@endsection