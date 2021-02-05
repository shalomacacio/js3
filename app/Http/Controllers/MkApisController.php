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

     public function createPessoa($pessoa){
        $token = $this->api->getToken();

         $result = Curl::to($this->url."/mk/WSMKNovaPessoa.rule?sys=MK0".
        "&token=".$token.
        "&doc=".$pessoa->cpf_cnpj.
        "&nome=Fulano%De%Tal".//$pessoa->nome.
        "&cep=".$pessoa->cep.
        "&cd_uf=6".
        "&cd_cidade=19".
        "&cd_bairro=394".
        "&cd_logradouro=7277".
        "&numero=10".
        "&complemento=".
        "&cd_empresa=0".
        "&email=jnet@jnece.com.br".
        "&nascimento=22041979".
        "&fone=".preg_replace('/[^0-9]/', '', $pessoa->fone).
        "&cd_revenda=16".
        "&lat=".
        "&lon="
        )
        ->get();
        return $result;
    }

    public function teste(){
        $usuario =  FrUsuario::where('usr_codigo', 1436)->first();
        return $usuario->perfis->get(0)['contra_senha'];
    }

}
