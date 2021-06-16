<?php

namespace App\Http\Controllers;

use App\Entities\MkFatura;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\SMS;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


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
        $this->inicio = Carbon::now()->format('Y-m-d');
        $this->fim = Carbon::now()->format('Y-m-d');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelamentos( Request $request)
    {
      $processos = [107,121, 122];
      $inicio = null;
      $fim = null;

      if($request->dt_inicio && $request->dt_fim){
        $inicio = $request->dt_inicio;
        $fim = $request->dt_fim;
      }

      $result = DB::connection('pgsql')->select((
        "
        select a.codatendimento, a.dt_abertura as ate_abertura, a.cd_processo, p.nome_processo as processo, a.dt_finaliza as ate_fechamento
        ,os.codos, ot.descricao as os,  os.data_abertura as os_abertura, os.data_fechamento as os_fechamento, oc.classificacao, os.encerrado, os.servico_prestado
          from mk_atendimento as a
          join mk_ate_processos as p on a.cd_processo = p.codprocesso
          left join mk_atendimento_classificacao as ac on a.classificacao_encerramento = ac.codatclass
          left join mk_ate_os as ao on a.codatendimento = ao.cd_atendimento
          left join mk_os as os on ao.cd_os = os.codos 
          left join mk_os_tipo as ot on os.tipo_os = ot.codostipo
          left join mk_os_classificacao_encerramento as oc on os.classificacao_encerramento = oc.codclassifenc
        where a.cd_processo in (107,121,122)
        and a.dt_abertura between ? and ?
        "      
      ),[$inicio, $fim]);

        $cancelamentos = $result;

        if (request()->wantsJson()) {
          return response()->json([
              'result' => $cancelamentos,
          ]);
        }

      return view('financeiro.relatorios.cancelamentos', compact('cancelamentos'));
    }

    public function cobranca(Request $request) {

      switch ($request->tipo_cobranca) {
        case '1':
          $tipo = Carbon::now()->add(2, 'day')->format('Y-m-d');
          break;
        case '2':
          $tipo = Carbon::now()->format('Y-m-d');
          break;
        case '3':
          $tipo = Carbon::now()->sub(5, 'day')->format('Y-m-d');
          break;
        default:
          $tipo = null;
          break;
      }

      $planosNao = ['01.04.01.00','01.04.01.01','01.04.01.02','01.04.02.00','01.04.02.01','01.04.02.02'];

      $result = DB::connection('pgsql')->select((
      "
      select f.codfatura, f.ld_cobranca, p.nome_razaosocial, p.fone01, p.fone02 , 
        f.data_vencimento, f.valor_total, f.cd_faturamento, f.plano_contas, pc.unidade_financeira
        from mk_faturas as f 
        join mk_contas_faturadas as cf on f.codfatura = cf.cd_fatura 
        join mk_plano_contas as pc on cf.cd_conta = pc.codconta 
        join mk_pessoas as p on f.cd_pessoa  = p.codpessoa 
      where f.liquidado = 'N'
      and p.codpessoa not in (select a.cliente_cadastrado from mk_atendimento as a where a.cd_processo in (121,122))
      and f.suspenso = 'N'
      and f.tipo <> 'P'
      and f.tipo_cobranca = 1
      and f.valor_total > 1
      and pc.unidade_financeira not in ('01.04.01.00','01.04.01.01','01.04.01.02','01.04.02.00','01.04.02.01','01.04.02.02')
      and f.data_vencimento = ?
      "      
      ), [ $tipo ]); 

      $cobrancas = $result;
      return view('financeiro.relatorios.cobranca', compact('cobrancas', 'request'));
    }

    public function cobrancaSMS(Request $request){
      $faturas = $request->faturas;
      $sms = new SMS();

      foreach ($faturas as $codfatura) {
        $fatura = MkFatura::find($codfatura);
        $vencimento = Carbon::parse($fatura->data_vencimento)->format('d/m');
        $telefone =  $fatura->cliente->fone01;
        $firstName = Str::before($fatura->cliente->nome_razaosocial, ' ');

        switch ($request->tipo) {
          case '1':
            $mensagem = "Olá, ". $firstName.". Não esqueça, sua fatura JNET vence dia".$vencimento. ".Para facilitar o pagamento segue o código de barras:".$fatura->ld_cobranca;
            break;
          case '2':
            $mensagem = "Olá, ". $firstName.". Sua fatura JNET vence hoje. Para facilitar estamos enviando o código de barras para pagamento: ".$fatura->ld_cobranca;  
            break;
          case '3':
            $mensagem = "Olá, ". $firstName.". Não identificamos o pagamento da sua fatura JNET com vencimento ".$vencimento. ". Acesse nosso Whatsapp: 3341-7168 e solicite boleto atualizado!";
            break;
          default:
            $mensagem = "Jnet: Conectando você ao mundo";
            break;
        }

        $result = $sms->send($mensagem, $telefone);
      }
      return redirect()->back()->with(['message'=> " Mensagens enviadas"]);
    }

}

