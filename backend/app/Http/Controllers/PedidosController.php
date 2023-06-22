<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    public function index()
    {
        return Venda::where('id_usuario', Auth::user()->id)
               ->with('produtos')->paginate(15);
    }
}