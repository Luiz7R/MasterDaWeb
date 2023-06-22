<?php

namespace App\Repositories;

use App\Models\Venda;
use App\Repositories\CarrinhoRepository;
use Illuminate\Support\Facades\Auth;

class VendasRepository
{
    private $model;
    private $carrinhoRepository;

    public function __construct()
    {
        $this->model = new Venda();

        $this->carrinhoRepository = new CarrinhoRepository;

    }

    public function getVendas()
    {
        if ( empty(Auth::user()->id) )
            return abort(404);

        return  Venda::all()->count();
    }

    public function finalizeTransaction($itens) {
        $transaction = Venda::insert($itens);

        if ( $transaction ) {
            $this->carrinhoRepository->limparCarrinho();
        }

        return $transaction;
    }
}