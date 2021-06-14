<?php

namespace App\Http\Controllers;

use App\Entities\MkFatura;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\SMS;
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

      $result = DB::connection('pgsql')->select((
        "
        select f.codfatura, p.nome_razaosocial, p.fone01, p.fone02 , f.data_vencimento, f.valor_total, f.cd_faturamento
          from mk_faturas as f  
          join mk_pessoas as p on f.cd_pessoa  = p.codpessoa 
        where f.liquidado = 'N'
        and p.codpessoa not in (select a.cliente_cadastrado from mk_atendimento as a where a.cd_processo in (121,122))
        and f.suspenso = 'N'
        and f.tipo <> 'P'
        and f.tipo_cobranca = 1
        and f.valor_total > 1
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
        $valor = number_format($fatura->valor_total, 2, ',', '.');
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
      }
      $result = $sms->send($mensagem, $telefone);
      return redirect()->back()->with(['message'=> $result->count()+" Mensagens enviadas"]);
    }

}
