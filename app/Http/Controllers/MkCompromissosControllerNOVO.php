<?php

namespace App\Http\Controllers;

use App\Entities\Geogrid;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Entities\MkAgendaGrupo;
use App\Entities\MkPessoa;
use Illuminate\Support\Facades\DB;

class MkCompromissosController extends Controller
{
    protected $inicio;
    protected $fim;

    public function __construct()
    {
        $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
        $this->fim  = Carbon::now()->format('Y-m-d 23:59:59');
    }

    public function agenda(Request $request)
    {
      $inicio = $this->inicio;
      $fim = $this->fim;
      $filter = 'tec.codpessoa';
      $filterValue = [];

      if($request->dt_filtro)
      {
        $inicio = Carbon::parse($request->dt_filtro)->format('Y-m-d 00:00:00');
        $fim = Carbon::parse($request->dt_filtro)->format('Y-m-d 23:59:59');
      }

      if( $request->tecnicos ){
        $filter = 'tec.codpessoa';
        $filterValue = $request->tecnicos;
      }

      $result = DB::connection('pgsql')->table('mk_compromissos as c')
        ->join('mk_compromisso_pessoa as cp', 'c.codcompromisso',  'cp.codcompromisso')
        ->join('mk_os as os', 'c.cd_integracao','os.codos')
        ->join('mk_os_tipo as tipo', 'os.tipo_os','tipo.codostipo')
        ->leftJoin('mk_os_classificacao_encerramento as classif', 'os.classificacao_encerramento', 'classif.codclassifenc')
        ->join('mk_pessoas as tec', 'cp.cdpessoa',  'tec.codpessoa')
        ->join('mk_pessoas as cli', 'c.cliente', 'cli.codpessoa')
        ->join('mk_bairros as b', 'os.cd_bairro', 'b.codbairro')
        ->leftJoin('mk_conexoes as con', 'os.conexao_associada', 'con.codconexao')
        ->whereBetween('c.com_inicio',[$inicio, $fim])
        ->whereIn($filter, $filterValue)
        ->select('c.com_inicio','c.com_fim','c.codcompromisso'
                ,'tec.codpessoa as codTec', 'tec.nome_razaosocial as nomeTec' 
                ,'cli.nome_razaosocial as nomeCli'
                , 'os.dt_hr_fechamento_tec' ,'os.ultimo_status_app_mk_tx as status'
                , 'classif.classificacao'
                ,'b.bairro'
                ,'tipo.descricao')
      ->get();

      $grupos = MkAgendaGrupo::all();
      $compromissos = $result->sortBy('com_inicio');
      $tecnicos = $result->pluck('nomeTec', 'codTec');

      if($request->grupos){
        $compromissos = $result->whereIn( 'cdagendagrupo', $request->grupos);
        $mkCompromissos = $compromissos->groupBy('nomeTec'); 
      } else {
        $mkCompromissos = $result->groupBy('nomeTec'); 
      } 
      
      if (request()->wantsJson()) {
        return response()->json([
          'data' => $mkCompromissos,
        ]);
      }

      $geogrid = new Geogrid();
      $equipamentos = $geogrid->equipamentos;

      $total = $compromissos->count();
      $concluidos = $compromissos->whereNotNull('dt_hr_fechamento_tec')->count();
      return view('mkCompromissos.agenda', compact('mkCompromissos', 'tecnicos' ,'grupos', 'equipamentos', 'request', 'total', 'concluidos'));
    }

    public function getGeogrid(){

    }
    
}
