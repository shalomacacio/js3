<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\GrupoPessoasCreateRequest;
use App\Http\Requests\GrupoPessoasUpdateRequest;
use App\Repositories\GrupoPessoasRepository;
use App\Validators\GrupoPessoasValidator;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;


/**
 * Class GrupoPessoasController.
 *
 * @package namespace App\Http\Controllers;
 */
class GrupoPessoasController extends Controller
{
    /**
     * @var GrupoPessoasRepository
     */
    protected $repository;

    /**
     * @var GrupoPessoasValidator
     */
    protected $validator;

    protected $url;

    /**
     * GrupoPessoasController constructor.
     *
     * @param GrupoPessoasRepository $repository
     * @param GrupoPessoasValidator $validator
     */
    public function __construct(GrupoPessoasRepository $repository, GrupoPessoasValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->url = env('WS_MK_URL');   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //    return  $this->getEndereco();
        //   return $this->migrar();
        $grupoPessoas = $this->repository->all();
        for($i=0; $i<=1; $i++){
            $cliente =  $grupoPessoas->get(0);
            $result =  $this->migrar($cliente);
            return $result;  
        }
        
        // return ($grupoPessoas);
    }

    public function mkLogin(){
        $result = Curl::to($this->url.'/mk/WSAutenticacaoOperador.rule?sys=MK0&username=shalom.acacio&password=@Shalac79')
        ->get();
        $response = json_decode($result, true);
        return $response;
    }

    public function mkAuth(){
        $tokenUser =  $this->mkLogin()["TokenAutenticacao"];
        $result = Curl::to($this->url.'/mk/WSAutenticacao.rule?sys=MK0&token='.$tokenUser.'&password=3462570e1b53236&cd_servico=9999')
        ->get();
        $response = json_decode($result, true);
        return $response;
    }

    public function novaLead(){
        $token = $this->mkLogin()["TokenAutenticacao"];
        $result = Curl::to($this->url."/mk/WSMKNovaLead.rule?sys=MK0&token=".$token.
        "&cd_cliente=45800".
        "&info=teste")
        ->get();

        return $result;
    }
    public function getEndereco(){
      $token = $this->mkAuth()["Token"];
      $response = Curl::to($this->url."/mk/WSMKListaEstruturaEnderecos.rule?sys=MK0&token=".$token )
      ->get();
      return $response;
    }

    public function migrar($pessoa){
        $token = $this->mkAuth()["Token"];
        $string = "(85)987047679"; //preg_replace('/[^0-9]/', '', $string)

         $result = Curl::to($this->url."/mk/WSMKNovaPessoa.rule?sys=MK0".
        "&token=".$token.
        "&doc=".$pessoa->cpf_cnpj.
        "&nome=FulanoDeTal".//$pessoa->nome.
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
}
