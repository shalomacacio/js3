<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Ixudra\Curl\Facades\Curl;

/**
 * Class Geogrid.
 *
 * @package namespace App\Entities;
 */
class Geogrid extends Model 
{

    protected $path;
    protected $key;
    protected $url;

    public function __construct(){
        $this->path = env('GEOGRID_PATH');
        $this->key = env('GEOGRID_TOKEN');
        $this->url = $this->path.'/api/v2/?exec='.$this->key;
    }
    
    public function getEquipamentosAttribute()
    {
        $endpoint='/fichaEquipamento/consultar';

        $response = Curl::to($this->url.$endpoint)
        ->asJson()
        ->get();
        $equipamentos = $response->registros;

        return $equipamentos;
    }  

}
