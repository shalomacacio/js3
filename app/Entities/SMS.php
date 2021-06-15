<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ixudra\Curl\Facades\Curl;

class SMS extends Model 
{
    protected $path;
    protected $key;
    protected $pass;

    public function __construct(){
        $this->user = env('MKM_USER');
        $this->pass = env('MKM_PASS');
        $this->path = env('MKM_PATH');
    }
    
    public function send($mensagem, $telefone )
    {
        $response = Curl::to($this->path)
        ->withData( array( 
            'modo' => 'envio',
            'empresa' => 'jnet',
            'usuario' => $this->user,
            'senha' => $this->pass,
            'centro_custo' => 'FINANCEIRO',
            'dataenvmlgdd' => Carbon::now()->format('Y-m-d H:i:s'),
            'mensagem' => $mensagem,
            'telefone' => $telefone
        ))
        ->asJson()
        ->get();
        return $response;
    }  
}
