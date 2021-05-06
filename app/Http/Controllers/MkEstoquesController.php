<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\MkOsRepository;
use App\Entities\MkOs;;
/**
 * Class MkEstoquesController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkEstoquesController extends Controller
{
    protected $inicio;
    protected $fim;
    protected $osRepository;
  
    public function __construct( MkOsRepository $osRepository)
    {
      $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
      $this->fim = Carbon::now()->format('Y-m-d 23:59:59');
      $this->osRepository = $osRepository;
    }

    public function funcionarios(){
      $funcionarios = DB::connection('pgsql')->table('fr_usuario')
      ->whereNull('usr_inicio_expiracao')
      ->select('usr_codigo', 'usr_nome')
      ->get();
      return $funcionarios;
    }

    public function tipos(){
      $tipos = DB::connection('pgsql')->table('mk_os_tipo')
      ->select('codostipo','descricao')
      ->get();
      return $tipos;
    }

    public function grupos(){
      $grupos = DB::connection('pgsql')->table('mk_agenda_grupo')
      ->select('codagenda_grupo','nome')
      ->get();
      return $grupos;
    }

    public function classificacoes(){
      $tipos = DB::connection('pgsql')->table('mk_os_classificacao_encerramento')->get();
      return $tipos;
    }

    public function fiscalizar(Request $request){

        $fim = $this->fim;
        $inicio = $this->inicio;
        $dt_filtro = 'data_abertura';
    
        $tipos = $this->tipos();
        $grupos = $this->grupos();
        $tecnicos = $this->funcionarios();
        $consultores = $this->funcionarios();
        $classificacoes = $this->classificacoes();

        if ($request->dt_filtro == 1) {
          $dt_filtro = 'data_fechamento';
        }
        if($request->has('dt_inicio'))
        {
          $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
          $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
        }
        if ($request->has('classificacoes')){
          $classiFiltro = $request->classificacoes;
        } else {
          foreach ($classificacoes as $r) {
            $classiFiltro[] = $r->codclassifenc;
          }
        }
    
        $result = DB::connection('pgsql')->table('mk_os as os')
        ->join('mk_pessoas as cliente', 'os.cliente', 'cliente.codpessoa')
        ->leftJoin('mk_agenda_grupo as grupo', 'os.cdagendagrupo', 'grupo.codagenda_grupo')
        ->leftJoin('mk_os_tipo as os_tipo', 'os.tipo_os', 'os_tipo.codostipo')
        ->leftJoin('mk_contratos as contrato', 'os.cd_contrato', 'contrato.codcontrato')
        ->leftJoin('mk_conexoes as conex', 'os.conexao_associada', 'conex.codconexao')
        ->leftJoin('mk_contratos_aceite as aceite', 'contrato.codcontrato', 'aceite.contrato')
        ->leftJoin('mk_os_classificacao_encerramento  as classificacao', 'os.classificacao_encerramento', 'classificacao.codclassifenc')
        ->leftJoin('fr_usuario as tecnico', 'os.operador_fech_tecnico', 'tecnico.usr_codigo')
        ->leftJoin('fr_usuario as consultor', 'os.tecnico_responsavel', 'consultor.usr_codigo')
        ->leftJoin('mk_os_itens as os_itens', 'os.codos', 'os_itens.cd_integracao')
        ->whereIn('os.classificacao_encerramento', $classiFiltro)
        ->whereBetween($dt_filtro, [$inicio, $fim])
        ->select(
          'os.data_abertura','os.data_fechamento', 'os.codos', 'os.tipo_os' , 'os_tipo.descricao as servico', 'os.cdagendagrupo'
          ,'os.tecnico_responsavel', 'os.operador_fech_tecnico', 'os.indicacoes as taxa', 'os.classificacao_encerramento','os_itens.qnt'
          ,'cliente.codpessoa' ,'cliente.nome_razaosocial as cliente', 'cliente.inativo', 'cliente.complementoendereco'
          ,'tecnico.usr_nome as tecnico'
          ,'consultor.usr_nome as consultor'
          ,'contrato.vlr_renovacao as plano'
          ,'classificacao.classificacao'
          ,'aceite.aceito', 'aceite.local_aceite'
          ,'conex.mac_address as mac'
        )->distinct('os.codos')
        ->get();

        //FILTROS
        if ($request->has('tecnicos'))
          {
            $tecFiltro = $request->tecnicos;
            $servicos = $result
              ->whereIn('operador_fech_tecnico', $tecFiltro )
              ->sortBy('operador_fech_tecnico')->sortBy('data_fechamento');
          } elseif ( $request->has('grupos')) {
            $grupoFiltro = $request->grupos;
            $servicos = $result
              ->whereIn('cdagendagrupo', $grupoFiltro)
              ->sortBy('tecnico_responsavel')->sortBy('data_fechamento');
          } elseif( $request->has('tipos')) {
            $tipoFiltro = $request->tipos;
            $servicos = $result
              ->whereIn('tipo_os', $tipoFiltro )
              ->sortBy('tipo_os')->sortBy('data_fechamento');
          }else{
            $servicos = $result->sortBy('operador_fech_tecnico')->sortBy('data_fechamento');
          }
    
        if (request()->wantsJson()) {
          return response()->json([
            'servicos'   => $servicos
          ]);
        }
        return view('estoque.fiscalizar', compact('servicos','tecnicos', 'grupos', 'tipos' , 'classificacoes' , 'inicio', 'fim'));
      }

      public function ajaxEstoque(Request $request){
        $result = DB::connection('pgsql')->table('mk_os_itens as os_itens')
            ->leftJoin('mk_estoque as estoque', 'os_itens.item', '=' ,'estoque.codestoque')
            ->where('os_itens.cd_integracao', $request->codos)
            ->select('estoque.descricao_produto','os_itens.qnt', 'os_itens.retirada', 'os_itens.tipo_saida')
            ->get();

        return response()->json([
          'result' => $result
        ]);
      }

      public function ajaxCliente(Request $request){
        $os = MkOs::find($request->codos);
        return response()->json([
          'endereco' => $os->logradouro->logradouro.' '.$os->num_endereco.' '.$os->logradouro->bairro->bairro,
          // 'status' => $os->conexao->analiseauth
        ]);
      }
}
