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
        return view('financeiro.contrato');
    }

    public function ajaxCliente(Request $request)
    {
      header('Content-Type: application/json; charset=utf-8');
  
      $cliente = MkPessoa::find($request->nome_razaosocial);
      
      if ($cliente == null) {
        return response()->json([
          'error'   => true,
          'message' => " Cliente não encontrado".$request
        ]);
      }

      return response()->json($cliente);
    }

    public function autocomplete(Request $request)
    {
      $cli = "%".$request->input('query')."%";

      $datasMK = DB::connection('pgsql')->select('select codpessoa, nome_razaosocial from mk_pessoas where nome_razaosocial LIKE ?', [$cli]);
      $datasJS = DB::connection('mysql')->select('select id, nome_razaosocial from clientes where nome_razaosocial LIKE ?', [$cli]);

      $datas = $datasJS;

      if($datas == null){
        $datas =  $datasMK;
      }

      $dataModified = array();
      foreach ($datas as $data)
      {
        $dataModified[] = $data->nome_razaosocial;
      }

     return response()->json($datas);
    }

}
