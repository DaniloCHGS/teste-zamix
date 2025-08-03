<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\RequestItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RequestRepository
{
    /**
     * Obter todas as requisições com usuário relacionado
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithRelations(int $userId = null)
    {
        $query = Request::with(['user', 'items.product']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->latest('requested_at')->paginate(15);
    }

    /**
     * Obter uma requisição específica com todos os relacionamentos
     *
     * @param int $id
     * @return Request|null
     */
    public function findWithRelations(int $id): ?Request
    {
        return Request::with(['user', 'items.product'])->find($id);
    }

    /**
     * Criar uma nova requisição com seus itens
     *
     * @param array $requestData
     * @param array $items
     * @return Request
     */
    public function createWithItems(array $requestData, array $items): Request
    {
        return DB::transaction(function () use ($requestData, $items) {
            $request = Request::create($requestData);

            foreach ($items as $item) {
                $request->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity']
                ]);
            }

            return $request->load(['user', 'items.product']);
        });
    }

    /**
     * Atualizar uma requisição e seus itens
     *
     * @param Request $request
     * @param array $requestData
     * @param array $items
     * @return Request
     */
    public function updateWithItems(Request $request, array $requestData, array $items): Request
    {
        return DB::transaction(function () use ($request, $requestData, $items) {
            $request->update($requestData);

            // Remove todos os itens existentes
            $request->items()->delete();

            // Adiciona os novos itens
            foreach ($items as $item) {
                $request->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity']
                ]);
            }

            return $request->load(['user', 'items.product']);
        });
    }

    /**
     * Excluir uma requisição e seus itens
     *
     * @param Request $request
     * @return bool
     */
    public function delete(Request $request): bool
    {
        return DB::transaction(function () use ($request) {
            // Os itens serão excluídos automaticamente devido à restrição de chave estrangeira com onDelete('cascade')
            return $request->delete();
        });
    }
}
