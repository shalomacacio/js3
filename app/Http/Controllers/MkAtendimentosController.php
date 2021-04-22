<?php

namespace App\Http\Controllers;

use App\Entities\MkApi;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\MkAtendimentoProcesso;
use App\Entities\MkAtendimentoSubProcesso;
use App\Entities\MkAtendimentoClassificacao;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MkAtendimentoCreateRequest;
use App\Http\Requests\MkAtendimentoUpdateRequest;
use App\Repositories\MkAtendimentoRepository;
use App\Validators\MkAtendimentoValidator;
use Ixudra\Curl\Facades\Curl;

/**
 * Class MkAtendimentosController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkAtendimentosController extends Controller
{
    /**
     * @var MkAtendimentoRepository
     */
    protected $repository;

    /**
     * @var MkAtendimentoValidator
     */
    protected $validator;

    protected $inicio;
    protected $fim;
    protected $url;
    protected $api;

    /**
     * MkAtendimentosController constructor.
     *
     * @param MkAtendimentoRepository $repository
     * @param MkAtendimentoValidator $validator
     */
    public function __construct(MkAtendimentoRepository $repository, MkAtendimentoValidator $validator, MkApi $api)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->url = env('WS_MK_URL');

        $this->inicio = Carbon::now()->format('Y-m-d 00:00:00');
        $this->fim = Carbon::now()->format('Y-m-d 23:59:59');
        
        $this->api = $api;
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return "não criada";
    }

    public function create(){
      return view('mkAtendimentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MkAtendimentoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        $token = $this->mkLogin()["Token"];
        $response = Curl::to($this->url.'/mk/WSMKNovoAtendimento.$rule?sys=MK0&token='.$token
        .'&cd_contrato='.$request->cd_contrato
        .'&cd_cliente='.$request->codigoCliente
        .'&cd_processo='.$request->codigoProcesso
        .'&cd_classificacao_ate='.$request->codigoClassificacaoAtendimento
        .'&origem_contato='.$request->codigoOrigemContato
        . '&info='.$request->informacaoAtendimento
        )
        ->post();
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mkAtendimento = $this->repository->find($id);
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $mkAtendimento,
            ]);
        }
        return view('mkAtendimentos.show', compact('mkAtendimento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mkAtendimento = $this->repository->find($id);
        return view('mkAtendimentos.edit', compact('mkAtendimento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MkAtendimentoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MkAtendimentoUpdateRequest $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $mkAtendimento = $this->repository->update($request->all(), $id);
            $response = [
                'message' => 'MkAtendimento updated.',
                'data'    => $mkAtendimento->toArray(),
            ];
            if ($request->wantsJson()) {
                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'MkAtendimento deleted.',
                'deleted' => $deleted,
            ]);
        }
        return redirect()->back()->with('message', 'MkAtendimento deleted.');
    }

    public function atendimentos (Request $request) {
        $inicio = $this->inicio;
        $fim = $this->fim;

        $processos = MkAtendimentoProcesso::all();
        $subprocessos = MkAtendimentoSubProcesso::all();
        $classificacaos = MkAtendimentoClassificacao::all();
    
        if($request->has('dt_inicio'))
        {
          $inicio = Carbon::parse($request->dt_inicio)->format('Y-m-d 00:00:00');
          $fim = Carbon::parse($request->dt_fim)->format('Y-m-d 23:59:59');
        }

        $result = DB::connection('pgsql')->table('mk_atendimento as atendimento')
                    ->join('mk_pessoas as pessoa', 'atendimento.cliente_cadastrado', 'pessoa.codpessoa')
                    ->leftjoin('mk_ate_processos as processo', 'atendimento.cd_processo', 'processo.codprocesso')
                    ->leftjoin('mk_ate_subprocessos as subprocesso', 'atendimento.cd_subprocesso', 'subprocesso.codsubprocesso')
                    ->leftjoin('mk_atendimento_classificacao as classificacao', 'atendimento.classificacao_atendimento', 'classificacao.codatclass')
                    ->leftJoin('mk_contratos as cont', 'atendimento.cd_contrato', 'cont.codcontrato')
                    ->whereBetween('atendimento.dt_abertura', [$inicio, $fim])
                    ->select('atendimento.codatendimento','atendimento.dt_abertura', 'atendimento.operador_abertura' 
                    ,'atendimento.como_foi_contato', 'atendimento.cd_processo', 'atendimento.cd_subprocesso'
                    ,'atendimento.classificacao_atendimento','atendimento.dt_hr_insert','atendimento.dh_fim'
                    ,'pessoa.nome_razaosocial as cliente' 
                    ,'processo.nome_processo'
                    ,'subprocesso.nome_subprocesso'
                    ,'classificacao.descricao as classificacao'
                    ,'cont.codcontrato', 
                    )
                    ->get();
        //FILTROS
        if($request->processos){
            $procFiltro = $request->processos;
            $atendimentos = $result
            ->whereIn('cd_processo', $procFiltro );
        } else if ($request->subprocessos){
            $subFiltro = $request->subprocessos;
            $atendimentos = $result
            ->whereIn('cd_subprocesso', $subFiltro );
        } else if( $request->classificacaos ){
            $classFiltro = $request->classificacaos;
            $atendimentos = $result
            ->whereIn('classificacao_atendimento', $classFiltro );
        } else {
            $atendimentos = $result;
        }
        return view('relatorios.atendimentos', compact('atendimentos','processos','subprocessos', 'classificacaos', 'inicio', 'fim'));
    }

    public function mkLogin(){
        $result = Curl::to($this->url.'/mk/WSAutenticacao.rule?sys=MK0&token=ac15acdc9a564b94448dcf2bcf4e673d&password=3462570e1b53236&cd_servico=9999')
        ->get();
        $response = json_decode($result, true);
        return $response;
    }

    public function abertos(Request $request) {

        $processos = MkAtendimentoProcesso::all();
        $subprocessos = MkAtendimentoSubProcesso::all();
        $classificacaos = MkAtendimentoClassificacao::all();
    
        $result = DB::connection('pgsql')->table('mk_atendimento as atendimento')
                    ->join('mk_pessoas as pessoa', 'atendimento.cliente_cadastrado', 'pessoa.codpessoa')
                    ->leftjoin('mk_cidades as cidade', 'atendimento.cidade', 'cidade.codcidade' )
                    ->leftjoin('mk_bairros as bairro', 'atendimento.bairro', 'bairro.codbairro' )
                    ->leftjoin('mk_logradouros as logradouro', 'atendimento.logradouro', 'logradouro.codlogradouro' )
                    ->leftjoin('mk_ate_processos as processo', 'atendimento.cd_processo', 'processo.codprocesso')
                    ->leftjoin('mk_ate_subprocessos as subprocesso', 'atendimento.cd_subprocesso', 'subprocesso.codsubprocesso')
                    ->leftjoin('mk_atendimento_classificacao as classificacao', 'atendimento.classificacao_atendimento', 'classificacao.codatclass')
                    ->where('finalizado', 'N')
                    ->whereNotNull('cliente_cadastrado')
                    ->whereNotNull('classificacao_atendimento')
                    ->whereNotNull('cd_subprocesso')
                    ->select(
                    'atendimento.codatendimento','atendimento.dt_abertura', 'atendimento.operador_abertura', 
                    'atendimento.como_foi_contato', 'atendimento.cd_processo', 'atendimento.cd_subprocesso',
                    'atendimento.classificacao_atendimento',
                    'pessoa.nome_razaosocial as cliente', 'pessoa.numero','pessoa.contato', 'pessoa.fone01', 'pessoa.fone02', 'pessoa.fax',
                    'bairro.bairro', 'cidade.cidade', 'logradouro.logradouro',
                    'processo.nome_processo',
                    'subprocesso.nome_subprocesso',
                    'classificacao.descricao as classificacao'
                    )
                    ->get();
        //FILTROS
        if($request->processos){
            $procFiltro = $request->processos;
            $atendimentos = $result
            ->whereIn('cd_processo', $procFiltro );
        } else if ($request->subprocessos){
            $subFiltro = $request->subprocessos;
            $atendimentos = $result
            ->whereIn('cd_subprocesso', $subFiltro );
        } else if( $request->classificacaos ){
            $classFiltro = $request->classificacaos;
            $atendimentos = $result
            ->whereIn('classificacao_atendimento', $classFiltro );
        } else {
            $atendimentos = $result;
        }

        $atendimentos = $atendimentos->sortBy('logradouro');
        return view('mkAtendimentos.abertos', compact('atendimentos','processos','subprocessos', 'classificacaos', 'request'));
    }


    public function osPorAtend(Request $request){
        

    }
   

}

