<?php

namespace App\Http\Controllers;

use App\Entities\MkFatura;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Entities\SMS;


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
          $tipo = Carbon::now()->format('Y-m-d');
          break;
      }

      $result = DB::connection('pgsql')->select((
        "
        select f.codfatura, p.nome_razaosocial, p.fone01, p.fone02 , f.data_vencimento, f.valor_total, f.cd_faturamento
            from mk_faturas as f  
                join mk_pessoas as p on f.cd_pessoa  = p.codpessoa 
            where f.liquidado = 'N'
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
        $vencimento = Carbon::parse($fatura->data_vencimento)->format('d-m-Y');
        $telefone =  $fatura->cliente->fone01;

        switch ($request->tipo) {
          case '1':
            $mensagem = "Jnet: Olá, ". $fatura->cliente->nome_razaosocial .", Passando para lembrar que a sua fatura no valor de R$ ".$valor." vencerá no dia ".$vencimento. "Desconsiderar, caso já tenha efetuado o pagamento.";
            break;
          case '2':
            $mensagem = "Jnet: Olá, ". $fatura->cliente->nome_razaosocial .",  Passando para lembrar que a sua fatura no valor de R$ ".$valor." vence hoje! Caso já tenha efetuado o pagamento, desconsiderar esta mensagem.";  
            break;
          case '3':
            $mensagem = "Jnet: Olá, ". $fatura->cliente->nome_razaosocial .". Não identificamos o pagamento da sua fatura com vencimento para ".$vencimento. ". Para facilitar e evitar o bloqueio de amanhã, segue a linha digitável do boleto atualizado:".$fatura->ld_cobranca;
            break;
          default:
            $mensagem = "Jnet: Conectando você ao mundo  ";
            break;
        }
        echo $mensagem."<br />";
      }
      // $return = $sms->send($mensagem, $telefone);
     
        
      // return redirect()->back()->with(['message'=> "Mensagen enviada"]);
    }

}
