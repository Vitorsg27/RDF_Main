<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    public function comandas(): HasMany
    {
        return $this->hasMany(Comanda::class);
    }

    protected $fillable = ['disponivel'];
}
