<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'user_id',
        'requested_at'
    ];

    /**
     * Usuário que fez a requisição.
     * Relacionamento belongsTo com User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Itens da requisição.
     * Relacionamento hasMany com RequestItem.
     */
    public function items()
    {
        return $this->hasMany(RequestItem::class);
    }
}
