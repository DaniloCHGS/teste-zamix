<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComponent extends Model
{
    protected $table = 'product_components';
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'component_id',
        'quantity'
    ];

    /**
     * Produto composto que utiliza este componente.
     * Relacionamento belongsTo com Product (product_id).
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Produto simples que é componente do produto composto.
     * Relacionamento belongsTo com Product (component_id).
     */
    public function component()
    {
        return $this->belongsTo(Product::class, 'component_id');
    }
}
