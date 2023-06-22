<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Repositories\VendasRepository;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{

        public $repository;

        public function __construct(VendasRepository $repository) {
            $this->repository = $repository;
        }

        public function pedidos()
        {
            return Venda::with('produtos')->paginate(15);
        }

        public function produtosMaisVendidos()
        {
            $resultados = DB::table('vendas')
            ->join('produtos', 'produtos.id', '=', 'vendas.id_produto')
            ->select('vendas.id_produto', 'produtos.nome as nome_produto', DB::raw('COUNT(*) as quantidade_vendida'))
            ->groupBy('vendas.id_produto', 'produtos.nome')
            ->orderByDesc('quantidade_vendida')
            ->get();
        
            return response()->json($resultados,200);
        }

        public function lucroProdutos()
        {
            $resultados = DB::table('vendas')
            ->select('vendas.id_produto', 'produtos.nome as nome_produto', DB::raw('SUM(produtos.preco * vendas.quantidade) as lucro'))
            ->join('produtos', 'produtos.id', '=', 'vendas.id_produto')
            ->groupBy('vendas.id_produto', 'produtos.nome')
            ->orderByDesc('lucro')
            ->get();
        
            return response()->json($resultados,200);
        }
}
