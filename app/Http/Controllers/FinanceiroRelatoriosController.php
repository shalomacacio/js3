<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class FinanceiroRelatoriosController.
 *
 * @package namespace App\Http\Controllers;
 */
class FinanceiroRelatoriosController extends Controller
{
    protected $inicio;
    protected $fim;

    public function __construct()
    {
        $this->inicio = Carbon::now()->format('Y-d-m 00:00:00');
        $this->fim = Carbon::now()->format('Y-d-m 23:59:59');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelamentos( Request $request)
    {
      $processos = [26,76,91];
      $tipoOs = [2,133];
      $cancelamentos = DB::table('mk_atendimento')
                        ->whereIn('cd_processo', $processos )
                        ->select('cliente_cadastrado')
                        ->get();

      $ordens = DB::table('mk_os')
                        ->whereIn('tipo_os', $tipoOs )
                        ->get();

      $pessoas = DB::table('mk_pessoas  as cliente')
                      ->joinSub( $cancelamentos, 'cancelamentos', function ($cancelamento) {
                        $cancelamento->on('cliente.codpessoa', '=', 'cancelamentos.cliente_cadastrado' );
                      })->get();

        if (request()->wantsJson()) {
          return response()->json([
              'result' => $ordens,
          ]);
        }

      return $pessoas;
    }

}
