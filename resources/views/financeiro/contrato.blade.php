@extends('layouts.relat-layout')

@section('css')

<style>
  /* td {
    font-size: 9px;
  }
  th {
    font-size: 11px;
  }*/
  .card-header {
    padding: .4rem 1.25rem;
  } 
  p .text-justify {
    font-size: 6%;
    text-align: justify;
  }
</style>
@endsection

@section('content')

<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-2">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline" action="{{ route('contratos') }}" method="GET" >
          @csrf
          <div class="col-12 col-sm-12 col-md-6" >
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" name="codcliente"  type="text" placeholder="codigo" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                      <i class="fas fa-search"></i>
                  </button>
                </div>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>


<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> JNET - Telecom
              <small class="float-right">Date: {{ \Carbon\Carbon::now()}}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <center>
            <h6>
            <br/>
                TERMO DE ADESÃO AO CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE COMUNICAÇÃO <br/>
                MULTIMIDIA E PROVIMENTO DE ACESSO À INTERNET
            </h6>
            </center>
          <br/>

          <p class="text-justify">
             Por este instrumento particular, o ASSINANTE abaixo qualificado contrata e adere ao Serviço Comunicação Multimídia 
            prestado por <b>JNET PROVEDORES DE INTERNET LTDA ME</b>, autorizada pela Anatel para explorar o Serviço de Comunicação Multimídia 
            pelo Ato nº 3009, de 10 de Agosto de 2016, disponibilizado o recebimento de ligações a cobrar, endereço eletrônico 
            www.jnetce.com.br, e-mail suporte@jnetce.com.br, doravante denominada CONTRATADA.
          </p>
          <br/>
          <table  class="table">
              <tr>
                <td><b>NOME: </b></td>
                <td> {{ $cliente->nome_razaosocial }} </td>
                <td><b>NASCIMENTO: </b></td>
                <td> {{ $cliente->nascimento }} </td>
                <td><b>CPF/CNPJ: </b></td>
                <td> {{ $cliente->cpf }}</td>
              </tr>

              <tr>
                <td><b> ENDEREÇO: </b></td>
                <td> {{ $cliente->complementoendereco }}</td>
                <td><b> RG/ID:</b></td>
                <td> {{ $cliente->rg }}</td>
                <td><b> CEP </b></td>
                <td> {{ $cliente->cep }}</td>
              </tr>

              <tr>
                <td><b>  EMAIL </b></td>
                <td> {{ $cliente->email }}</td>
                <td><b>  CELULAR:</b></td>
                <td> {{ $cliente->fone01 }}</td>
                <td><b>  TELEFONE:</b></td>
                <td> {{ $cliente->fone02 }}</td>
              </tr>

          </table>

        </br>

          <div class="row">
            <div class="col-12 table-responsive">
                <p class="text-justify">
                    Os equipamentos locados pelas CONTRATADAS à CONTRATANTE, devidamente discriminados na Nota Fiscal/Ordem de Serviço/Recibo, deverão ser guardados e conservados no mesmo estado de sua entrega, cumprindo à CONTRATANTE indenizar as CONTRATADAS, em valor correspondente a seu valor de mercado, nas hipóteses de danificação, extravio ou inutilização dos mesmos por fatores atribuíveis à CONTRATANTE ou a terceiros, como mau uso, manuseio indevido, negligência, imprudência, imperícia ou dolo.
                    Noutro passo, sobrevindo defeitos ou problemas nos equipamentos atribuíveis às CONTRATADAS, estas deverão providenciar a sua substituição, no prazo mencionado no Contrato de Prestação de Serviços de Conexão à Internet e Serviços de Comunicação Multimídia, por outros similares que atendam ao mesmo fim. Uma vez rescindida esta avença, surgirá o dever da CONTRATANTE de devolver os equipamentos às CONTRATADAS no prazo máximo de 3(três) dias úteis, em perfeito estado de funcionamento e conservação, sob as penas da indenização referida acima e tomada das medidas legalmente cabíveis
                    Quando não incluídos no Plano de Acesso, o custo da Conexão Simultânea, Ponto de Acesso Adicional, das Horas de Conexão Adicionais (tecnologias distintas e/ou mesma tecnologia, mas fora dos períodos pré-definidos no Plano de Acesso), Franquia Adicional de Tráfego/Bits ou Horas, do Suporte Técnico e as visitas técnicas deverão ser pagas pelo ASSINANTE, juntamente com os pagamentos periódicos de seu Plano de Acesso, com base no número de ocorrências e/ou cálculo efetuado pelo sistema de bilhetagem (aferição e contagem de horas).
                    O ASSINANTE fica cientificado que as CONTRATADAS fiscalizarão a regular utilização dos serviços ora contratados, e a violação das normas, caso detectada pelas CONTRATADAS, implicará aplicação das sanções atinentes à espécie, conforme estipulado no Contrato de Prestação de Serviço de Comunicação Multimídia e Provimento de Acesso à Internet (SCM/SVA) aderido.
                    CONDIÇÕES DE DEGRADAÇÃO OU INTERRUPÇÃO DOS SERVIÇOS PRESTADOS: O ASSINANTE tem ciência dos motivos que podem culminar na degradação dos serviços de comunicação multimídia (SCM) prestados, são eles: (a) Ações da natureza, tais como chuvas, descargas atmosféricas e outras que configurem força maior; (b) Interferências prejudiciais provocadas por equipamentos de terceiros; (c) Bloqueio da visada limpa; (d) Casos fortuitos; (e) Interrupção de energia elétrica; (f) Falhas nos equipamentos e instalações; (g) Rompimento parcial ou total dos meios de rede; (h) Interrupções por ordem da ANATEL, ordem Judicial ou outra investida com poderes para tal; (i) outras previstas contratualmente;
                    DECLARAÇÃO DE CONCORDÂNCIA: Declaro, para os devidos fins, que são corretos os dados cadastrais e informações por mim prestadas neste instrumento. Declaro ainda que os documentos apresentados para formalização deste contrato e as cópias dos documentos entregues às CONTRATADAS pertencem a minha pessoa, tendo ciência das sanções civis e criminais caso prestar declarações falsas, entregar documentos falsos e me passar por outrem. Declaro estar ciente que a assinatura deste instrumento representa expressa concordância aos termos e condições do <b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE COMUNICAÇÃO MULTIMÍDIA E PROVIMENTO DE ACESSO À INTERNET</b>, registrado junto ao Cartório da Comarca de Maranguape/CE, que juntamente com esse TERMO DE ADESÃO formam um só instrumento de direito, tendo lido e entendido claramente as condições ajustadas para esta contratação.
                    AUTORIZAÇÃO: Autorizo o Outorgado (a), , RG N° e CPF N° , a representar-me perante a s CONTRATADAS para o fim de solicitar alterações e/ou serviços adicionais, cancelamentos, negociar débitos, solicitar visitas e reparos, assinar ordens de serviço, termos de contratação e quaisquer solicitações, responder por mim frente a quaisquer questionamentos que sejam realizados, bem como transigir, firmar compromissos e dar quitação.
                    E por estar de acordo com as cláusulas do presente termo e do Contrato de Prestação de Serviço de Comunicação Multimídia e Provimento de Acesso à Internet (SCM), parte integrante deste Termo de Adesão, o ASSINANTE aposta sua assinatura abaixo ou o aceita eletronicamente, para que surta todos os seus efeitos legais. A cópia integral do Contrato de Prestação de Serviços de Comunicação Multimídia pode ser obtida www.jnetce.com.br na aba de serviços, ou no Cartório de Registro de Títulos e Documentos da Comarca de Maranguape/CE.
                  </p>
            </div>
            <table  class="table">
              <tr>
                <td align="center"><b>_____________________________________________ </b></td>
              </tr>
              <tr>
                <td align="center"> {{ $cliente->nome_razaosocial }} </td>
              </tr>
            </table>
            <!-- /.col -->
          </div>
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <a href="javascript:void(0)" onClick="window.print()" class="btn btn-sm btn-default float-right"><i class="fas fa-print"></i> Imprimir</a>
              {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card" disabled></i> Submit
                Payment
              </button>--}}
            </div>
          </div>
        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection

@section('javascript')
<!-- DataTables -->
<script src="{{ asset('/vendor/plugins/jquery/jquery.min.js') }}"></script>
@stop
