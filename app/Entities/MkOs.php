<?php

namespace App\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MkOs.
 *
 * @package namespace App\Entities;
 */
class MkOs extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = 'pgsql';
    protected $table = "public.mk_os";
    protected $primaryKey = 'codos';
    protected $fillable = [];

    public function usuario()
    {
      return $this->belongsTo('App\Entities\MkPessoa', 'cliente', 'codpessoa');
    }

    public function osTipo()
    {
      return $this->belongsTo('App\Entities\MkOsTipo', 'tipo_os', 'codostipo');
    }
    public function classificacao()
    {
      return $this->belongsTo('App\Entities\MkOsClassificacaoEncerramento', 'classificacao_encerramento', 'codclassifenc');
    }
    public function logradouro()
    {
      return $this->belongsTo('App\Entities\MkLogradouro', 'cd_logradouro', 'codlogradouro');
    }
    public function mobileAtuStatus()
    {
      return $this->belongsTo('App\Entities\MkOsMobileAtuStatus', 'ultimo_status_app_mk', 'codosatustatus');
    }

    // MUTATORS
    public function getUltimoStatusAppMkTxAttribute($value)
    {
      if(Str::containsAll($value, ['Encerrando'])){
        $value = "ENC";
      }
      if(Str::containsAll($value, ['Iniciando'])){
        $value = "INI";
      }
      return $value;
    }


    public function getStatusAttribute($value)
    {
      switch ($value) {
        case '1':
          return "AGUARD";
          break;
        case '2':
          return "AGEND";
          break;
        case '3':
          return "ENCERR";
          break;

        default:
          return " ";
          break;
      }
    }
}
