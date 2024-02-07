<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Pedido;

class Comanda extends Model
{
    use HasFactory;

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    protected $fillable = ['mesa_id', 'itens', 'aberto'];
}
