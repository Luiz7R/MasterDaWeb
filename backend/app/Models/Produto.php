<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Produto extends Model
{

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'preco'
    ];  
    
    public function vendas()
    {
        return $this->hasMany(Venda::class);      
    }

    public function quantidadeVendida()
    {
        return $this->vendas()->count();      
    }

    public function promo()
    {
        return $this->hasOne(ProductPromo::class);
    }
}