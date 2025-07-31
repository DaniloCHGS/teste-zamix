<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $fillable = [
        'request_id',
        'product_id',
        'quantity'
    ];

    /**
     * Requisição à qual este item pertence.
     * Relacionamento belongsTo com Request.
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    /**
     * Produto referenciado neste item de requisição.
     * Relacionamento belongsTo com Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
