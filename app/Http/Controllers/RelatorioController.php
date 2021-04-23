<?php

namespace App\Http\Controllers;

use App\Entities\MkAtendimento;
use App\Entities\MkContrato;
use App\Entities\MkFatura;
use App\Entities\MkPessoa;
use App\Entities\Radacct;
use Egulias\EmailValidator\Exception\AtextAfterCFWS;
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
    
        $result = DB::connection('pgsql')->table('mk_os as os')
          ->join('mk_pessoas as cliente', 'os.cliente', 'cliente.codpessoa')
          ->leftJoin('mk_os_tipo as os_tipo', 'os.tipo_os', 'os_tipo.codostipo')
          ->leftJoin('mk_contratos as contrato', 'os.cd_contrato', 'contrato.codcontrato')
          ->leftJoin('mk_os_classificacao_encerramento  as classificacao', 'os.classificacao_encerramento', 'classificacao.codclassifenc')
          ->leftJoin('fr_usuario as tecnico', 'os.operador_fech_tecnico', 'tecnico.usr_codigo')
          ->leftJoin('fr_usuario as consultor', 'os.tecnico_responsavel', 'consultor.usr_codigo')
          // ->whereIn('os.classificacao_encerramento', $classiFiltro) // NÃO DESCOMENTAR
          ->whereBetween($dt_filtro, [$inicio, $fim])
          ->select(
            'os.data_abertura','os.data_fechamento', 'os.codos', 'os.tipo_os' , 'os_tipo.descricao as servico'
            ,'os.tecnico_responsavel', 'os.operador_fech_tecnico', 'os.indicacoes as taxa', 'os.classificacao_encerramento', 'os.servico_prestado'
            ,'cliente.nome_razaosocial as cliente', 'cliente.inativo'
            ,'tecnico.usr_nome as tecnico'
            ,'consultor.usr_nome as consultor'
            ,'contrato.vlr_renovacao as plano', 'contrato.codcontrato', 'contrato_eletronico'
            ,'classificacao.classificacao'
          )->get();
        //FILTROS
        if ($request->has('classificacoes') ){
          $classiFiltro = $request->classificacoes;
          $servicos = $result
          ->whereIn('classificacao_encerramento', $classiFiltro );
        }
        elseif($request->has('tecnicos'))
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
      if(!$request->dt_inicio){
        $inicio = $this->inicio;
      } else {
        $inicio = $request->dt_inicio;
      }

      if(!$request->dt_fim){
        $fim = $this->fim;
      } else {
        $fim = $request->dt_fim;
      }

      $situacao = "N";

      if($request->situacao) {
        $situacao = $request->situacao;
      }
        
      $result = DB::connection('pgsql')->table('mk_contratos as contrato')
        ->join('mk_planos_acesso as plano', 'contrato.plano_acesso', 'plano.codplano')
        ->join('mk_pessoas as cliente', 'contrato.cliente', 'cliente.codpessoa')
        ->leftJoin('mk_revendas as revenda', 'cliente.cd_revenda', 'revenda.codrevenda')
        ->leftJoin('mk_motivo_cancelamento as motivo', 'contrato.motivo_cancelamento_2', 'motivo.codmotcancel' )
        ->leftJoin('mk_logradouros as logradouro', 'cliente.codlogradouro', 'logradouro.codlogradouro' )
        ->leftJoin('mk_bairros as bairro', 'cliente.codbairro', 'bairro.codbairro' )
        ->leftJoin('mk_cidades as cidade', 'cliente.codcidade', 'cidade.codcidade' )
        // ->where('cancelado', $situacao)
        ->where('suspenso', 'N')
        ->select(
          'contrato.codcontrato', 'contrato.adesao','contrato.vlr_renovacao', 'contrato.dt_cancelamento'
          ,'contrato.unidade_financeira', 'contrato.cancelado'
          ,'cliente.codpessoa','cliente.nome_razaosocial', 'cliente.inativo', 'cliente.numero'
          ,'cliente.contato','cliente.fone01', 'cliente.fone02'
          ,'revenda.nome_revenda as revenda'
          ,'motivo.descricao_mot_cancel as motivo'
          ,'logradouro.logradouro'
          ,'bairro.bairro'
          ,'cidade.cidade'
          ,'plano.descricao as plano'
        )->get();
        
        $contratos = $result->sortBy('adesao');
        
        if($request->dt_inicio) {
          $inicio = $request->dt_inicio;
          $fim = $request->dt_fim;
          $contratos = $result->whereBetween('adesao',[$inicio, $fim])->sortBy('adesao');
        }
        return view('relatorios.contratos', compact('contratos', 'inicio', 'fim', 'request'));
    }

    public function contratos_os() {
      $result1 = DB::connection('pgsql')
      ->table('mk_os as os')
      ->leftJoin('mk_contratos as contrato', 'os.cd_contrato', 'contrato.codcontrato')
      ->whereIn('tipo_os', [89,90,111,132])
      ->whereBetween('os.data_fechamento', ['2020-11-01', '2021-01-27'])
      ->select('codcontrato', 'codos')
      ->count();

      $result2 = DB::connection('pgsql')
      ->table('mk_contratos ')
      ->leftJoin('mk_contratos as contrato', 'os.cd_contrato', 'contrato.codcontrato')
      ->whereIn('tipo_os', [89,90,111,132])
      ->whereBetween('os.data_fechamento', ['2020-11-01', '2021-01-27'])
      ->select('codcontrato', 'codos')
      ->count();

      return $result1;
    }

    public function contratos_faturas(Request $request) {

      if(!$request->dt_inicio){
        $inicio = $this->inicio;
        $fim = $this->fim;
      } else {
        $inicio = $request->dt_inicio;
        $fim = $request->dt_fim;
      }    

      $contratos = MkContrato::whereBetween('adesao', [$inicio, $fim ])
      ->get();

      return view('relatorios.contratos_faturas', compact('contratos', 'inicio', 'fim'));
    }

    public function radacct(){
      $radaccts = Radacct::whereIn('nasportid',[3167309, 3166710])
      ->select('username')
      ->get();
      return view('relatorios.radacct', compact('radaccts'));
    }

    public function inadimplencias(Request $request)
    {
      $hoje = Carbon::now()->format('Y-m-d');
      $dia = $request->dia;

      
      //ATENDIEMNTOS ABERTOS DE RETENÇÃO N USAR, CAN PEDIDO, CAN INADIMPLENCIA 
      $result_atend = DB::connection('pgsql')->table('mk_atendimento')
      // ->whereNotNull('cd_processo') // FILTRAR ATENDIMENTOS  COM BUG 
      ->whereIn('cd_processo', [56,121,122]) //RETENÇÃO N USAR, CAN PEDIDO, CAN INADIMPLENCIA 
      ->where('finalizado', 'N')
      ->pluck('cliente_cadastrado')
      ->toArray();

      $atendimentos = implode(',' , $result_atend);

      $result = DB::connection('pgsql') ->table('mk_faturas as f')
      ->where('f.data_vencimento', '<' ,$hoje )
      ->join('mk_pessoas as p','f.cd_pessoa', 'p.codpessoa')
      ->where('f.liquidado','N')
      ->where('f.excluida','N')
      ->where('f.suspenso','N')
      ->where('f.valor_total', '>', 0)
      ->whereRaw('DATE(NOW()) - data_vencimento >= ?', [$dia])
      ->select('f.codfatura', 'f.data_vencimento', 'dt_ref_inicial' ,'nome_razaosocial', 'fone01', 'fone02'
      ,'descricao','valor_total', 'cd_pessoa'
      , DB::raw( 'DATE(NOW()) - data_vencimento  as dias')
      , DB::raw("(CASE WHEN p.codpessoa IN (".$atendimentos.") THEN 'SIM' ELSE 'NAO' END) as atend")
      )
      ->get();

      // return dd($result);


      // SOMENTE QUEM NÃO TEM ATENDIMENTO ABERTO 
      // $inadimplencias = $result->whereNotIN('cd_pessoa', $atendimentos)->sortByDesc('data_vencimento');

      // TODAS 
      $inadimplencias = $result->sortByDesc('data_vencimento');
    
      return view('financeiro.relatorios.inadimplencias', compact('inadimplencias', 'dia'));
    }

    public function renovacoes(Request $request){

      if(!$request->dt_inicio){
        $inicio = $this->inicio;
      } else {
        $inicio = $request->dt_inicio;
      }

      if(!$request->dt_fim){
        $fim = $this->fim;
      } else {
        $fim = $request->dt_fim;
      }

      $result = DB::connection('pgsql')->table('mk_contratos_controle_renovacao_detalhe as ccrd')
        ->join('mk_contratos_contas as cc', 'ccrd.cd_contrato', 'cc.cd_contrato')
        ->join('mk_contas_faturadas as cf', 'cc.cd_conta', 'cf.cd_conta')
        ->join('mk_faturas as f', 'cf.cd_fatura', 'f.codfatura')
        ->join('mk_pessoas as p', 'f.cd_pessoa', 'p.codpessoa')
        ->where('ccrd.ocorrencia', 1)
        // ->where('f.liquidado', 'S')
        ->whereRaw("DATE(ccrd.vcto_final - INTERVAL '11 MONTHS') = f.data_vencimento ")
        ->select( 'ccrd.cd_contrato' , DB::raw("date(ccrd.vcto_final - interval '11 months')as inicio")  
        ,'ccrd.vcto_final', 'ccrd.cd_renvoacao_auto', 'ccrd.vlr_renovacao'
        ,'p.codpessoa', 'p.nome_razaosocial', 'p.fone01', 'p.fone01', 'p.fone02' ,'cc.cd_contrato', 
        'f.data_vencimento', 'f.liquidado')
        ->get();
      // ->toSql();

      $renovacoes = $result;
        return view('financeiro.relatorios.renovacoes', compact('renovacoes'));
    }

    public function ultimaData( $dt ){
      $a = DB::connection('pgsql')->table('mk_atendimento')
      ->where('cd_processo', [86])
      ->where('a.dt_abertura','>', $dt )
      ->pluck('dt_abertura')
      ->first();
      return $a;
    }

    public function sla(Request $request ){

      if(!$request->dt_inicio){
        $inicio = $this->inicio;
      } else {
        $inicio = $request->dt_inicio;
      }

      if(!$request->dt_fim){
        $fim = $this->fim;
      } else {
        $fim = $request->dt_fim;
      }

      $atendimentos = DB::connection('pgsql')->table('mk_atendimento as a')
        ->join('mk_ate_os as at_os', 'a.codatendimento', 'at_os.cd_atendimento')
        ->leftJoin('mk_os as os', 'at_os.cd_os','os.codos')
        ->leftJoin('mk_os_tipo as tipo', 'os.tipo_os','tipo.codostipo')
        ->leftJoin('mk_pessoas as p', 'a.cliente_cadastrado', 'p.codpessoa')
        ->leftJoin('fr_usuario as u', 'os.operador_fech_tecnico', 'u.usr_codigo')
        ->whereBetween('dt_abertura', [$inicio, $fim])
        ->select('p.nome_razaosocial'
            ,'a.codatendimento', 'a.dt_hr_insert', 'a.dh_fim', 'a.finalizado'
            // , DB::raw('CAST(DATE_FORMAT(CONCAT(os.data_fechamento," ", os.hora_fechamento,":00"), "%Y-%m%-%d %H:%i:%s") AS DATETIME)')
            , DB::raw("CONCAT(os.data_abertura,' ' ,os.hora_abertura) as abertura")
            , DB::raw("CONCAT(os.data_fechamento,' ' ,os.hora_fechamento) as fechamento")
            ,'os.codos', 'os.dh_insert', 'os.dt_hr_fechamento_tec', 'os.encerrado', 'os.operador_fechamento'
            ,'u.usr_nome'
            ,'tipo.descricao'
            )
        ->get();

      return view('relatorios.sla', compact('atendimentos'));
    }

    public function slaGarantia(Request $request ){

      if(!$request->dt_inicio){
        $inicio = $this->inicio;
      } else {
        $inicio = $request->dt_inicio;
      }

      $fim = Carbon::parse($inicio)->subDays(30);
      $fim60 = Carbon::parse($inicio)->subDays(60);
      
      $result = DB::connection('pgsql')->table('mk_atendimento as a')
        ->leftJoin('mk_ate_os as at_os', 'a.codatendimento', 'at_os.cd_atendimento')
        ->join('mk_os as os', 'at_os.cd_os','os.codos')
        ->join('mk_pessoas as p', 'a.cliente_cadastrado', 'p.codpessoa')
        ->whereBetween('dt_abertura', [$fim, $inicio])
        ->select('p.codpessoa','p.nome_razaosocial'
            , DB::raw("COUNT(DISTINCT a.codatendimento) as tickets" )
            , DB::raw("COUNT(os.codos) as os" )
            )
        ->groupBy('p.codpessoa','p.nome_razaosocial')
        ->get();

        $atendimentos = $result;

      return view('relatorios.sla_garantia', compact('atendimentos', 'request', 'inicio', 'fim'));
    }

    public function ajaxClientOs(Request $request){
      $inicio = Carbon::parse($request->inicio)->format('Y-m-d');
      $fim = Carbon::parse($request->fim)->format('Y-m-d');
      $cliente = $request->cliente;

      $servicos = DB::connection('pgsql')->table('mk_os as os')
                    ->join('mk_os_tipo as tipo', 'os.tipo_os', 'tipo.codostipo')
                    ->join('mk_os_classificacao_encerramento as class', 'os.classificacao_encerramento', 'class.codclassifenc')
                    ->where('os.cliente', $cliente )
                    ->whereBetween('os.data_abertura', [ $fim ,$inicio] )
                    ->select( 'os.codos','os.data_abertura as abertura', 'os.data_fechamento'
                    , 'tipo.descricao as tipo'
                    ,'class.classificacao as class_enc')
                    ->get();
      
      return response()->json([
        'result' => $servicos
      ]);
    }

    public function ajaxClientAte(Request $request){
      $cliente = $request->cliente;
      $inicio = Carbon::parse($request->inicio)->format('Y-m-d');
      $fim = Carbon::parse($request->fim)->format('Y-m-d');
      
      $servicos = DB::connection('pgsql')->table('mk_atendimento as ate')
                    ->join('mk_ate_os as at_os', 'ate.codatendimento', 'at_os.cd_atendimento')
                    ->join('mk_ate_processos as processo', 'ate.cd_processo', 'processo.codprocesso')
                    ->join('mk_atendimento_classificacao as classif', 'ate.classificacao_atendimento','classif.codatclass')
                    ->join('mk_atendimento_classificacao as classifenc', 'ate.classificacao_encerramento','classifenc.codatclass' )
                    ->where('ate.cliente_cadastrado', $cliente )
                    ->whereBetween('ate.dt_abertura', [$fim, $inicio] )
                    ->select('ate.codatendimento', 'dt_abertura', 'ate.classificacao_encerramento', 'ate.dt_finaliza'
                              ,'processo.nome_processo'
                              ,'classif.descricao'
                              ,'classifenc.descricao as classifenc')
                    ->orderBy('dt_abertura')
                    ->get();

      return response()->json([
        'result' => $servicos
      ]);
    }
    
    public function teste(){
      return view('relatorios.teste');
    }
}
