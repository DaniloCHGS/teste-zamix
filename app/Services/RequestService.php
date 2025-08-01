<?php

namespace App\Services;

use App\Models\Request;
use App\Repositories\RequestRepository;
use Illuminate\Database\Eloquent\Collection;

class RequestService
{
    protected RequestRepository $requestRepository;

    /**
     * Construtor do serviço
     *
     * @param RequestRepository $requestRepository
     */
    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    /**
     * Obter todas as requisições
     *
     * @return Collection
     */
    public function getAllRequests(): Collection
    {
        return $this->requestRepository->getAllWithRelations();
    }

    /**
     * Obter uma requisição específica
     *
     * @param int $id
     * @return Request|null
     */
    public function getRequestById(int $id): ?Request
    {
        return $this->requestRepository->findWithRelations($id);
    }

    /**
     * Criar uma nova requisição
     *
     * @param array $requestData
     * @param array $items
     * @return Request
     */
    public function createRequest(array $requestData, array $items): Request
    {
        return $this->requestRepository->createWithItems($requestData, $items);
    }

    /**
     * Atualizar uma requisição existente
     *
     * @param Request $request
     * @param array $requestData
     * @param array $items
     * @return Request
     */
    public function updateRequest(Request $request, array $requestData, array $items): Request
    {
        return $this->requestRepository->updateWithItems($request, $requestData, $items);
    }

    /**
     * Excluir uma requisição
     *
     * @param Request $request
     * @return bool
     */
    public function deleteRequest(Request $request): bool
    {
        return $this->requestRepository->delete($request);
    }
}