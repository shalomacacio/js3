<?php

namespace App\Http\Controllers;

use App\Entities\MkPessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    protected $inicio;
    protected $fim; 

    public function __construct()
    {
      $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
      $this->fim = Carbon::now()->format('Y-m-d 23:59:59');
    }
    public function contratos(Request $request){
      $cliente = new MkPessoa();
      if($request->codcliente){
        $cliente = MkPessoa::find($request->codcliente);
        // return dd($cliente);
      }
        return view('financeiro.contrato', compact('cliente'));
    }

}
