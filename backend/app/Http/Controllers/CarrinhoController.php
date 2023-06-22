<?php

namespace App\Http\Controllers;

use App\Repositories\CarrinhoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public $repository;

    public function __construct(CarrinhoRepository $repository) {
        $this->repository = $repository;
    }

    public function itensCarrinho() {
        return response()->json($this->repository->itensCarrinho(), 200);
    }

    public function adicionarAoCarrinho(Request $request) {
        $produtoCarrinho = $this->repository->adicionarAoCarrinho($request);

        if ( $produtoCarrinho ) {
            return response()->json(['msg' => 'Produto Adicionado com Sucesso', 'produto' => $produtoCarrinho], 201);
        }
    }

    public function atualizarProdutoNoCarrinho(Request $request,$productId) {

        $produtoCarrinho = $this->repository->atualizarProdutoNoCarrinho($request,$productId);

        if ( $produtoCarrinho ) {
            return response()->json(['msg' => 'Atualizado com Sucesso'], 204);
        }
    }

    public function removerProdutoDoCarrinho($id) {
        return $this->repository->removerProdutoDoCarrinho($id);
    }
}
