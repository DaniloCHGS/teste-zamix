<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Product;
use App\Models\Request;
use App\Services\RequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RequestController extends Controller
{
    protected RequestService $requestService;

    /**
     * Construtor do controlador
     *
     * @param RequestService $requestService
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * Exibe a lista de requisições
     *
     * @return View
     */
    public function index(): View
    {
        $requests = $this->requestService->getAllRequests();
        return view('admin.requests.index', compact('requests'));
    }

    /**
     * Exibe o formulário para criar uma nova requisição
     *
     * @return View
     */
    public function create(): View
    {
        $products = Product::all();
        return view('admin.requests.create', compact('products'));
    }

    /**
     * Armazena uma nova requisição
     *
     * @param StoreRequestRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $requestData = [
            'user_id' => Auth::id(),
            'requested_at' => $validated['requested_at'],
        ];

        $this->requestService->createRequest($requestData, $validated['items']);

        return redirect()->route('requests.index')
            ->with('success', 'Requisição criada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma requisição específica
     *
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        $request = $this->requestService->getRequestById($request->id);
        return view('admin.requests.show', compact('request'));
    }

    /**
     * Exibe o formulário para editar uma requisição
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        $request = $this->requestService->getRequestById($request->id);
        $products = Product::all();
        return view('admin.requests.edit', compact('request', 'products'));
    }

    /**
     * Atualiza uma requisição específica
     *
     * @param UpdateRequestRequest $updateRequest
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(UpdateRequestRequest $updateRequest, Request $request): RedirectResponse
    {
        $validated = $updateRequest->validated();

        $requestData = [
            'user_id' => $request->user_id, // Mantém o usuário original
            'requested_at' => $validated['requested_at'],
        ];

        $this->requestService->updateRequest($request, $requestData, $validated['items']);

        return redirect()->route('requests.index')
            ->with('success', 'Requisição atualizada com sucesso!');
    }

    /**
     * Exibe a confirmação para excluir uma requisição
     *
     * @param Request $request
     * @return View
     */
    public function delete(Request $request): View
    {
        return view('admin.requests.delete', compact('request'));
    }

    /**
     * Remove uma requisição específica
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->requestService->deleteRequest($request);

        return redirect()->route('requests.index')
            ->with('success', 'Requisição excluída com sucesso!');
    }
}