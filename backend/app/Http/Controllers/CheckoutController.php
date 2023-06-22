<?php

namespace App\Http\Controllers;

use App\Repositories\CarrinhoRepository;
use App\Repositories\SalesRepository;
use App\Repositories\VendasRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public $repository;
    public $vendasRepository;

    public function __construct (
        CarrinhoRepository $repository,
        VendasRepository $vendasRepository
    ) {
        $this->repository = $repository;
        $this->vendasRepository = $vendasRepository;
    }

    public function completeSale(Request $request) {
        $itens = $this->repository->getProdutosNoCarrinho();
        $transacao = $this->vendasRepository->finalizeTransaction($itens);

        if ( !$transacao ) 
        {
            return response()->json(
                ['msg' => 'ERRO: Ao realizar a Transação, Entre em contato com o suporte!']
            , 400);
        }

        return response()->json(
            ['msg' => 'Transação realizada com sucesso!', 'transacao' => $transacao]
        , 200);

    }
}
