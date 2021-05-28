<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GeogridCreateRequest;
use App\Http\Requests\GeogridUpdateRequest;
use App\Repositories\GeogridRepository;
use App\Validators\GeogridValidator;
use Ixudra\Curl\Facades\Curl;
use App\Entities\MkPessoa;
use Illuminate\Support\Arr;

/**
 * Class GeogridsController.
 *
 * @package namespace App\Http\Controllers;
 */
class GeogridsController extends Controller
{
    protected $path;
    protected $key;
    protected $url;

    
    
    public function __construct(){
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

    public function reservarPorta(Request $request){
    
        $endpoint='/fichaEquipamento/reservarPorta';
         $codigo = $request->codigo; 
         $porta =$request->porta; 
         $cliente = $request->cliente;

        $response = Curl::to($this->url.$endpoint)
        ->withData( array( 
                            'codigo' => $codigo,
                            'porta' => $porta,
                        ) 
                  )
        ->post();

        $this->anotacao($codigo, $porta, $cliente);

        return redirect()->back()->with('message', $response);
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

        // $filtered = Arr::where($equipamentos, function ($value, $key) {
        //     return $value->id_tipo == 5786;
        // });

        // $equipamentos = $filtered;

        return view('geogrids.teste', compact('equipamentos'));
    }

    public function anotacao($codigo, $porta, $texto){
        $endpoint='/fichaEquipamento/fazerAnotacao';

        $response = Curl::to($this->url.$endpoint)
        ->withData( array(  
                            'codigo' => $codigo, 
                            'porta' => $porta, 
                            'direcao' => 's', 
                            'texto' => $texto
                        ) 
                    )
        ->post();
    }
}
