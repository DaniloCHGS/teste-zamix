<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'type',
        'cost_price',
        'sale_price'
    ];

    /**
     * Componentes de um produto composto.
     * Se este produto for do tipo 'composite', retorna os produtos simples que o compõem.
     * Relacionamento belongsToMany com a própria tabela products via product_components.
     */
    public function components(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_components', 'product_id', 'component_id')
            ->withPivot('quantity');
    }

    /**
     * Produtos compostos que utilizam este produto como componente.
     * Relacionamento belongsToMany inverso via product_components.
     */
    public function parentProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_components', 'component_id', 'product_id')
            ->withPivot('quantity');
    }

    /**
     * Itens de requisição que referenciam este produto.
     * Relacionamento hasMany com RequestItem.
     */
    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }
}
