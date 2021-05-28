<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Entities\MkPessoa;

use function PHPSTORM_META\type;

class GeogridController extends Controller
{
    protected $path;
    protected $key;
    protected $url;

    
    
    public function __construct(MkPessoa $cliente){
        $this->path = env('GEOGRID_PATH');
        $this->key = env('GEOGRID_TOKEN');
        $this->url = $this->path.'/api/v2/?exec='.$this->key;
    }

    public function geogrid(){
        return view('geogrid.index');
    }

    public function testeApi($endpoint='/fichaCaixa/consultar'){
        $response = Curl::to($this->url.$endpoint)
        ->post();
    }

    public function clientesCadastrar($endpoint='/clientes/cadastrar', $integrador=45800 ){
        $pessoa = MkPessoa::find($integrador);

        $response = Curl::to($this->url.$endpoint)
        ->withData( array( 
                            'tipo' => 1,
                            'nome' => $pessoa->nome_razaosocial,
                            'id_integrador' => $integrador
                        ) 
                  )
        ->post();
        return dd($response);
    }

    public function reservarPorta($endpoint='/fichaEquipamento/reservarPorta', $codigo, $porta){

        $response = Curl::to($this->url.$endpoint)
        ->withData( array( 
                            'codigo' => $codigo,
                            'porta' => $porta,
                        ) 
                  )
        ->post();
    }



    public function reservarPortaCliente($endpoint='/fichaEquipamento/reservarPortaCliente', $codigo, $porta, $cliente, $integrador){
        
        $response = Curl::to($this->url.$endpoint)
        ->withData( array( 
                            'codigo' => $codigo,
                            'porta' => $porta,
                            'id_cliente' => $cliente,
                            'id_integrador' => $integrador,
                        ) 
                  )
        ->post();
    }

    public function cancelarReservaPorta($endpoint='/fichaEquipamento/cancelarReservaPorta'){
        $response = Curl::to($this->url.$endpoint)
        ->withData( array( 
                            'codigo' => 'NRM_DIV101',
                            'porta' => '1',
                         ) 
                  )
        ->post();

        return dd($response);
    }

    public function equipamentos($endpoint='/fichaEquipamento/consultar'){
        $response = Curl::to($this->url.$endpoint)
        ->asJson()
        ->get();
        $equipamentos = $response->registros;
        return view('geogrid.teste', compact('equipamentos'));
    }

    public function anotacao($endpoint='/fichaEquipamento/fazerAnotacao'){
        $response = Curl::to($this->url.$endpoint)
        ->withData( array(  
                            'codigo' => 'NRM_DIV101', 
                            'porta' => 1, 
                            'direcao' => 's', 
                            'texto' => 'texto teste'
                        ) 
                    )
        ->post();
    }

}
