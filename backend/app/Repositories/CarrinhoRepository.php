<?php

namespace App\Repositories;

use App\Helpers\CurrencyFormatHelper;
use App\Models\Carrinho;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoRepository
{

    public $model;

    public function __construct() {
        $this->model = new Carrinho();
    }

    public function itensCarrinho() {
        $id = Auth::user()->id;

        $itensCarrinho = $this->model->where('id_usuario', $id)->get();

        $itensCarrinho = $itensCarrinho->map(function($item, $key) {
                $preco = $item->produto->preco * $item->quantidade;
                $item['precoUnitarioFormatado'] = CurrencyFormatHelper::format($item->produto->preco);
                $item['preco'] = $preco;
                $item['precoTotalFormatado'] = CurrencyFormatHelper::format($preco);
                $item['nome'] = $item->produto->nome;
                return $item;
        });

        return $itensCarrinho;
    }

    public function adicionarAoCarrinho(Request $request) {
        $id = auth()->user()->id;
        $produtoCarrinho = $this->model->where('id_produto',$request->id)->first();

        if ( $produtoCarrinho ) {
            $produtoCarrinho->quantidade = $produtoCarrinho->quantidade+1;
            $produtoCarrinho->save();

            return $produtoCarrinho;
        }

        return $this->model->create([
            'id_usuario' => $id,
            'id_produto' => $request->id,
            'quantidade' => $request->quantidade
        ]);

    }

    public function atualizarProdutoNoCarrinho(Request $request,$id) {
        $produtoCarrinho = $this->model->findOrFail($id);
    
        $produtoCarrinho->fill($request->all());
        $produtoCarrinho->save();

        return $produtoCarrinho;
    }

    public function removerProdutoDoCarrinho($id) {
        $basket = $this->model->findOrFail($id);

        return $basket->delete();
    }

    public function getProdutosNoCarrinho() {
        $items = $this->model->where('id_usuario', Auth::user()->id)
               ->select(['id_usuario','id_produto','quantidade'])
               ->get()->toArray();

        $now = Carbon::now();

        foreach ($items as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }
        
       return $items;
    }

    public function limparCarrinho() {
        return $this->model::truncate();// where id_usuario = authuser id
    }
}