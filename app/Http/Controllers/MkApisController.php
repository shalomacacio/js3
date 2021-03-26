<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Entities\MkApi;
use App\Entities\FrUsuario;
use Illuminate\Http\Request;
use App\Entities\GrupoPessoas;
use App\Validators\MkApiValidator;
use App\Repositories\MkApiRepository;


/**
 * Class MkApisController.
 *
 * @package namespace App\Http\Controllers;
 */
class MkApisController extends Controller
{
    /**
     * @var MkApiRepository
     */
    protected $api;

    /**
     * MkApisController constructor.
     *
     * @param MkApiRepository $repository
     * @param MkApiValidator $validator
     */
    public function __construct(MkApi $api) {
      $this->api = $api;
    }

    public function getTokenAuth(){
       return $this->api->getTokenAuth();
    }

    public function dbMigracao(){
        $grupoPessoas = GrupoPessoas::all();
        for($i=0; $i<=1; $i++){
            $cliente =  $grupoPessoas->get(0);
            $result =  $this->createPessoa($cliente);
            return $result;  
        }
     }

    // public function teste(Request $request){
    //     return dd($request);
    //     // return $this->api->createAtendimento();
    // }

}
