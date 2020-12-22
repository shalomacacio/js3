<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    protected $inicio;
    protected $fim;
  
    public function __construct()
    {
      $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
      $this->fim = Carbon::now()->format('Y-m-d 23:59:59');
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

    public function classificacoes(){
      $tipos = DB::connection('pgsql')->table('mk_os_classificacao_encerramento')->get();
      return $tipos;
    }

    public function servicos (Request $request){

        $inicio = $this->inicio;
        $fim = $this->fim;
        $dt_filtro = 'os.data_abertura';
    
        $tipos = $this->tipos();
        $tecnicos = $this->funcionarios();
        $consultores = $this->funcionarios();
        $classificacoes = $this->classificacoes();

        if ($request->dt_filtro == 1){
          $dt_filtro = 'os.data_fechamento';
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
          ->leftJoin('mk_os_tipo as os_tipo', 'os.tipo_os', 'os_tipo.codostipo')
          ->leftJoin('mk_contratos as contrato', 'os.cd_contrato', 'contrato.codcontrato')
          ->leftJoin('mk_os_classificacao_encerramento  as classificacao', 'os.classificacao_encerramento', 'classificacao.codclassifenc')
          ->leftJoin('fr_usuario as tecnico', 'os.operador_fech_tecnico', 'tecnico.usr_codigo')
          ->leftJoin('fr_usuario as consultor', 'os.tecnico_responsavel', 'consultor.usr_codigo')
          ->whereIn('os.classificacao_encerramento', $classiFiltro)
          ->whereBetween($dt_filtro, [$inicio, $fim])
          ->select(
            'os.data_abertura','os.data_fechamento', 'os.codos', 'os.tipo_os' , 'os_tipo.descricao as servico'
            ,'os.tecnico_responsavel', 'os.operador_fech_tecnico', 'os.indicacoes as taxa', 'os.classificacao_encerramento'
            ,'cliente.nome_razaosocial as cliente', 'cliente.inativo'
            ,'tecnico.usr_nome as tecnico'
            ,'consultor.usr_nome as consultor'
            ,'contrato.vlr_renovacao as plano'
            ,'classificacao.classificacao'
          )->get();
        //FILTROS
        if ($request->has('tecnicos'))
          {
            $tecFiltro = $request->tecnicos;
            $servicos = $result
              ->whereIn('operador_fech_tecnico', $tecFiltro )
              ->sortBy('operador_fech_tecnico')->sortBy('data_fechamento');
          } elseif ( $request->has('consultores')) {
            $consultFiltro = $request->consultores;
            $servicos = $result
              ->whereIn('tecnico_responsavel', $consultFiltro )
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
        return view('relatorios.servicos', compact('servicos','tecnicos', 'consultores', 'tipos' , 'classificacoes' , 'inicio', 'fim'));
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contratos(Request $request)
    {
        $inicio = $this->inicio;
        $fim = $this->fim;   
        $situacao = "N";

        if($request->situacao)
        {
          $situacao = $request->situacao;
        }
        
        $result = DB::connection('pgsql')->table('mk_contratos as contrato')
        ->join('mk_planos_acesso as plano', 'contrato.plano_acesso', 'plano.codplano')
        ->join('mk_pessoas as cliente', 'contrato.cliente', 'cliente.codpessoa')
        ->leftJoin('mk_motivo_cancelamento as motivo', 'contrato.motivo_cancelamento_2', 'motivo.codmotcancel' )
        ->leftJoin('mk_logradouros as logradouro', 'cliente.codlogradouro', 'logradouro.codlogradouro' )
        ->leftJoin('mk_bairros as bairro', 'cliente.codbairro', 'bairro.codbairro' )
        ->leftJoin('mk_cidades as cidade', 'cliente.codcidade', 'cidade.codcidade' )

        // ->where('suspenso',"N") //causa das diferenças 
        ->where('cancelado', $situacao) //causa das diferenças 
        ->select(
          'contrato.codcontrato', 'contrato.adesao','contrato.vlr_renovacao', 'contrato.dt_cancelamento'
          ,'cliente.codpessoa','cliente.nome_razaosocial', 'cliente.inativo', 'cliente.numero'
          ,'cliente.contato','cliente.fone01', 'cliente.fone02'
          ,'motivo.descricao_mot_cancel as motivo'
          ,'logradouro.logradouro'
          ,'bairro.bairro'
          ,'cidade.cidade'
          ,'plano.descricao'
        )->get();
           
        if($request->has('dt_inicio')){
            $inicio = $request->dt_inicio;
            $fim = $request->dt_fim;

            $contratos = $result->whereBetween('adesao', [$inicio, $fim])->sortBy('adesao');
        } else {
            $contratos = $result->sortBy('adesao');
        }
        return view('relatorios.contratos', compact('contratos', 'inicio', 'fim', 'request'));
    }

}
