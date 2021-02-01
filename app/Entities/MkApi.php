<?php

namespace App\Entities;

use Exception;
use Illuminate\Support\Str;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkApi.
 *
 * @package namespace App\Entities;
 */
class MkApi extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $url;
    protected $token;
    protected $fillable = [];

    public function __construct()
    {
      $this->url = env('WS_MK_URL');
    }

    public function getTokenAuth($username, $password){
        $response = Curl::to($this->url.'/mk/WSAutenticacaoOperador.rule?sys=MK0&username='.$username.'&password='.$password)
        ->asJsonResponse()
        ->get();
        return $response;
    }

    public function getToken(){
        $result = Curl::to($this->url.'/mk/WSAutenticacao.rule?sys=MK0&token='.$tokenAuth.'&password=3462570e1b53236&cd_servico=9999')
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
