<?php

namespace App\Entities;

use Exception;
use App\Entities\FrUsuario;
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
    protected $username;
    protected $password;
    protected $fillable = [];

    public function __construct()
    {
      $this->url = env('WS_MK_URL');
      $this->username = env('WS_MK_USER');
      $this->password = env('WS_MK_PASSWORD');
    }

    public function getTokenAuth(){
        $response = Curl::to($this->url.'/mk/WSAutenticacaoOperador.rule?sys=MK0&username='.$this->username.'&password='.$this->password)
        ->asJsonResponse()
        ->get();
        return $response->TokenAutenticacao;
    }

    public function getContraSenha(){
        $tokenAcesso = $this->getTokenAuth();
        $usuario =  FrUsuario::where('token_acesso', $tokenAcesso)->first();
        return $usuario->perfis->get(0)['contra_senha'];
    }

    public function getToken(){
        $contraSenha = $this->getContraSenha();
        $token = $this->getTokenAuth();
        $response = Curl::to($this->url.'/mk/WSAutenticacao.rule?sys=MK0&token='.$token.'&password='.$contraSenha.'&cd_servico=9999')
        ->asJsonResponse()
        ->get();
        return $response->Token;
    }

    public function createPessoa(){
        $token = $this->getToken();

         $result = Curl::to($this->url."/mk/WSMKNovaPessoa.rule?sys=MK0".
        "&token=".$token.
        "&doc=35676749350".//$pessoa->cpf_cnpj.
        "&nome=FULANO%20DE%20TALZ".//$pessoa->nome.
        "&cep=61946085".//$pessoa->cep.
        "&cd_uf=6".
        "&cd_cidade=19".
        "&cd_bairro=394".
        "&cd_logradouro=7277".
        "&numero=10".
        "&complemento=".
        "&cd_empresa=0".
        "&email=jnet@jnece.com.br".
        "&nascimento=22041979".
        "&fone=85988885555".//preg_replace('/[^0-9]/', '', $pessoa->fone).
        "&cd_revenda=16".
        "&lat=".
        "&lon="
        )
        ->get();
        return $result;
    }

    public function createAtendimento(){
      $token = $this->getToken();
      $response = Curl::to($this->url."/mk/WSMKNovoAtendimento.rule?sys=MK0&".
        "&token=".$token.
        "&cd_contrato=45069".
        "&cd_cliente=45800".
        "&cd_processo=9".
        "&cd_classificacao_ate=16".
        "&origem_contato=2".
        "&cd_grupo_visualizadores=2".
        "&info='TesteAtendimentoAvertoViaJservices'")
      ->get();
      return $response;
    
    }

}
